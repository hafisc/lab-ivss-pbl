<?php
/**
 * Auth Controller
 * 
 * Mengelola otentikasi pengguna termasuk login, register, logout, dan reset password.
 * 
 * @package App\Controllers
 */
class AuthController
{
    /**
     * @var resource Koneksi database PostgreSQL
     */
    private $db;

    /**
     * Konstruktor
     * 
     * @param resource $db Koneksi database
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Menangani proses Login User
     * Melakukan verifikasi email dan password, serta mengatur sesi pengguna.
     * 
     * @return void
     */
    public function login()
    {
        // 1. Cek jika sudah login, redirect sesuai role
        if (isset($_SESSION['user_id'])) {
            $role = $_SESSION['role'] ?? 'guest';
            if (in_array($role, ['admin', 'dosen', 'ketua_lab'])) {
                header('Location: index.php?page=admin');
            } else if (in_array($role, ['member', 'mahasiswa'])) {
                header('Location: index.php?page=member');
            } else {
                header('Location: index.php?page=home');
            }
            exit;
        }

        // 2. Proses form submit (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validasi input kosong
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Email dan password harus diisi!';
                header('Location: index.php?page=login');
                exit;
            }

            // Query user dan role
            $query = "SELECT u.*, r.role_name FROM users u 
                      JOIN roles r ON u.role_id = r.id 
                      WHERE u.email = $1 LIMIT 1";
            $result = pg_query_params($this->db, $query, [$email]);

            if ($result && pg_num_rows($result) > 0) {
                $user = pg_fetch_assoc($result);

                // Verifikasi Hash Password
                if (password_verify($password, $user['password'])) {
                    
                    // Cek status user (pending/active)
                    // Khusus member/mahasiswa harus sudah diapprove
                    if (($user['role_name'] === 'member' || $user['role_name'] === 'mahasiswa') && $user['status'] === 'pending') {
                        $_SESSION['error'] = 'Akun Anda masih dalam proses review. Silakan tunggu notifikasi approval.';
                        header('Location: index.php?page=login');
                        exit;
                    }

                    // Set Data Session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['username'], // Username sementara, idealnya pakai nama asli dari tabel profile
                        'email' => $user['email'],
                        'role' => $user['role_name'],
                        'photo' => $user['photo'] ?? null
                    ];

                    // Session legacy untuk kompatibilitas
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role_name'];

                    $_SESSION['success'] = 'Login berhasil! Selamat datang kembali.';

                    // Redirect sesuai role
                    if (in_array($user['role_name'], ['admin', 'ketua_lab', 'dosen'])) {
                        header('Location: index.php?page=admin');
                    } else if (in_array($user['role_name'], ['member', 'mahasiswa'])) {
                        header('Location: index.php?page=member');
                    } else {
                        header('Location: index.php?page=home');
                    }
                    exit;
                } else {
                    // Password salah
                    $_SESSION['error'] = 'Email atau password salah!';
                }
            } else {
                // User tidak ditemukan
                $_SESSION['error'] = 'Email atau password salah!';
            }

            header('Location: index.php?page=login');
            exit;
        }

        // 3. Tampilkan halaman login
        $authView = 'login';
        include __DIR__ . '/../../view/layouts/auth.php';
    }

    /**
     * Menangani proses Registrasi Member Baru
     * Menyimpan data pendaftar dan mengirim notifikasi email.
     * 
     * @return void
     */
    public function register()
    {
        // 1. Cek jika sudah login (skip register)
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=home');
            exit;
        }

        // 2. Proses form submit (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Simpan input lama agar form tidak kosong jika error
            $_SESSION['old'] = $_POST;
            unset($_SESSION['old']['password']); // Jangan simpan password plain text di session
            unset($_SESSION['old']['password_confirm']);

            // Sanitasi Input
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $nim = trim($_POST['nim'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $angkatan = trim($_POST['angkatan'] ?? '');
            $origin = trim($_POST['origin'] ?? '');
            $research_title = trim($_POST['research_title'] ?? '');
            $supervisor_id = trim($_POST['supervisor_id'] ?? '');
            $motivation = trim($_POST['motivation'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // --- Validasi Input ---
            
            // Validasi Kelengkapan Data
            if (empty($name) || empty($email) || empty($nim) || empty($angkatan) || empty($origin) ||
                empty($research_title) || empty($supervisor_id) || empty($motivation) || 
                empty($password) || empty($password_confirm)) {
                
                $_SESSION['error'] = 'Mohon lengkapi semua field yang tersedia!';
                header('Location: index.php?page=register');
                exit;
            }

            // Validasi Email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Format email tidak valid!';
                header('Location: index.php?page=register');
                exit;
            }

            // Validasi Panjang Password
            if (strlen($password) < 8) {
                $_SESSION['error'] = 'Password minimal 8 karakter!';
                header('Location: index.php?page=register');
                exit;
            }

            // Validasi Kesamaan Password
            if ($password !== $password_confirm) {
                $_SESSION['error'] = 'Konfirmasi password tidak cocok!';
                header('Location: index.php?page=register');
                exit;
            }

            // Validasi Panjang Motivasi
            if (strlen($motivation) < 50) {
                $_SESSION['error'] = 'Motivasi minimal 50 karakter agar kami bisa mengenal Anda lebih baik!';
                header('Location: index.php?page=register');
                exit;
            }

            // --- Cek Duplikasi Data ---

            // Cek apakah email sudah terdaftar (sebagai user aktif)
            $checkUser = @pg_query_params($this->db, "SELECT id FROM users WHERE email = $1 LIMIT 1", [$email]);
            if ($checkUser && pg_num_rows($checkUser) > 0) {
                $_SESSION['error'] = 'Email sudah terdaftar sebagai user aktif!';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Cek apakah email sudah terdaftar (sebagai pendaftar pending)
            // Kecuali yang statusnya rejected, boleh daftar lagi
            $checkReg = @pg_query_params($this->db, 
                "SELECT id FROM member_registrations WHERE email = $1 AND status NOT IN ('rejected_supervisor', 'rejected_lab_head') LIMIT 1", 
                [$email]
            );
            if ($checkReg && pg_num_rows($checkReg) > 0) {
                $_SESSION['error'] = 'Email ini sedang dalam proses pendaftaran.';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Cek duplikasi NIM
            $checkNim = @pg_query_params($this->db, "SELECT id FROM mahasiswa WHERE nim = $1 LIMIT 1", [$nim]);
            if ($checkNim && pg_num_rows($checkNim) > 0) {
                $_SESSION['error'] = 'NIM sudah terdaftar dalam sistem!';
                header('Location: index.php?page=register');
                exit;
            }

            // --- Proses Simpan Data ---

            require_once __DIR__ . '/../models/member.php';
            $memberModel = new Member($this->db);

            $registrationData = [
                'name' => $name,
                'email' => $email,
                'nim' => $nim,
                'phone' => $phone,
                'angkatan' => $angkatan,
                'origin' => $origin,
                'password' => $password, // Password akan di-hash di dalam model
                'research_title' => $research_title,
                'supervisor_id' => $supervisor_id,
                'motivation' => $motivation
            ];

            // Panggil fungsi register di model
            $registrationId = $memberModel->register($registrationData);

            if ($registrationId) {
                // --- Kirim Notifikasi (Email Simulation) ---
                
                // Ambil data supervisor untuk notifikasi
                $supQ = "SELECT u.email, d.nama FROM users u JOIN dosen d ON u.id = d.user_id WHERE u.id = $1";
                $supRes = @pg_query_params($this->db, $supQ, [$supervisor_id]);
                $supervisor = ($supRes) ? pg_fetch_assoc($supRes) : null;

                // Logika pengiriman email ada di Helper (opsional, jika ada library email)
                // Di sini kita simulasikan sukses
                
                $_SESSION['success'] = 'Pendaftaran berhasil dikirim! Silakan tunggu notifikasi konfirmasi dari Dosen Pembimbing melalui email.';
                
                // Bersihkan old session input
                unset($_SESSION['old']);
                
                header('Location: ./index.php?page=login');
                exit;
            } else {
                $_SESSION['error'] = 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi.';
                header('Location: index.php?page=register');
                exit;
            }
        }

        // 3. Tampilkan halaman registrasi
        // Ambil data dosen untuk dropdown
        $supervisors = [];
        $dosenQuery = "SELECT id, nama, nip FROM view_dosen ORDER BY nama ASC";
        $dosenRes = @pg_query($this->db, $dosenQuery);
        
        if ($dosenRes) {
            while ($row = pg_fetch_assoc($dosenRes)) {
                $supervisors[] = $row; // Format: id, nama, nip
            }
        }

        $authView = 'register';
        include __DIR__ . '/../../view/layouts/auth.php';
    }

    /**
     * Menangani lupa password (Forgot Password)
     * Mengirim link reset password via email (Simulasi).
     * 
     * @return void
     */
    public function forgotPassword()
    {
        // 1. Cek jika sudah login, redirect
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=home');
            exit;
        }

        // 2. Proses form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Masukkan alamat email yang valid!';
                header('Location: ./index.php?page=forgot-password');
                exit;
            }

            // Cek keberadaan email
            $query = "SELECT id FROM users WHERE email = $1 LIMIT 1";
            $res = @pg_query_params($this->db, $query, [$email]);

            if ($res && pg_num_rows($res) > 0) {
                // Email ditemukan.
                // TODO: Generate Token & Kirim Email Reset.
                $_SESSION['success'] = 'Instruksi reset password telah dikirim ke email Anda.';
            } else {
                // Email tidak ditemukan (tetap tampilkan sukses untuk keamanan / privacy)
                $_SESSION['success'] = 'Jika email terdaftar, instruksi reset password akan dikirimkan.';
            }

            header('Location: ./index.php?page=forgot-password');
            exit;
        }

        // 3. Tampilkan halaman lupa password
        $authView = 'forgot_password';
        include __DIR__ . '/../../view/layouts/auth.php';
    }

    /**
     * Menangani proses Logout
     * Menghapus sesi dan mengarahkan pengguna kembali ke halaman utama.
     * 
     * @return void
     */
    public function logout()
    {
        // Hapus semua data sesi
        session_unset();
        session_destroy();
        
        // Redirect ke home
        header('Location: ./index.php?page=home');
        exit;
    }
}

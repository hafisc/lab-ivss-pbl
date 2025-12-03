<?php
// Session sudah di-start di index.php

class AuthController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            $role = $_SESSION['role'];
            if ($role === 'admin' || $role === 'dosen' || $role === 'ketua_lab') {
                header('Location: /Lab%20ivss/public/index.php?page=admin');
            } else if ($role === 'member') {
                header('Location: /Lab%20ivss/public/index.php?page=member');
            } else {
                header('Location: /Lab%20ivss/public/index.php?page=home');
            }
            exit;
        }

        // Proses login jika form disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Email dan password harus diisi!';
                header('Location: ./index.php?page=login');
                exit;
            }

            // Query user berdasarkan email (include role name)
            $query = "SELECT u.*, r.role_name AS role FROM users u LEFT JOIN roles r ON r.id = u.role_id WHERE u.email = $1 LIMIT 1";
            
            // Query user berdasarkan email dengan join ke tabel roles
            $query = "SELECT u.*, r.role_name FROM users u 
                      JOIN roles r ON u.role_id = r.id 
                      WHERE u.email = $1 LIMIT 1";
            $result = pg_query_params($this->db, $query, [$email]);

            if ($result && pg_num_rows($result) > 0) {
                $user = pg_fetch_assoc($result);

                // Verifikasi password
                if (password_verify($password, $user['password'])) {
                    // Update last_login via stored procedure
                    @pg_query_params($this->db, "CALL update_last_login($1)", [$user['id']]);

                    // Cek status untuk member
                    if ($user['role'] === 'member' && $user['status'] === 'pending') {
                    // Cek status untuk member/mahasiswa
                    if (($user['role_name'] === 'member' || $user['role_name'] === 'mahasiswa') && $user['status'] === 'pending') {
                        $_SESSION['error'] = 'Akun Anda masih dalam proses review. Silakan tunggu approval dari dosen pembimbing.';
                        header('Location: ./index.php?page=login');
                        exit;
                    }

                    // Set session - Format nested untuk konsistensi
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        // some schemas store full name in 'name' else fallback to 'username'
                        'name' => $user['name'] ?? $user['username'] ?? null,
                        'email' => $user['email'],
                        'role' => $user['role'] ?? null,
                        'nim' => $user['nim'] ?? null,
                        'photo' => $user['photo'] ?? null
                    ];

                    // Backward compatibility (untuk code lama yang masih pakai format flat)
                        'name' => $user['username'], // Menggunakan username karena kolom name tidak ada di tabel users (adanya di tabel terkait)
                        'email' => $user['email'],
                        'role' => $user['role_name'],
                        'photo' => $user['photo'] ?? null
                    ];
                    
                    // Backward compatibility
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    $_SESSION['success'] = 'Login berhasil!';

                    // Redirect berdasarkan role (gunakan relative path)
                    if ($user['role'] === 'admin' || $user['role'] === 'ketua_lab' || $user['role'] === 'dosen') {
                        header('Location: ./index.php?page=admin');
                    } else if ($user['role'] === 'member') {
                        header('Location: ./index.php?page=member');
                    $_SESSION['role'] = $user['role_name'];
                    
                    $_SESSION['success'] = 'Login berhasil!';
                    
                    // Redirect berdasarkan role ke dashboard masing-masing
                    if ($user['role_name'] === 'admin' || $user['role_name'] === 'ketua_lab' || $user['role_name'] === 'dosen') {
                        header('Location: /Lab%20ivss/public/index.php?page=admin');
                    } else if ($user['role_name'] === 'member' || $user['role_name'] === 'mahasiswa') {
                        header('Location: /Lab%20ivss/public/index.php?page=member');
                    } else {
                        // Fallback ke home jika role tidak dikenali
                        header('Location: /Lab%20ivss/public/index.php?page=home');
                    }
                    exit;
                } else {
                    $_SESSION['error'] = 'Email atau password salah!';
                }
            } else {
                $_SESSION['error'] = 'Email atau password salah!';
            }

            header('Location: index.php?page=login');
            
            header('Location: /Lab%20ivss/public/index.php?page=login');
            exit;
        }

        // Tampilkan halaman login
        $authView = 'login';
        include __DIR__ . '/../../view/layouts/auth.php';
    }

    public function register()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            $role = $_SESSION['role'];
            if ($role === 'admin' || $role === 'dosen' || $role === 'ketua_lab') {
                header('Location: ./index.php?page=admin');
            } else if ($role === 'member') {
                header('Location: ./index.php?page=member');
            }
            exit;
        }

        // Proses register jika form disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data biodata
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $nim = trim($_POST['nim'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $angkatan = trim($_POST['angkatan'] ?? '');
            $origin = trim($_POST['origin'] ?? '');

            // Ambil data penelitian
            $research_title = trim($_POST['research_title'] ?? '');
            $supervisor_id = trim($_POST['supervisor_id'] ?? '');
            $motivation = trim($_POST['motivation'] ?? '');

            // Ambil data password
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Validasi input wajib
            if (empty($name) || empty($email) || empty($nim) || empty($angkatan) || empty($origin)) {
                $_SESSION['error'] = 'Data biodata wajib diisi lengkap!';
                header('Location: ./index.php?page=register');
                exit;
            }

            if (empty($research_title) || empty($supervisor_id) || empty($motivation)) {
                $_SESSION['error'] = 'Informasi penelitian wajib diisi lengkap!';
                header('Location: ./index.php?page=register');
                exit;
            }

            if (empty($password) || empty($password_confirm)) {
                $_SESSION['error'] = 'Password wajib diisi!';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Validasi format email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Format email tidak valid!';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Validasi panjang password
            if (strlen($password) < 8) {
                $_SESSION['error'] = 'Password minimal 8 karakter!';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Validasi password cocok
            if ($password !== $password_confirm) {
                $_SESSION['error'] = 'Password dan konfirmasi password tidak cocok!';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Validasi motivasi minimal 50 karakter
            if (strlen($motivation) < 50) {
                $_SESSION['error'] = 'Motivasi minimal 50 karakter!';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Cek apakah email sudah terdaftar di users
            $checkQuery = "SELECT id FROM users WHERE email = $1 LIMIT 1";
            $checkResult = @pg_query_params($this->db, $checkQuery, [$email]);

            if ($checkResult && pg_num_rows($checkResult) > 0) {
                $_SESSION['error'] = 'Email sudah terdaftar! Gunakan email lain.';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Cek apakah email sudah mengajukan pendaftaran
            $checkRegQuery = "SELECT id FROM member_registrations WHERE email = $1 AND status NOT IN ('rejected_supervisor', 'rejected_lab_head') LIMIT 1";
            $checkRegResult = @pg_query_params($this->db, $checkRegQuery, [$email]);

            if ($checkRegResult && pg_num_rows($checkRegResult) > 0) {
                $_SESSION['error'] = 'Email sudah pernah mengajukan pendaftaran. Silakan tunggu proses review.';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Cek apakah NIM sudah terdaftar
            $checkNimQuery = "SELECT id FROM users WHERE nim = $1 LIMIT 1";
            $checkNimResult = @pg_query_params($this->db, $checkNimQuery, [$nim]);

            if ($checkNimResult && pg_num_rows($checkNimResult) > 0) {
                $_SESSION['error'] = 'NIM sudah terdaftar! Gunakan NIM lain.';
                header('Location: ./index.php?page=register');
                exit;
            }

            // Ambil data dosen pengampu
            $supervisorQuery = "SELECT id, name, email FROM users WHERE id = $1 AND role = 'dosen' LIMIT 1";
            $supervisorResult = @pg_query_params($this->db, $supervisorQuery, [$supervisor_id]);

            if (!$supervisorResult || pg_num_rows($supervisorResult) === 0) {
                $_SESSION['error'] = 'Dosen pengampu tidak valid!';
                header('Location: ./index.php?page=register');
                exit;
            }

            $supervisor = pg_fetch_assoc($supervisorResult);

            // Ambil data ketua lab untuk notifikasi
            $labHeadQuery = "SELECT id, name, email FROM users WHERE role = 'ketua_lab' LIMIT 1";
            $labHeadResult = @pg_query($this->db, $labHeadQuery);
            $labHead = ($labHeadResult && pg_num_rows($labHeadResult) > 0) ? pg_fetch_assoc($labHeadResult) : null;

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert ke tabel member_registrations
            $insertQuery = "INSERT INTO member_registrations 
                           (name, email, nim, phone, angkatan, origin, password, research_title, supervisor_id, motivation, status, created_at) 
                           VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, 'pending_supervisor', NOW()) RETURNING id";
            $insertResult = @pg_query_params($this->db, $insertQuery, [
                $name,
                $email,
                $nim,
                $phone,
                $angkatan,
                $origin,
                $hashedPassword,
                $research_title,
                $supervisor_id,
                $motivation
            ]);

            if ($insertResult) {
                $registration = pg_fetch_assoc($insertResult);

            require_once __DIR__ . '/../models/member.php';
            $memberModel = new Member($this->db);
            
            $registrationData = [
                'name' => $name,
                'email' => $email,
                'nim' => $nim,
                'phone' => $phone,
                'angkatan' => $angkatan,
                'origin' => $origin,
                'password' => $password, // Model will hash it
                'research_title' => $research_title,
                'supervisor_id' => $supervisor_id,
                'motivation' => $motivation
            ];

            $registrationId = $memberModel->register($registrationData);
            
            if ($registrationId) {
                // Load Email Helper
                require_once __DIR__ . '/../helpers/EmailHelper.php';

                // Siapkan data untuk email
                $emailData = [
                    'name' => $name,
                    'email' => $email,
                    'nim' => $nim,
                    'angkatan' => $angkatan,
                    'origin' => $origin,
                    'research_title' => $research_title,
                    'motivation' => nl2br(htmlspecialchars($motivation))
                ];

                // Kirim email ke dosen pengampu
                $emailSent = EmailHelper::sendSupervisorNotification(
                    $supervisor['email'],
                    $supervisor['name'],
                    $emailData
                );

                // Kirim email ke ketua lab sebagai notifikasi info
                if ($labHead) {
                    EmailHelper::sendLabHeadNotification(
                        $labHead['email'],
                        $labHead['name'],
                        $emailData,
                        $supervisor['name']
                    );
                }

                // Kirim email konfirmasi ke mahasiswa
                EmailHelper::sendStudentConfirmation(
                    $email,
                    $name,
                    $supervisor['name']
                );

                $_SESSION['success'] = 'Pendaftaran berhasil diajukan! Notifikasi telah dikirim ke ' . $supervisor['name'] . ' dan Ketua Lab. Silakan cek email Anda untuk informasi lebih lanjut.';
                header('Location: ./index.php?page=login');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal melakukan pendaftaran! Silakan coba lagi.';
                header('Location: ./index.php?page=register');
                exit;
            }
        }

        // Tampilkan halaman register
        // Ambil daftar dosen (supervisors) dari view database untuk form
        $supervisors = [];
        $supervisorListQuery = "SELECT id, name, nip, origin FROM view_dosen ORDER BY name";
        $supRes = @pg_query($this->db, $supervisorListQuery);
        if ($supRes && pg_num_rows($supRes) > 0) {
            while ($row = pg_fetch_assoc($supRes)) {
                $supervisors[] = $row;
            }
        }

        $authView = 'register';
        include __DIR__ . '/../../view/layouts/auth.php';
    }

    public function forgotPassword()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            $role = $_SESSION['role'];
            if ($role === 'admin' || $role === 'dosen' || $role === 'ketua_lab') {
                header('Location: ./index.php?page=admin');
            } else if ($role === 'member') {
                header('Location: ./index.php?page=member');
            }
            exit;
        }

        // Proses forgot password jika form disubmit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            // Validasi email
            if (empty($email)) {
                $_SESSION['error'] = 'Email wajib diisi!';
                header('Location: ./index.php?page=forgot-password');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Format email tidak valid!';
                header('Location: ./index.php?page=forgot-password');
                exit;
            }

            // Cek apakah email terdaftar
            $checkQuery = "SELECT id, name FROM users WHERE email = $1 LIMIT 1";
            $checkResult = @pg_query_params($this->db, $checkQuery, [$email]);

            if ($checkResult && pg_num_rows($checkResult) > 0) {
                $user = pg_fetch_assoc($checkResult);

                // TODO: Generate reset token dan kirim email
                // Untuk saat ini, hanya tampilkan success message
                // Di production, implement:
                // 1. Generate unique token
                // 2. Simpan token ke database dengan expiry time
                // 3. Kirim email dengan link reset

                $_SESSION['success'] = 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau spam folder.';
            } else {
                // Tetap tampilkan success message meskipun email tidak ditemukan
                // (Security best practice: jangan kasih tahu apakah email terdaftar atau tidak)
                $_SESSION['success'] = 'Jika email terdaftar, link reset password akan dikirim ke email Anda.';
            }

            header('Location: ./index.php?page=forgot-password');
            exit;
        }

        // Tampilkan halaman forgot password
        $authView = 'forgot-password';
        include __DIR__ . '/../../view/layouts/auth.php';
    }

    public function logout()
    {
        // Session sudah di-start di index.php
        session_destroy();
        header('Location: ./index.php?page=home');
        exit;
    }
}

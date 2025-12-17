<?php
/**
 * Member Controller
 * 
 * Mengelola logika untuk area Member (Dashboard, Registrasi, Pengajuan Riset, Profil).
 * Menghubungkan View Member dengan Model Database.
 * 
 * @package App\Controllers
 */

require_once __DIR__ . '/../models/member.php';

class MemberController
{
    /**
     * @var Member Instance model Member
     */
    private $memberModel;

    /**
     * @var resource Koneksi database PostgreSQL
     */
    private $db;

    /**
     * Konstruktor
     * 
     * @param resource|null $db Koneksi database (opsional, jika null akan buat baru)
     */
    public function __construct($db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            // Fallback koneksi jika tidak di-inject
            $this->db = Database::getInstance()->getConnection();
        }
        
        // Inisialisasi Model Member
        $this->memberModel = new Member($this->db);
    }

    /**
     * Menampilkan Dashboard Member
     * Menampilkan status keanggotaan, info supervisor, dan ringkasan aktivitas.
     * 
     * @return void
     */
    public function dashboard()
    {
        // 1. Cek sesi login
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }
        
        // 2. Inisialisasi variabel tampilan
        $totalMyResearch = 0;
        $totalMyPublications = 0;
        $currentMemberStatus = 'aktif';
        $supervisorInfo = null;
        $myResearches = [];

        // 3. Ambil data real dari database
        //    Join users -> mahasiswa untuk dapat info detail
        $query = "SELECT u.status, m.supervisor_id, m.research_title, m.nama
                  FROM users u 
                  LEFT JOIN mahasiswa m ON u.id = m.user_id 
                  WHERE u.id = $1";
                  
        $res = @pg_query_params($this->db, $query, [$userId]);
        
        if ($res && pg_num_rows($res) > 0) {
            $userData = pg_fetch_assoc($res);
            $currentMemberStatus = $userData['status'] ?? 'inactive';

            // Ambil Info Supervisor (Dosen Pembimbing)
            if (!empty($userData['supervisor_id'])) {
                // Relasi: mahasiswa.supervisor_id -> users.id (melalui role check atau tabel dosen)
                // Asumsi supervisor_id di tabel mahasiswa merujuk ke tabel users ID dosen
                $sQuery = "SELECT u.username as name, u.email 
                           FROM users u 
                           WHERE u.id = $1"; 
                           
                $sRes = @pg_query_params($this->db, $sQuery, [$userData['supervisor_id']]);
                if ($sRes && pg_num_rows($sRes) > 0) {
                    $supervisorInfo = pg_fetch_assoc($sRes);
                }
            }

            // Ambil Riset (Sementara ambil dari judul TA)
            if (!empty($userData['research_title'])) {
                $myResearches[] = [
                    'title' => $userData['research_title'],
                    'category' => 'Tugas Akhir',
                    'leader_name' => $userData['nama'] ?? 'Saya',
                    'status' => 'active'
                ];
            }
            $totalMyResearch = count($myResearches);
            
            // Hitung publikasi (Placeholder)
            $totalMyPublications = 0;
        }
        
        // 4. Render View Dashboard
        require_once __DIR__ . '/../../view/member/dashboard.php';
    }

    /**
     * Proses Registrasi Member Baru
     * Menerima input form dan menyimpannya via MemberModel.
     * 
     * @return void|string
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kumpulkan data post
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'nim' => $_POST['nim'],
                'phone' => $_POST['phone'],
                'angkatan' => $_POST['angkatan'],
                'origin' => $_POST['origin'],
                'password' => $_POST['password'],
                'research_title' => $_POST['research_title'],
                'supervisor_id' => $_POST['supervisor_id'],
                'motivation' => $_POST['motivation']
            ];

            // Panggil model
            $id = $this->memberModel->register($data);

            if ($id) {
                // Redirect sukses
                header('Location: /index.php?page=registration_success');
                exit;
            } else {
                return "Registrasi gagal";
            }
        }
    }

    /**
     * Ambil data pendaftaran pending (untuk Dosen/Ka.Lab)
     * Wrapper untuk method model.
     * 
     * @param int $supervisor_id ID Supervisor
     * @return array
     */
    public function getPendingRegistrations($supervisor_id)
    {
        return $this->memberModel->getPendingBySupervisor($supervisor_id);
    }

    /**
     * Proses Approval Pendaftaran
     * 
     * @param int $id ID Registrasi
     * @param string $role Role approver ('dosen' atau 'ketua_lab')
     * @param string|null $notes Catatan opsional
     * @return bool Sukses/Gagal
     */
    public function approveRegistration($id, $role, $notes = null)
    {
        if ($role === 'dosen') {
            return $this->memberModel->approveBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->approveByLabHead($id, $notes);
        }
        return false;
    }

    /**
     * Proses Penolakan Pendaftaran
     * 
     * @param int $id ID Registrasi
     * @param string $role Role rejector
     * @param string $notes Alasan penolakan
     * @return bool Sukses/Gagal
     */
    public function rejectRegistration($id, $role, $notes)
    {
        if ($role === 'dosen') {
            return $this->memberModel->rejectBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->rejectByLabHead($id, $notes);
        }
        return false;
    }

    /**
     * Menampilkan Halaman Profil Member
     * Mengambil data gabungan dari tabel `users` dan `member_registrations` (atau `mahasiswa`).
     * 
     * @return void
     */
    public function profile()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }

        // Ambil data user dasar
        $query = "SELECT u.id, u.username, u.email, u.status, u.photo, u.created_at
                  FROM users u WHERE u.id = $1 LIMIT 1";
        $res = @pg_query_params($this->db, $query, array($userId));
        $user = ($res && pg_num_rows($res) > 0) ? pg_fetch_assoc($res) : null;

        // Jika ada detail tambahan di pendaftaran/mahasiswa, ambil juga
        $extra = null;
        if (!empty($user['email'])) {
            // Cek tabel pendaftaran dulu (karena data lengkap ada di sana saat daftar)
            $q2 = "SELECT * FROM member_registrations WHERE email = $1 LIMIT 1";
            $r2 = @pg_query_params($this->db, $q2, array($user['email']));
            if ($r2 && pg_num_rows($r2) > 0) {
                $extra = pg_fetch_assoc($r2);
            }
        }

        $profileUser = $user ?: [];
        $profileExtra = $extra ?: [];

        // Gabungkan data untuk view ($me)
        $me = array_merge([
            'name' => $profileUser['username'] ?? $profileExtra['name'] ?? '',
            'email' => $profileUser['email'] ?? $profileExtra['email'] ?? '',
            'nim' => $profileExtra['nim'] ?? $profileUser['nim'] ?? '',
            'angkatan' => $profileExtra['angkatan'] ?? $profileUser['angkatan'] ?? '',
            'origin' => $profileExtra['origin'] ?? $profileUser['origin'] ?? '',
            'phone' => $profileExtra['phone'] ?? $profileUser['phone'] ?? '',
            'status_lab' => $profileExtra['status'] ?? $profileUser['status'] ?? 'aktif'
        ], $profileExtra);

        // Render View
        include __DIR__ . '/../../view/member/settings/index.php';
    }

    /**
     * Menampilkan Form Edit Profil
     */
    public function editProfile()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }

        // Ambil data current record
        $query = "SELECT id, username, email, photo FROM users WHERE id = $1 LIMIT 1";
        $res = @pg_query_params($this->db, $query, array($userId));
        $user = ($res && pg_num_rows($res) > 0) ? pg_fetch_assoc($res) : null;

        // Siapkan variabel $me
        $me = [
            'name' => $user['username'] ?? '',
            'email' => $user['email'] ?? '',
            // Field lain sementara kosong jika tidak ada di tabel users
            'nim' => $user['nim'] ?? '',
            'phone' => $user['phone'] ?? '',
            'angkatan' => $user['angkatan'] ?? '',
            'origin' => $user['origin'] ?? ''
        ];

        include __DIR__ . '/../../view/member/settings/edit.php';
    }

    /**
     * Proses Update Profil (POST)
     */
    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=member-profile');
            exit;
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        // Validasi
        if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Nama dan email wajib diisi dengan format valid.';
            header('Location: index.php?page=member-settings-edit');
            exit;
        }

        // Update Database
        $query = "UPDATE users SET username = $1, email = $2 WHERE id = $3";
        $res = @pg_query_params($this->db, $query, array($name, $email, $userId));

        if ($res) {
            $_SESSION['success'] = 'Profil berhasil diperbarui.';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil.';
        }

        header('Location: index.php?page=member-profile');
        exit;
    }

    /**
     * Menampilkan Form Ganti Password
     */
    public function changePassword()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }
        include __DIR__ . '/../../view/member/settings/change-password.php';
    }

    /**
     * Proses Submit Ganti Password (POST)
     */
    public function submitChangePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=member-change-password');
            exit;
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }

        $current = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // Validasi
        if (empty($new) || strlen($new) < 8 || $new !== $confirm) {
            $_SESSION['error'] = 'Password baru harus minimal 8 karakter dan cocok dengan konfirmasi.';
            header('Location: index.php?page=member-settings-change-password');
            exit;
        }

        // Cek password lama
        $q = "SELECT password FROM users WHERE id = $1 LIMIT 1";
        $r = @pg_query_params($this->db, $q, array($userId));
        $row = ($r && pg_num_rows($r) > 0) ? pg_fetch_assoc($r) : null;

        if (!$row || !password_verify($current, $row['password'])) {
            $_SESSION['error'] = 'Password saat ini salah.';
            header('Location: index.php?page=member-settings-change-password');
            exit;
        }

        // Update password baru
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $uq = "UPDATE users SET password = $1 WHERE id = $2";
        $ur = @pg_query_params($this->db, $uq, array($hashed, $userId));

        if ($ur) {
            $_SESSION['success'] = 'Password berhasil diubah.';
        } else {
            $_SESSION['error'] = 'Gagal mengubah password.';
        }

        header('Location: index.php?page=member-profile');
        exit;
    }
}

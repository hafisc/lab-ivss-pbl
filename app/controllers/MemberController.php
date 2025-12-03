<?php

class MemberController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function dashboard()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Dashboard Member';

        // Ambil statistik member
        $totalMyResearch = $this->getTotalMyResearch($userId);
        $totalMyUploads = $this->getTotalMyUploads($userId);
        $currentMemberStatus = $this->getMemberStatus($userId);

        // Ambil daftar riset untuk member ini
        $myResearches = $this->getMyResearches($userId);

        // Kirim data ke view
        include __DIR__ . '/../../view/member/dashboard.php';
    }

    public function upload()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Upload Dokumen';

        // Tangani submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: Implementasi logic upload file
            $_SESSION['success'] = 'File berhasil di-upload!';
            header('Location: index.php?page=member-upload');
            exit;
        }

        // Ambil daftar riset untuk member ini
        $myResearches = $this->getMyResearches($userId);

        // Kirim data ke view
        include __DIR__ . '/../../view/member/upload.php';
    }

    public function attendance()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Absensi Saya';

        // Ambil riwayat absensi
        $myAttendances = $this->getMyAttendances($userId);

        // Kirim data ke view
        include __DIR__ . '/../../view/member/attendance.php';
    }

    public function profile()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Profil Saya';

        // Ambil data profil member
        $me = $this->getMemberProfile($userId);

        // Kirim data ke view (new location: settings/index.php)
        include __DIR__ . '/../../view/member/settings/index.php';
    }

    public function editProfile()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Edit Profil';

        // Ambil data profil member untuk form
        $me = $this->getMemberProfileFull($userId);

        // Kirim data ke view
        include __DIR__ . '/../../view/member/settings/edit.php';
    }

    public function updateProfile()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;

        // Validasi request method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=member-settings');
            exit;
        }

        // Ambil data dari form
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $nim = $_POST['nim'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $angkatan = $_POST['angkatan'] ?? '';
        $origin = $_POST['origin'] ?? '';

        // Validasi required fields
        if (empty($name) || empty($email) || empty($nim) || empty($angkatan)) {
            $_SESSION['error'] = 'Nama, Email, NIM, dan Angkatan wajib diisi!';
            header('Location: index.php?page=member-settings-edit');
            exit;
        }

        // Check email uniqueness (exclude current user)
        $checkQuery = "SELECT id FROM users WHERE email = $1 AND id != $2";
        $checkResult = @pg_query_params($this->db, $checkQuery, [$email, $userId]);
        if ($checkResult && pg_num_rows($checkResult) > 0) {
            $_SESSION['error'] = 'Email sudah digunakan oleh user lain!';
            header('Location: index.php?page=member-settings-edit');
            exit;
        }

        // Update profile
        $query = "UPDATE users 
                  SET name = $1, 
                      email = $2, 
                      nim = $3, 
                      phone = $4, 
                      angkatan = $5, 
                      origin = $6,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = $7";

        $result = @pg_query_params($this->db, $query, [
            $name,
            $email,
            $nim,
            $phone ?: null,
            $angkatan,
            $origin ?: null,
            $userId
        ]);

        if ($result) {
            // Update session data
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            if (isset($_SESSION['user'])) {
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
            }

            $_SESSION['success'] = 'Profil berhasil diperbarui!';
            header('Location: index.php?page=member-settings');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui profil: ' . pg_last_error($this->db);
            header('Location: index.php?page=member-settings-edit');
        }
        exit;
    }

    public function changePassword()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Ubah Password';

        // Ambil data profil member untuk sidebar
        $me = $this->getMemberProfile($userId);

        // Kirim data ke view
        include __DIR__ . '/../../view/member/settings/change-password.php';
    }

    public function submitChangePassword()
    {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;

        // Validasi request method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=member-settings');
            exit;
        }

        // Ambil data dari form
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validasi required fields
        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Semua field wajib diisi!';
            header('Location: index.php?page=member-change-password');
            exit;
        }

        // Validasi password baru minimal 6 karakter
        if (strlen($newPassword) < 6) {
            $_SESSION['error'] = 'Password baru minimal 6 karakter!';
            header('Location: index.php?page=member-change-password');
            exit;
        }

        // Validasi password baru dan konfirmasi match
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Password baru dan konfirmasi tidak cocok!';
            header('Location: index.php?page=member-change-password');
            exit;
        }

        // Ambil password lama dari database
        $query = "SELECT password FROM users WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$userId]);

        if (!$result || pg_num_rows($result) === 0) {
            $_SESSION['error'] = 'User tidak ditemukan!';
            header('Location: index.php?page=member-change-password');
            exit;
        }

        $user = pg_fetch_assoc($result);

        // Verifikasi password lama
        if (!password_verify($oldPassword, $user['password'])) {
            $_SESSION['error'] = 'Password lama tidak sesuai!';
            header('Location: index.php?page=member-change-password');
            exit;
        }

        // Hash password baru
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update password di database
        $updateQuery = "UPDATE users 
                       SET password = $1, 
                           updated_at = CURRENT_TIMESTAMP
                       WHERE id = $2";

        $updateResult = @pg_query_params($this->db, $updateQuery, [
            $hashedPassword,
            $userId
        ]);

        if ($updateResult) {
            $_SESSION['success'] = 'Password berhasil diubah!';
            header('Location: index.php?page=member-settings');
        } else {
            $_SESSION['error'] = 'Gagal mengubah password: ' . pg_last_error($this->db);
            header('Location: index.php?page=member-change-password');
        }
        exit;
    }

    // Method pembantu
    private function getTotalMyResearch($userId)
    {
        // TODO: Hitung riset dimana user adalah member
        // Untuk saat ini, return data sample
        return 2;
    }

    private function getTotalMyUploads($userId)
    {
        // TODO: Hitung upload oleh user
        // Untuk saat ini, return data sample
        return 5;
    }

    private function getMemberStatus($userId)
    {
        $query = "SELECT status FROM users WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$userId]);

        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            return $row['status'] ?? 'aktif';
        }

        return 'aktif';
    }

    private function getMyResearches($userId)
    {
        // TODO: Ambil riset dimana user adalah anggota tim
        // Untuk saat ini, return data sample dari tabel research
        $query = "SELECT r.*, u.username as leader_name 
          FROM research r 
          LEFT JOIN users u ON r.leader_id = u.id 
          WHERE r.status = 'active' 
          LIMIT 3";
        $result = @pg_query($this->db, $query);
        $researches = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $researches[] = $row;
            }
        }

        return $researches;
    }

    private function getMyAttendances($userId)
    {
        // TODO: Ambil record absensi untuk user
        // Untuk saat ini, return data sample
        return [
            [
                'date' => date('Y-m-d'),
                'time' => '09:30',
                'method' => 'QR Code',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-2 days')),
                'time' => '14:15',
                'method' => 'Manual',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-5 days')),
                'time' => '10:00',
                'method' => 'QR Code',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-7 days')),
                'time' => '13:45',
                'method' => 'QR Code',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-10 days')),
                'time' => '08:30',
                'method' => 'Manual',
                'room' => 'Lab IVSS'
            ]
        ];
    }

    private function getMemberProfile($userId)
    {
        $query = "SELECT * FROM users WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$userId]);

        if ($result && pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);
            return [
                'name' => $user['name'],
                'email' => $user['email'],
                'nim' => $user['nim'] ?? '-',
                'angkatan' => $user['angkatan'] ?? '2024',
                'status_lab' => $user['status'] === 'active' ? 'aktif' : 'alumni'
            ];
        }

        return [
            'name' => $_SESSION['name'] ?? 'Member',
            'email' => $_SESSION['email'] ?? '-',
            'nim' => '-',
            'angkatan' => '2024',
            'status_lab' => 'aktif'
        ];
    }

    private function getMemberProfileFull($userId)
    {
        $query = "SELECT * FROM users WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$userId]);

        if ($result && pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);
            return [
                'name' => $user['name'],
                'email' => $user['email'],
                'nim' => $user['nim'] ?? '',
                'phone' => $user['phone'] ?? '',
                'angkatan' => $user['angkatan'] ?? '',
                'origin' => $user['origin'] ?? '',
                'status_lab' => $user['status'] === 'active' ? 'aktif' : 'alumni'
            ];
        }

        return [
            'name' => $_SESSION['name'] ?? '',
            'email' => $_SESSION['email'] ?? '',
            'nim' => '',
            'phone' => '',
            'angkatan' => '',
            'origin' => '',
            'status_lab' => 'aktif'
        ];
require_once __DIR__ . '/../models/member.php';

class MemberController {
    private $memberModel;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->memberModel = new Member($this->db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

            $id = $this->memberModel->register($data);

            if ($id) {
                // Redirect to success page
                header('Location: /index.php?page=registration_success');
                exit;
            } else {
                return "Registration failed";
            }
        }
    }

    public function getPendingRegistrations($supervisor_id) {
        return $this->memberModel->getPendingBySupervisor($supervisor_id);
    }

    public function approveRegistration($id, $role, $notes = null) {
        if ($role === 'dosen') {
            return $this->memberModel->approveBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->approveByLabHead($id, $notes);
        }
        return false;
    }

    public function rejectRegistration($id, $role, $notes) {
        if ($role === 'dosen') {
            return $this->memberModel->rejectBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->rejectByLabHead($id, $notes);
        }
        return false;
    }
}

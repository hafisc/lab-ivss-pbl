<?php

require_once __DIR__ . '/../models/member.php';

class MemberController
{
    private $memberModel;
    private $db;

    public function __construct($db = null)
    {
        if ($db) {
            $this->db = $db;
        } else {
            $this->db = Database::getInstance()->getConnection();
        }
        $this->memberModel = new Member($this->db);
    }

    public function dashboard()
    {
        // Get user ID from session
        $userId = $_SESSION['user_id'] ?? null;
        
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }
        
        // Initialize data
        $totalMyResearch = 0;
        $totalMyPublications = 0;
        $currentMemberStatus = 'aktif';
        $supervisorInfo = null;
        $myResearches = [];

        // Fetch Real Data
        $query = "SELECT u.status, m.supervisor_id, m.research_title, m.nama
                  FROM users u 
                  LEFT JOIN mahasiswa m ON u.id = m.user_id 
                  WHERE u.id = $1";
        $res = @pg_query_params($this->db, $query, [$userId]);
        
        if ($res && pg_num_rows($res) > 0) {
            $userData = pg_fetch_assoc($res);
            $currentMemberStatus = $userData['status'] ?? 'inactive';

            // Get Supervisor Info
            if (!empty($userData['supervisor_id'])) {
                // supervisor_id in mahasiswa table references dosen(id)
                $sQuery = "SELECT u.username as name, u.email 
                           FROM users u 
                           JOIN dosen d ON u.id = d.user_id 
                           WHERE d.id = $1";
                $sRes = @pg_query_params($this->db, $sQuery, [$userData['supervisor_id']]);
                if ($sRes && pg_num_rows($sRes) > 0) {
                    $supervisorInfo = pg_fetch_assoc($sRes);
                }
            }

            // Get Researches (From Mahasiswa Title)
            if (!empty($userData['research_title'])) {
                $myResearches[] = [
                    'title' => $userData['research_title'],
                    'category' => 'Tugas Akhir',
                    'leader_name' => $userData['nama'] ?? 'Saya',
                    'status' => 'active'
                ];
            }
            $totalMyResearch = count($myResearches);
            
            // Count Publications (Dummy for now or name match)
            $totalMyPublications = 0;
        }
        
        // Member dashboard view
        require_once __DIR__ . '/../../view/member/dashboard.php';
    }

    public function register()
    {
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

    public function getPendingRegistrations($supervisor_id)
    {
        return $this->memberModel->getPendingBySupervisor($supervisor_id);
    }

    public function approveRegistration($id, $role, $notes = null)
    {
        if ($role === 'dosen') {
            return $this->memberModel->approveBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->approveByLabHead($id, $notes);
        }
        return false;
    }

    public function rejectRegistration($id, $role, $notes)
    {
        if ($role === 'dosen') {
            return $this->memberModel->rejectBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->rejectByLabHead($id, $notes);
        }
        return false;
    }

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

        // Jika ada data tambahan di member_registrations, ambil juga
        $extra = null;
        if (!empty($user['email'])) {
            $q2 = "SELECT * FROM member_registrations WHERE email = $1 LIMIT 1";
            $r2 = @pg_query_params($this->db, $q2, array($user['email']));
            if ($r2 && pg_num_rows($r2) > 0) {
                $extra = pg_fetch_assoc($r2);
            }
        }

        $profileUser = $user ?: [];
        $profileExtra = $extra ?: [];

        // Build $me array expected by the view
        $me = array_merge([
            'name' => $profileUser['username'] ?? $profileExtra['name'] ?? '',
            'email' => $profileUser['email'] ?? $profileExtra['email'] ?? '',
            'nim' => $profileExtra['nim'] ?? $profileUser['nim'] ?? '',
            'angkatan' => $profileExtra['angkatan'] ?? $profileUser['angkatan'] ?? '',
            'origin' => $profileExtra['origin'] ?? $profileUser['origin'] ?? '',
            'phone' => $profileExtra['phone'] ?? $profileUser['phone'] ?? '',
            'status_lab' => $profileExtra['status'] ?? $profileUser['status'] ?? 'aktif'
        ], $profileExtra);

        // Include the view directly — the view will render the layout itself
        include __DIR__ . '/../../view/member/settings/index.php';
    }

    public function editProfile()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }

        $query = "SELECT id, username, email, photo FROM users WHERE id = $1 LIMIT 1";
        $res = @pg_query_params($this->db, $query, array($userId));
        $user = ($res && pg_num_rows($res) > 0) ? pg_fetch_assoc($res) : null;

        // Prepare $me for the view
        $me = [
            'name' => $user['username'] ?? '',
            'email' => $user['email'] ?? '',
            'nim' => $user['nim'] ?? '',
            'phone' => $user['phone'] ?? '',
            'angkatan' => $user['angkatan'] ?? '',
            'origin' => $user['origin'] ?? ''
        ];

        include __DIR__ . '/../../view/member/settings/edit.php';
    }

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

        if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Nama dan email wajib diisi dengan format valid.';
            header('Location: index.php?page=member-settings-edit');
            exit;
        }

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

    public function changePassword()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: index.php?page=login');
            exit;
        }
        include __DIR__ . '/../../view/member/settings/change-password.php';
    }

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

        // Note: form uses 'old_password' name
        $current = $_POST['old_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (empty($new) || strlen($new) < 8 || $new !== $confirm) {
            $_SESSION['error'] = 'Password baru harus minimal 8 karakter dan cocok dengan konfirmasi.';
            header('Location: index.php?page=member-settings-change-password');
            exit;
        }

        // Verifikasi password saat ini
        $q = "SELECT password FROM users WHERE id = $1 LIMIT 1";
        $r = @pg_query_params($this->db, $q, array($userId));
        $row = ($r && pg_num_rows($r) > 0) ? pg_fetch_assoc($r) : null;

        if (!$row || !password_verify($current, $row['password'])) {
            $_SESSION['error'] = 'Password saat ini salah.';
            header('Location: index.php?page=member-settings-change-password');
            exit;
        }

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

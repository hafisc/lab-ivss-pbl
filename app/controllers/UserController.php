<?php
require_once __DIR__ . '/../config/database.php';

class UserController
{
    private $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    // Display users page
    public function index()
    {
        // Fetch all users with role information
        $query = "SELECT 
                    u.id, 
                    u.username, 
                    u.email, 
                    r.role_name,
                    u.status, 
                    u.last_login, 
                    u.created_at,
                    COALESCE(m.nama, d.nama) as nama,
                    m.nim,
                    d.nip,
                    m.angkatan,
                    COALESCE(m.no_phone, d.no_hp) as phone
                  FROM users u
                  JOIN roles r ON u.role_id = r.id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id
                  LEFT JOIN dosen d ON u.id = d.user_id
                  ORDER BY u.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate stats
        $totalUsers = count($users);
        $adminCount = count(array_filter($users, function ($u) {
            return $u['role_name'] === 'admin';
        }));
        $dosenCount = count(array_filter($users, function ($u) {
            return in_array($u['role_name'], ['dosen', 'ketua_lab']);
        }));
        $memberCount = count(array_filter($users, function ($u) {
            return $u['role_name'] === 'mahasiswa' && $u['status'] === 'active';
        }));
        $inactiveCount = count(array_filter($users, function ($u) {
            return $u['status'] === 'inactive';
        }));

        // Load view
        require_once __DIR__ . '/../../view/admin/users/index.php';
    }

    // Add new user
    public function store()
    {
        header('Content-Type: application/json');

        try {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';
            $status = $_POST['status'] ?? 'active';
            $phone = !empty($_POST['phone']) ? $_POST['phone'] : null;
            $nim = !empty($_POST['nim']) ? $_POST['nim'] : null;
            $nip = !empty($_POST['nip']) ? $_POST['nip'] : null;
            $angkatan = !empty($_POST['angkatan']) ? $_POST['angkatan'] : null;

            // Member specific fields
            $origin = !empty($_POST['origin']) ? $_POST['origin'] : null;
            $research_title = !empty($_POST['research_title']) ? $_POST['research_title'] : null;
            $supervisor_id = !empty($_POST['supervisor_id']) ? intval($_POST['supervisor_id']) : null;
            $motivation = !empty($_POST['motivation']) ? $_POST['motivation'] : null;

            // Validation
            if (empty($name) || empty($email) || empty($password)) {
                throw new Exception('Nama, email, dan password wajib diisi');
            }

            if (strlen($password) < 8) {
                throw new Exception('Password minimal 8 karakter');
            }

            // Check email unique di users
            $checkQuery = "SELECT id FROM users WHERE email = :email";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                throw new Exception('Email sudah terdaftar');
            }

            // Check email unique di member_registrations
            $checkRegQuery = "SELECT id FROM member_registrations WHERE email = :email";
            $checkRegStmt = $this->conn->prepare($checkRegQuery);
            $checkRegStmt->bindParam(':email', $email);
            $checkRegStmt->execute();

            if ($checkRegStmt->rowCount() > 0) {
                throw new Exception('Email sudah terdaftar sebagai pendaftar');
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // SPECIAL HANDLING FOR MEMBER: Masuk ke approval workflow
            if ($role === 'member') {
                // Validation member fields
                if (empty($nim) || empty($angkatan) || empty($research_title) || empty($supervisor_id)) {
                    throw new Exception('NIM, Angkatan, Judul Riset, dan Dosen Pembimbing wajib diisi untuk Member');
                }

                // Insert ke member_registrations untuk approval workflow
                $query = "INSERT INTO member_registrations 
                          (name, email, password, nim, phone, angkatan, origin, research_title, supervisor_id, motivation, role_wanted, status, created_at) 
                          VALUES (:name, :email, :password, :nim, :phone, :angkatan, :origin, :research_title, :supervisor_id, :motivation, 'member', 'pending_supervisor', NOW())";
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':nim', $nim);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':angkatan', $angkatan);
                $stmt->bindParam(':origin', $origin);
                $stmt->bindParam(':research_title', $research_title);
                $stmt->bindParam(':supervisor_id', $supervisor_id, PDO::PARAM_INT);
                $stmt->bindParam(':motivation', $motivation);

                if ($stmt->execute()) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Member berhasil ditambahkan ke daftar pendaftar. Menunggu approval dari Dosen Pembimbing.'
                    ]);
                } else {
                    throw new Exception('Gagal menambahkan member ke daftar pendaftar');
                }
            } else {
                // For admins/dosen/ketua_lab we create a user record — map role name to role_id
                $roleId = 4; // default to mahasiswa/member
                $roleQuery = "SELECT id FROM roles WHERE role_name = :role LIMIT 1";
                $roleStmt = $this->conn->prepare($roleQuery);
                $roleStmt->bindParam(':role', $role);
                $roleStmt->execute();
                $roleRow = $roleStmt->fetch(PDO::FETCH_ASSOC);
                if ($roleRow) $roleId = $roleRow['id'];

                $query = "INSERT INTO users (username, email, password, role_id, status, created_at) 
                          VALUES (:username, :email, :password, :role_id, :status, NOW())";
                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':username', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
                $stmt->bindParam(':status', $status);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'User berhasil ditambahkan']);
                } else {
                    throw new Exception('Gagal menambahkan user');
                }
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Get user by ID for edit
    public function show()
    {
        header('Content-Type: application/json');

        try {
            $id = $_GET['id'] ?? 0;

            $query = "SELECT 
                        u.id, 
                        u.username, 
                        u.email, 
                        r.role_name,
                        u.status,
                        COALESCE(m.nama, d.nama) as nama,
                        m.nim,
                        d.nip,
                        m.angkatan,
                        COALESCE(m.no_phone, d.no_hp) as phone,
                        d.origin,
                        m.research_title
                      FROM users u
                      JOIN roles r ON u.role_id = r.id
                      LEFT JOIN mahasiswa m ON u.id = m.user_id
                      LEFT JOIN dosen d ON u.id = d.user_id
                      WHERE u.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                echo json_encode(['success' => true, 'data' => $user]);
            } else {
                throw new Exception('User tidak ditemukan');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Update user
    public function update()
    {
        header('Content-Type: application/json');

        try {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';
            $status = $_POST['status'] ?? 'active';
            $phone = !empty($_POST['phone']) ? $_POST['phone'] : null;
            $nim = !empty($_POST['nim']) ? $_POST['nim'] : null;
            $roleId = 4; // default
            $roleQuery = "SELECT id FROM roles WHERE role_name = :role LIMIT 1";
            $roleStmt = $this->conn->prepare($roleQuery);
            $roleStmt->bindParam(':role', $role);
            $roleStmt->execute();
            $roleRow = $roleStmt->fetch(PDO::FETCH_ASSOC);
            if ($roleRow) $roleId = $roleRow['id'];
            $nip = !empty($_POST['nip']) ? $_POST['nip'] : null;
            $angkatan = !empty($_POST['angkatan']) ? $_POST['angkatan'] : null;

            // Member specific fields
            $origin = !empty($_POST['origin']) ? $_POST['origin'] : null;
            $research_title = !empty($_POST['research_title']) ? $_POST['research_title'] : null;
            $supervisor_id = !empty($_POST['supervisor_id']) ? intval($_POST['supervisor_id']) : null;
            $motivation = !empty($_POST['motivation']) ? $_POST['motivation'] : null;

            // Validation
            if (empty($name) || empty($email)) {
                throw new Exception('Nama dan email wajib diisi');
            }

            // Check email unique (except current user)
            $checkQuery = "SELECT id FROM users WHERE email = :email AND id != :id";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->bindParam(':id', $id);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                throw new Exception('Email sudah digunakan user lain');
            }

            // Update query — users table only stores: username, email, password, role_id, status
            if (!empty($password)) {
                // Update with password
                if (strlen($password) < 8) {
                    throw new Exception('Password minimal 8 karakter');
                }
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $query = "UPDATE users SET username=:username, email=:email, password=:password, status=:status, 
                          updated_at=CURRENT_TIMESTAMP WHERE id=:id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':password', $hashedPassword);
            } else {
                // Update without password
                $query = "UPDATE users SET username=:username, email=:email, status=:status, updated_at=CURRENT_TIMESTAMP WHERE id=:id";
                $stmt = $this->conn->prepare($query);
            }

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':status', $status);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'User berhasil diupdate']);
            } else {
                throw new Exception('Gagal mengupdate user');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Delete user
    public function delete()
    {
        header('Content-Type: application/json');

        try {
            $id = $_POST['id'] ?? 0;

            // Protect super admin
            if ($id == 1) {
                throw new Exception('Super admin tidak dapat dihapus');
            }

            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'User berhasil dihapus']);
            } else {
                throw new Exception('Gagal menghapus user');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Reset password
    public function resetPassword()
    {
        header('Content-Type: application/json');

        try {
            $id = $_POST['id'] ?? 0;

            // Default password: admin123
            $defaultPassword = 'admin123';
            $hashedPassword = password_hash($defaultPassword, PASSWORD_BCRYPT);

            $query = "UPDATE users SET password = :password, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Password berhasil direset ke: admin123']);
            } else {
                throw new Exception('Gagal mereset password');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}

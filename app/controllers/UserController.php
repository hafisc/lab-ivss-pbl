<?php
require_once __DIR__ . '/../config/database.php';

class UserController {
    private $conn;
    
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    
    // Display users page
    public function index() {
        // Fetch all users
        $query = "SELECT id, name, email, role, status, nim, nip, phone, angkatan, last_login, created_at 
                  FROM users 
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate stats
        $totalUsers = count($users);
        $adminCount = count(array_filter($users, fn($u) => $u['role'] === 'admin'));
        $dosenCount = count(array_filter($users, fn($u) => in_array($u['role'], ['dosen', 'ketua_lab'])));
        $memberCount = count(array_filter($users, fn($u) => $u['role'] === 'member' && $u['status'] === 'active'));
        $inactiveCount = count(array_filter($users, fn($u) => $u['status'] === 'inactive'));
        
        // Load view
        require_once __DIR__ . '/../../view/admin/users/index.php';
    }
    
    // Add new user
    public function store() {
        header('Content-Type: application/json');
        
        try {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';
            $status = $_POST['status'] ?? 'active';
            $phone = $_POST['phone'] ?? null;
            $nim = $_POST['nim'] ?? null;
            $nip = $_POST['nip'] ?? null;
            $angkatan = $_POST['angkatan'] ?? null;
            
            // Validation
            if (empty($name) || empty($email) || empty($password)) {
                throw new Exception('Nama, email, dan password wajib diisi');
            }
            
            if (strlen($password) < 8) {
                throw new Exception('Password minimal 8 karakter');
            }
            
            // Check email unique
            $checkQuery = "SELECT id FROM users WHERE email = :email";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                throw new Exception('Email sudah terdaftar');
            }
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert user
            $query = "INSERT INTO users (name, email, password, role, status, phone, nim, nip, angkatan) 
                      VALUES (:name, :email, :password, :role, :status, :phone, :nim, :nip, :angkatan)";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':nim', $nim);
            $stmt->bindParam(':nip', $nip);
            $stmt->bindParam(':angkatan', $angkatan);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'User berhasil ditambahkan']);
            } else {
                throw new Exception('Gagal menambahkan user');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    // Get user by ID for edit
    public function show() {
        header('Content-Type: application/json');
        
        try {
            $id = $_GET['id'] ?? 0;
            
            $query = "SELECT id, name, email, role, status, phone, nim, nip, angkatan FROM users WHERE id = :id";
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
    public function update() {
        header('Content-Type: application/json');
        
        try {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';
            $status = $_POST['status'] ?? 'active';
            $phone = $_POST['phone'] ?? null;
            $nim = $_POST['nim'] ?? null;
            $nip = $_POST['nip'] ?? null;
            $angkatan = $_POST['angkatan'] ?? null;
            
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
            
            // Update query
            if (!empty($password)) {
                // Update with password
                if (strlen($password) < 8) {
                    throw new Exception('Password minimal 8 karakter');
                }
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                
                $query = "UPDATE users SET name=:name, email=:email, password=:password, role=:role, 
                          status=:status, phone=:phone, nim=:nim, nip=:nip, angkatan=:angkatan, 
                          updated_at=CURRENT_TIMESTAMP WHERE id=:id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':password', $hashedPassword);
            } else {
                // Update without password
                $query = "UPDATE users SET name=:name, email=:email, role=:role, status=:status, 
                          phone=:phone, nim=:nim, nip=:nip, angkatan=:angkatan, 
                          updated_at=CURRENT_TIMESTAMP WHERE id=:id";
                $stmt = $this->conn->prepare($query);
            }
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':nim', $nim);
            $stmt->bindParam(':nip', $nip);
            $stmt->bindParam(':angkatan', $angkatan);
            
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
    public function delete() {
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
    public function resetPassword() {
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
?>

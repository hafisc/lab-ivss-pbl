<?php

require_once __DIR__ . '/../models/TeamMember.php';

class TeamMemberController {
    private $teamModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->teamModel = new TeamMember($db);
    }

    /**
     * Display team members management page (admin)
     */
    public function index() {
        $members = $this->teamModel->getAll();
        
        require_once __DIR__ . '/../../view/admin/team/index.php';
    }

    /**
     * Get team member data for edit (AJAX)
     */
    public function show() {
        header('Content-Type: application/json');
        
        $id = $_GET['id'] ?? 0;
        $member = $this->teamModel->getById($id);
        
        if ($member) {
            echo json_encode(['success' => true, 'data' => $member]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Anggota tidak ditemukan']);
        }
    }

    /**
     * Store new team member
     */
    public function store() {
        header('Content-Type: application/json');
        
        try {
            // Validate input
            if (empty($_POST['name']) || empty($_POST['position'])) {
                throw new Exception('Nama dan jabatan wajib diisi');
            }

            // Handle photo upload
            $photoPath = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photoPath = $this->uploadPhoto($_FILES['photo']);
            }

            $data = [
                'name' => trim($_POST['name']),
                'position' => trim($_POST['position']),
                'photo' => $photoPath,
                'email' => trim($_POST['email'] ?? ''),
                'bio' => trim($_POST['bio'] ?? ''),
                'order_position' => intval($_POST['order_position'] ?? 0),
                'is_active' => isset($_POST['is_active']) && $_POST['is_active'] === '1'
            ];

            $id = $this->teamModel->create($data);

            if ($id) {
                echo json_encode(['success' => true, 'message' => 'Anggota berhasil ditambahkan', 'id' => $id]);
            } else {
                throw new Exception('Gagal menyimpan data');
            }
        } catch (Exception $e) {
            // Delete uploaded photo if exists
            if (isset($photoPath) && $photoPath) {
                $fullPath = __DIR__ . '/../../public/' . $photoPath;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Update team member
     */
    public function update() {
        header('Content-Type: application/json');
        
        try {
            $id = $_POST['id'] ?? 0;
            
            if (empty($id)) {
                throw new Exception('ID tidak valid');
            }

            // Get existing data
            $existingMember = $this->teamModel->getById($id);
            if (!$existingMember) {
                throw new Exception('Anggota tidak ditemukan');
            }

            // Validate input
            if (empty($_POST['name']) || empty($_POST['position'])) {
                throw new Exception('Nama dan jabatan wajib diisi');
            }

            // Handle photo upload
            $photoPath = $existingMember['photo'];
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Delete old photo
                if ($photoPath) {
                    $oldPhotoPath = __DIR__ . '/../../public/' . $photoPath;
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
                // Upload new photo
                $photoPath = $this->uploadPhoto($_FILES['photo']);
            }

            $data = [
                'name' => trim($_POST['name']),
                'position' => trim($_POST['position']),
                'photo' => $photoPath,
                'email' => trim($_POST['email'] ?? ''),
                'bio' => trim($_POST['bio'] ?? ''),
                'order_position' => intval($_POST['order_position'] ?? 0),
                'is_active' => isset($_POST['is_active']) && $_POST['is_active'] === '1'
            ];

            $success = $this->teamModel->update($id, $data);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Data berhasil diperbarui']);
            } else {
                throw new Exception('Gagal memperbarui data');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete team member
     */
    public function delete() {
        header('Content-Type: application/json');
        
        try {
            $id = $_POST['id'] ?? 0;
            
            if (empty($id)) {
                throw new Exception('ID tidak valid');
            }

            $success = $this->teamModel->delete($id);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Anggota berhasil dihapus']);
            } else {
                throw new Exception('Gagal menghapus data');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive() {
        header('Content-Type: application/json');
        
        try {
            $id = $_POST['id'] ?? 0;
            
            if (empty($id)) {
                throw new Exception('ID tidak valid');
            }

            $success = $this->teamModel->toggleActive($id);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Status berhasil diubah']);
            } else {
                throw new Exception('Gagal mengubah status');
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Upload photo file
     */
    private function uploadPhoto($file) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        // Validate file type
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Format file tidak didukung. Gunakan JPG, PNG, atau WebP');
        }

        // Validate file size
        if ($file['size'] > $maxSize) {
            throw new Exception('Ukuran file terlalu besar. Maksimal 2MB');
        }

        // Create upload directory if not exists
        $uploadDir = __DIR__ . '/../../public/uploads/team/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'team_' . time() . '_' . uniqid() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Gagal mengupload file');
        }

        return 'uploads/team/' . $filename;
    }
}

<?php
require_once __DIR__ . '/../helpers/NavbarSetup.php';

class NavbarController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $setup = new NavbarSetup($db);
        $setup->initialize();
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $navbarSettings = $this->getNavbarSettings();
        $action = 'view';
        $title = 'Manajemen Navbar';
        ob_start();
        include __DIR__ . '/../../view/admin/navbar/view.php';
        return ob_get_clean();
    }

    public function edit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $navbarSettings = $this->getNavbarSettings();
        $action = 'edit';
        $title = 'Edit Navbar';
        ob_start();
        include __DIR__ . '/../../view/admin/navbar/edit.php';
        return ob_get_clean();
    }

    public function update() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-navbar');
            exit;
        }

        try {
            $existing = $this->getNavbarSettings();
            $logo_url = $existing['logo_url'] ?? 'assets/images/logo1.png';

            // --- PROSES UPLOAD LOGO ---
            if (isset($_FILES['logo_file']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
                $targetDir = "assets/images/";
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

                $ext = strtolower(pathinfo($_FILES["logo_file"]["name"], PATHINFO_EXTENSION));
                $newFileName = "logo_" . time() . "." . $ext;
                $targetFilePath = $targetDir . $newFileName;

                if (in_array($ext, ['jpg', 'png', 'jpeg', 'svg'])) {
                    if (move_uploaded_file($_FILES["logo_file"]["tmp_name"], $targetFilePath)) {
                        // Hapus file lama jika bukan default
                        if (file_exists($logo_url) && $logo_url != 'assets/images/logo1.png') {
                            unlink($logo_url);
                        }
                        $logo_url = $targetFilePath;
                    }
                }
            }

            // --- SIMPAN KE DATABASE ---
            $menuItemsJson = json_encode($_POST['menu_items'] ?? []);
            
            $params = [
                $_POST['topbar_text'] ?? '',
                $_POST['institution_name'] ?? '',
                $_POST['lab_name'] ?? '',
                $logo_url,
                $_POST['login_url'] ?? '',
                $menuItemsJson
            ];

            // Cek apakah data sudah ada
            $check = pg_query($this->db, "SELECT id FROM navbar_settings LIMIT 1");
            if (pg_num_rows($check) > 0) {
                $query = "UPDATE navbar_settings SET 
                          topbar_text=$1, institution_name=$2, lab_name=$3, 
                          logo_url=$4, login_url=$5, menu_items=$6, updated_at=NOW() 
                          WHERE id = (SELECT id FROM navbar_settings LIMIT 1)";
            } else {
                $query = "INSERT INTO navbar_settings 
                          (topbar_text, institution_name, lab_name, logo_url, login_url, menu_items) 
                          VALUES ($1, $2, $3, $4, $5, $6)";
            }

            if (pg_query_params($this->db, $query, $params)) {
                $_SESSION['success'] = 'Navbar berhasil diperbarui!';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        header('Location: index.php?page=admin-navbar');
        exit;
    }

    public function getNavbarSettings() {
        $result = @pg_query($this->db, "SELECT * FROM navbar_settings LIMIT 1");
        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            $row['menu_items'] = is_string($row['menu_items']) ? json_decode($row['menu_items'], true) : ($row['menu_items'] ?? []);
            return $row;
        }
        return [
            'topbar_text' => 'Laboratorium IVSS - Politeknik Negeri Malang',
            'institution_name' => 'Politeknik Negeri Malang',
            'lab_name' => 'Lab IVSS',
            'logo_url' => 'assets/images/logo1.png',
            'login_url' => 'index.php?page=login',
            'menu_items' => []
        ];
    }
}
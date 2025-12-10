<?php

require_once __DIR__ . '/../helpers/NavbarSetup.php';

class NavbarController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;

        // Initialize navbar settings table on first use
        $setup = new NavbarSetup($db);
        $setup->initialize();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $navbarSettings = $this->getNavbarSettings();
        $action = 'view';
        $title = 'Manajemen Navbar';

        ob_start();
        include __DIR__ . '/../../view/admin/navbar/view.php';
        return ob_get_clean();
    }

    public function edit()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $navbarSettings = $this->getNavbarSettings();
        $action = 'edit';
        $title = 'Edit Navbar';

        ob_start();
        include __DIR__ . '/../../view/admin/navbar/edit.php';
        return ob_get_clean();
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-navbar');
            exit;
        }

        try {
            // Get form data
            $topbar_text = $_POST['topbar_text'] ?? '';
            $institution_name = $_POST['institution_name'] ?? '';
            $lab_name = $_POST['lab_name'] ?? '';
            $logo_url = $_POST['logo_url'] ?? '';
            $login_url = $_POST['login_url'] ?? '';

            // Menu items (store as JSON)
            $menuItems = [];
            if (!empty($_POST['menu_items'])) {
                $order = 1;
                foreach ($_POST['menu_items'] as $item) {
                    if (!empty($item['label']) && !empty($item['url'])) {
                        $menuItems[] = [
                            'label' => $item['label'],
                            'url' => $item['url'],
                            'order' => $order++
                        ];
                    }
                }
            }
            $menuItemsJson = json_encode($menuItems);

            // Check if settings exist
            $checkQuery = "SELECT id FROM navbar_settings LIMIT 1";
            $result = @pg_query($this->db, $checkQuery);
            $exists = $result && pg_num_rows($result) > 0;

            if ($exists) {
                // Update existing settings
                $query = "UPDATE navbar_settings SET 
                          topbar_text = $1, 
                          institution_name = $2, 
                          lab_name = $3, 
                          logo_url = $4,
                          login_url = $5,
                          menu_items = $6,
                          updated_at = NOW()
                          WHERE id = (SELECT id FROM navbar_settings LIMIT 1)";

                $params = [
                    $topbar_text,
                    $institution_name,
                    $lab_name,
                    $logo_url,
                    $login_url,
                    $menuItemsJson
                ];

                $result = @pg_query_params($this->db, $query, $params);
            } else {
                // Insert new settings
                $query = "INSERT INTO navbar_settings 
                          (topbar_text, institution_name, lab_name, logo_url, login_url, menu_items, created_at) 
                          VALUES ($1, $2, $3, $4, $5, $6, NOW())";

                $params = [
                    $topbar_text,
                    $institution_name,
                    $lab_name,
                    $logo_url,
                    $login_url,
                    $menuItemsJson
                ];

                $result = @pg_query_params($this->db, $query, $params);
            }

            if ($result) {
                $_SESSION['success'] = 'Navbar berhasil diperbarui!';
            } else {
                throw new Exception('Gagal mengupdate navbar: ' . pg_last_error($this->db));
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: index.php?page=admin-navbar');
        exit;
    }

    public function getNavbarSettings()
    {
        $query = "SELECT * FROM navbar_settings LIMIT 1";
        $result = @pg_query($this->db, $query);

        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            // Decode JSON fields
            $row['menu_items'] = !empty($row['menu_items']) ? json_decode($row['menu_items'], true) : [];
            return $row;
        }

        // Return default empty structure
        return [
            'topbar_text' => 'Laboratorium Intelligent Vision and Smart System (IVSS) – Jurusan Teknologi Informasi – Politeknik Negeri Malang',
            'institution_name' => 'Politeknik Negeri Malang',
            'lab_name' => 'Lab Intelligent Vision and Smart System',
            'logo_url' => 'assets/images/logo1.png',
            'login_url' => 'index.php?page=login',
            'menu_items' => [
                ['label' => 'Beranda', 'url' => '#beranda', 'order' => 1],
                ['label' => 'Profil', 'url' => '#profil', 'order' => 2],
                ['label' => 'Riset', 'url' => '#riset', 'order' => 3],
                ['label' => 'Fasilitas', 'url' => '#fasilitas', 'order' => 4],
                ['label' => 'Member', 'url' => '#member', 'order' => 5],
                ['label' => 'Berita', 'url' => '#berita', 'order' => 6],
                ['label' => 'Kontak', 'url' => '#kontak', 'order' => 7]
            ]
        ];
    }
}

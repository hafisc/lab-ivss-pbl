<?php

require_once __DIR__ . '/../helpers/FooterSetup.php';

class FooterController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;

        // Initialize footer settings table on first use
        $setup = new FooterSetup($db);
        $setup->initialize();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get current footer settings
        $footerSettings = $this->getFooterSettings();
        $action = $_GET['action'] ?? 'view';
        $title = 'Manajemen Footer';

        // Capture view content
        ob_start();
        if ($action === 'edit') {
            include __DIR__ . '/../../view/admin/footer/edit.php';
        } else {
            include __DIR__ . '/../../view/admin/footer/view.php';
        }
        $content = ob_get_clean();

        // Include admin layout
        include __DIR__ . '/../../view/layouts/admin.php';
    }

    public function edit()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get current footer settings
        $footerSettings = $this->getFooterSettings();
        $action = 'edit';
        $title = 'Edit Footer';

        // Capture view content
        ob_start();
        include __DIR__ . '/../../view/admin/footer/edit.php';
        $content = ob_get_clean();

        // Include admin layout
        include __DIR__ . '/../../view/layouts/admin.php';
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-footer');
            exit;
        }

        try {
            // Get form data
            $description = $_POST['description'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $instagram = $_POST['instagram'] ?? '';
            $facebook = $_POST['facebook'] ?? '';
            $linkedin = $_POST['linkedin'] ?? '';
            $twitter = $_POST['twitter'] ?? '';
            $youtube = $_POST['youtube'] ?? '';

            // Bottom bar fields
            $copyright_text = $_POST['copyright_text'] ?? '';
            $privacy_url = $_POST['privacy_url'] ?? '';
            $terms_url = $_POST['terms_url'] ?? '';
            $operating_hours = $_POST['operating_hours'] ?? '';

            // Quick links (store as JSON)
            $quickLinks = [];
            if (!empty($_POST['quick_links_label'])) {
                foreach ($_POST['quick_links_label'] as $index => $label) {
                    if (!empty($label) && !empty($_POST['quick_links_url'][$index])) {
                        $quickLinks[] = [
                            'label' => $label,
                            'url' => $_POST['quick_links_url'][$index]
                        ];
                    }
                }
            }
            $quickLinksJson = json_encode($quickLinks);

            // Resources links (store as JSON)
            $resources = [];
            if (!empty($_POST['resources_label'])) {
                foreach ($_POST['resources_label'] as $index => $label) {
                    if (!empty($label) && !empty($_POST['resources_url'][$index])) {
                        $resources[] = [
                            'label' => $label,
                            'url' => $_POST['resources_url'][$index]
                        ];
                    }
                }
            }
            $resourcesJson = json_encode($resources);

            // Check if settings exist
            $checkQuery = "SELECT id FROM footer_settings LIMIT 1";
            $result = @pg_query($this->db, $checkQuery);
            $exists = $result && pg_num_rows($result) > 0;

            if ($exists) {
                // Update existing settings
                $query = "UPDATE footer_settings SET 
                          description = $1, 
                          email = $2, 
                          phone = $3, 
                          address = $4,
                          instagram = $5,
                          facebook = $6,
                          linkedin = $7,
                          twitter = $8,
                          youtube = $9,
                          quick_links = $10,
                          resources = $11,
                          copyright_text = $12,
                          privacy_url = $13,
                          terms_url = $14,
                          operating_hours = $15,
                          updated_at = NOW()
                          WHERE id = (SELECT id FROM footer_settings LIMIT 1)";

                $params = [
                    $description,
                    $email,
                    $phone,
                    $address,
                    $instagram,
                    $facebook,
                    $linkedin,
                    $twitter,
                    $youtube,
                    $quickLinksJson,
                    $resourcesJson,
                    $copyright_text,
                    $privacy_url,
                    $terms_url,
                    $operating_hours
                ];

                $result = @pg_query_params($this->db, $query, $params);
            } else {
                // Insert new settings
                $query = "INSERT INTO footer_settings 
                          (description, email, phone, address, instagram, facebook, linkedin, twitter, youtube, quick_links, resources, copyright_text, privacy_url, terms_url, operating_hours, created_at) 
                          VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, NOW())";

                $params = [
                    $description,
                    $email,
                    $phone,
                    $address,
                    $instagram,
                    $facebook,
                    $linkedin,
                    $twitter,
                    $youtube,
                    $quickLinksJson,
                    $resourcesJson,
                    $copyright_text,
                    $privacy_url,
                    $terms_url,
                    $operating_hours
                ];

                $result = @pg_query_params($this->db, $query, $params);
            }

            if ($result) {
                $_SESSION['success'] = 'Footer berhasil diperbarui!';
            } else {
                throw new Exception('Gagal mengupdate footer: ' . pg_last_error($this->db));
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: index.php?page=admin-footer');
        exit;
    }

    public function getFooterSettings()
    {
        $query = "SELECT * FROM footer_settings LIMIT 1";
        $result = @pg_query($this->db, $query);

        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            // Decode JSON fields
            $row['quick_links'] = !empty($row['quick_links']) ? json_decode($row['quick_links'], true) : [];
            $row['resources'] = !empty($row['resources']) ? json_decode($row['resources'], true) : [];
            return $row;
        }

        // Return default empty structure
        return [
            'description' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'instagram' => '',
            'facebook' => '',
            'linkedin' => '',
            'twitter' => '',
            'youtube' => '',
            'quick_links' => [],
            'resources' => [],
            'copyright_text' => 'Lab IVSS - Jurusan Teknologi Informasi, Politeknik Negeri Malang',
            'privacy_url' => '',
            'terms_url' => '',
            'operating_hours' => 'Senin - Jumat<br>08:00 - 16:00 WIB'
        ];
        
    }
}

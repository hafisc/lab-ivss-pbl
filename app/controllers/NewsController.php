<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/news.php';

class NewsController {
    private $db;
    private $news;

    public function __construct() {
        $this->db = getDb();
        $this->news = new News($this->db);
    }

    // Helper function untuk generate slug
    private function generateSlug($title) {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    // Helper function untuk upload image
    private function uploadImage($file) {
        $upload_dir = __DIR__ . '/../../public/uploads/news/';
        
        // Buat direktori jika belum ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowed_types)) {
            return ['success' => false, 'message' => 'Format file tidak didukung. Gunakan JPG, PNG, atau WebP'];
        }

        if ($file['size'] > $max_size) {
            return ['success' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 2MB'];
        }

        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
        $file_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return ['success' => true, 'filename' => 'uploads/news/' . $new_filename];
        }

        return ['success' => false, 'message' => 'Gagal mengupload file'];
    }

    // Action: Store (Create new news)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-news');
            exit;
        }

        // Validasi input
        if (empty($_POST['title']) || empty($_POST['content'])) {
            $_SESSION['error'] = 'Judul dan konten berita wajib diisi';
            header('Location: index.php?page=admin-news&action=create');
            exit;
        }

        // Handle image upload
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_result = $this->uploadImage($_FILES['image']);
            if ($upload_result['success']) {
                $image_path = $upload_result['filename'];
            } else {
                $_SESSION['error'] = $upload_result['message'];
                header('Location: index.php?page=admin-news&action=create');
                exit;
            }
        }

        // Set properties
        $this->news->title = trim($_POST['title']);
        $this->news->slug = $this->generateSlug($_POST['title']);
        $this->news->content = trim($_POST['content']);
        $this->news->excerpt = !empty($_POST['excerpt']) ? trim($_POST['excerpt']) : null;
        $this->news->image = $image_path;
        $this->news->category = !empty($_POST['category']) ? $_POST['category'] : null;
        $this->news->tags = !empty($_POST['tags']) ? trim($_POST['tags']) : null;
        $this->news->author_id = $_SESSION['user_id'];
        $this->news->status = $_POST['status'];
        $this->news->published_at = ($this->news->status === 'published') ? date('Y-m-d H:i:s') : null;

        // Create news
        $news_id = $this->news->create();

        if ($news_id) {
            $_SESSION['success'] = 'Berita berhasil ditambahkan';
            header('Location: index.php?page=admin-news');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan berita';
            header('Location: index.php?page=admin-news&action=create');
        }
        exit;
    }

    // Action: Update (Edit existing news)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-news');
            exit;
        }

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            $_SESSION['error'] = 'ID berita tidak valid';
            header('Location: index.php?page=admin-news');
            exit;
        }

        // Get existing news
        $existing_news = $this->news->getById($id);
        if (!$existing_news) {
            $_SESSION['error'] = 'Berita tidak ditemukan';
            header('Location: index.php?page=admin-news');
            exit;
        }

        // Validasi input
        if (empty($_POST['title']) || empty($_POST['content'])) {
            $_SESSION['error'] = 'Judul dan konten berita wajib diisi';
            header('Location: index.php?page=admin-news&action=edit&id=' . $id);
            exit;
        }

        // Handle image upload or removal
        $image_path = $existing_news['image'];
        
        // Check if user wants to remove current image
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            $image_path = null;
            // Delete old image file if exists
            if ($existing_news['image'] && file_exists(__DIR__ . '/../../public/' . $existing_news['image'])) {
                unlink(__DIR__ . '/../../public/' . $existing_news['image']);
            }
        }

        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_result = $this->uploadImage($_FILES['image']);
            if ($upload_result['success']) {
                // Delete old image if exists
                if ($existing_news['image'] && file_exists(__DIR__ . '/../../public/' . $existing_news['image'])) {
                    unlink(__DIR__ . '/../../public/' . $existing_news['image']);
                }
                $image_path = $upload_result['filename'];
            } else {
                $_SESSION['error'] = $upload_result['message'];
                header('Location: index.php?page=admin-news&action=edit&id=' . $id);
                exit;
            }
        }

        // Set properties
        $this->news->id = $id;
        $this->news->title = trim($_POST['title']);
        $this->news->slug = $this->generateSlug($_POST['title']);
        $this->news->content = trim($_POST['content']);
        $this->news->excerpt = !empty($_POST['excerpt']) ? trim($_POST['excerpt']) : null;
        $this->news->image = $image_path;
        $this->news->category = !empty($_POST['category']) ? $_POST['category'] : null;
        $this->news->tags = !empty($_POST['tags']) ? trim($_POST['tags']) : null;
        $this->news->status = $_POST['status'];
        
        // Set published_at only when changing from draft to published
        if ($this->news->status === 'published' && $existing_news['status'] === 'draft') {
            $this->news->published_at = date('Y-m-d H:i:s');
        } else {
            $this->news->published_at = $existing_news['published_at'];
        }

        // Update news
        if ($this->news->update()) {
            $_SESSION['success'] = 'Berita berhasil diperbarui';
            header('Location: index.php?page=admin-news');
        } else {
            $_SESSION['error'] = 'Gagal memperbarui berita';
            header('Location: index.php?page=admin-news&action=edit&id=' . $id);
        }
        exit;
    }

    // Action: Delete
    public function delete() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            $_SESSION['error'] = 'ID berita tidak valid';
            header('Location: index.php?page=admin-news');
            exit;
        }

        // Get existing news to delete image
        $existing_news = $this->news->getById($id);
        
        $this->news->id = $id;
        if ($this->news->delete()) {
            // Delete image file if exists
            if ($existing_news && $existing_news['image'] && file_exists(__DIR__ . '/../../public/' . $existing_news['image'])) {
                unlink(__DIR__ . '/../../public/' . $existing_news['image']);
            }
            
            $_SESSION['success'] = 'Berita berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus berita';
        }

        header('Location: index.php?page=admin-news');
        exit;
    }
}

// Handle action dari URL
if (isset($_GET['action'])) {
    $controller = new NewsController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        header('Location: index.php?page=admin-news');
        exit;
    }
}

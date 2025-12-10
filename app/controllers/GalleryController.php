<?php

class GalleryController
{
    private $db;
    private $model;

    public function __construct($db)
    {
        $this->db = $db;
        require_once __DIR__ . '/../models/Gallery.php';
        $this->model = new Gallery($this->db);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $currentPage = 'admin-gallery';
        $gallery = $this->model->getAll();
        include __DIR__ . '/../../view/admin/gallery/index.php';
    }

    public function create()
    {
        $currentPage = 'admin-gallery';
        include __DIR__ . '/../../view/admin/gallery/create.php';
    }

    public function store()
    {
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/gallery/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/gallery/' . $fileName;
            }
        }

        // Gallery MUST have image
        if (!$imagePath) {
             $_SESSION['error'] = 'Gambar wajib diupload!';
             header('Location: index.php?page=admin-gallery');
             exit;
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'image_path' => $imagePath
        ];

        if ($this->model->create($data)) {
            $_SESSION['success'] = 'Gallery berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan gallery: ' . pg_last_error($this->db);
        }
        header('Location: index.php?page=admin-gallery');
        exit;
    }

    public function edit()
    {
        $currentPage = 'admin-gallery';
        $id = $_GET['id'] ?? 0;
        $item = $this->model->getById($id);
        if ($item) {
            include __DIR__ . '/../../view/admin/gallery/edit.php';
        } else {
            $_SESSION['error'] = 'Data tidak ditemukan';
            header('Location: index.php?page=admin-gallery');
            exit;
        }
    }

    public function update()
    {
        $id = $_GET['id'] ?? 0;
        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? ''
        ];

        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/gallery/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $data['image_path'] = 'uploads/gallery/' . $fileName;
            }
        }

        if ($this->model->update($id, $data)) {
            $_SESSION['success'] = 'Gallery berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate gallery: ' . pg_last_error($this->db);
        }
        header('Location: index.php?page=admin-gallery');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Gallery berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus gallery: ' . pg_last_error($this->db);
        }
        header('Location: index.php?page=admin-gallery');
        exit;
    }
}

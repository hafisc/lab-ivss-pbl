<?php

class FacilityController
{
    private $db;
    private $model;

    public function __construct($db)
    {
        $this->db = $db;
        require_once __DIR__ . '/../models/Facility.php';
        $this->model = new Facility($this->db);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $currentPage = 'admin-facilities';
        $facilities = $this->model->getAll();
        include __DIR__ . '/../../view/admin/facilities/index.php';
    }

    public function create()
    {
        $currentPage = 'admin-facilities';
        include __DIR__ . '/../../view/admin/facilities/create.php';
    }

    public function store()
    {
        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/facilities/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/facilities/' . $fileName;
            }
        }

        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '',
            'image' => $imagePath
        ];

        if ($this->model->create($data)) {
            $_SESSION['success'] = 'Fasilitas berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan fasilitas: ' . pg_last_error($this->db);
        }
        header('Location: index.php?page=admin-facilities');
        exit;
    }

    public function edit()
    {
        $currentPage = 'admin-facilities';
        $id = $_GET['id'] ?? 0;
        $facility = $this->model->getById($id);
        if ($facility) {
            include __DIR__ . '/../../view/admin/facilities/edit.php';
        } else {
            $_SESSION['error'] = 'Data tidak ditemukan';
            header('Location: index.php?page=admin-facilities');
            exit;
        }
    }

    public function update()
    {
        $id = $_GET['id'] ?? 0;
        $data = [
            'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? ''
        ];

        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/facilities/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $data['image'] = 'uploads/facilities/' . $fileName;
            }
        }

        if ($this->model->update($id, $data)) {
            $_SESSION['success'] = 'Fasilitas berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate fasilitas: ' . pg_last_error($this->db);
        }
        header('Location: index.php?page=admin-facilities');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        if ($this->model->delete($id)) {
            $_SESSION['success'] = 'Fasilitas berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus fasilitas: ' . pg_last_error($this->db);
        }
        header('Location: index.php?page=admin-facilities');
        exit;
    }
}

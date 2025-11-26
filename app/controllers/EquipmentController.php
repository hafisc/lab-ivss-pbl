<?php

class EquipmentController
{
    private $db;
    private $equipmentModel;

    public function __construct($db)
    {
        $this->db = $db;

        require_once __DIR__ . '/../models/equipment.php';
        $this->equipmentModel = new Equipment($this->db);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $allEquipment = $this->equipmentModel->getAll();

        // Filter sederhana berdasarkan parameter GET ?filter=
        $filter = $_GET['filter'] ?? 'all';
        if ($filter === 'all') {
            $equipmentList = $allEquipment;
        } else {
            $equipmentList = array_filter($allEquipment, function ($e) use ($filter) {
                return $e['category'] === $filter;
            });
        }

        // variabel ini dipakai di view admin/equipment/index.php
        include __DIR__ . '/../../view/admin/equipment/index.php';
    }

    public function create()
    {
        // hanya tampilkan form
        include __DIR__ . '/../../view/admin/equipment/create.php';
    }

    public function store()
    {
        $imagePath = null;

        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/equipment/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/equipment/' . $fileName;
            }
        }

        $data = [
            'name'        => $_POST['name'] ?? '',
            'category'    => $_POST['category'] ?? 'Hardware',
            'brand'       => $_POST['brand'] ?? null,
            'image'       => $imagePath,
            'quantity'    => $_POST['quantity'] ?? 1,
            'condition'   => $_POST['condition'] ?? 'baik',
            'location'    => $_POST['location'] ?? null,
            'description' => $_POST['description'] ?? null,
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
        ];

        if (empty($data['name'])) {
            $_SESSION['error'] = 'Nama peralatan wajib diisi.';
            header('Location: index.php?page=admin-equip&action=create');
            exit;
        }

        if ($this->equipmentModel->create($data)) {
            $_SESSION['success'] = 'Peralatan berhasil ditambahkan.';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan peralatan: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-equip');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Peralatan tidak ditemukan.';
            header('Location: index.php?page=admin-equip');
            exit;
        }

        $equipment = $this->equipmentModel->findById($id);
        if (!$equipment) {
            $_SESSION['error'] = 'Peralatan tidak ditemukan.';
            header('Location: index.php?page=admin-equip');
            exit;
        }

        // kirim data ke form edit
        $equip = $equipment;
        include __DIR__ . '/../../view/admin/equipment/edit.php';
    }

    public function update()
    {
        $id = $_GET['id'] ?? null;
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-equip');
            exit;
        }

        $equipment = $this->equipmentModel->findById($id);

        $imagePath = $equipment['image'] ?? null;
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../../public/uploads/equipment/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/equipment/' . $fileName;
            }
        }

        $data = [
            'name'      => $_POST['name'] ?? '',
            'category'  => $_POST['category'] ?? '',
            'brand'     => $_POST['brand'] ?? null,
            'image'     => $imagePath,
            'quantity'  => $_POST['quantity'] ?? 1,
            'condition' => $_POST['condition'] ?? 'baik',
            'location'  => $_POST['location'] ?? null,
        ];

        if ($this->equipmentModel->update($id, $data)) {
            $_SESSION['success'] = 'Peralatan berhasil diperbarui.';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui peralatan.';
        }

        header('Location: index.php?page=admin-equip');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->equipmentModel->delete($id);
            $_SESSION['success'] = 'Peralatan berhasil dihapus.';
        }

        header('Location: index.php?page=admin-equip');
        exit;
    }
}
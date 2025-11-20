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
        $data = [
            'name'        => $_POST['name'] ?? '',
            'category'    => $_POST['category'] ?? 'Hardware',
            'brand'       => $_POST['brand'] ?? null,
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

        $ok = $this->equipmentModel->create($data);

        if ($ok) {
            $_SESSION['success'] = 'Peralatan berhasil ditambahkan.';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan peralatan.';
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

        $data = [
            'name'      => $_POST['name'] ?? '',
            'category'  => $_POST['category'] ?? '',
            'brand'     => $_POST['brand'] ?? null,
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
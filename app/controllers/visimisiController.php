<?php

class VisiMisiController {
    private $db;
    private $model;

    public function __construct($db) {
        $this->db = $db;

        require_once __DIR__ . '/../models/VisiMisi.php';
        $this->model = new VisiMisi($this->db);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Tampilkan form edit Visi & Misi.
     * Memastikan data tersedia sebelum memuat view.
     */
    public function edit() {
        // Panggil ensureRecordExists(). Model akan membuat data default jika belum ada.
        $data = $this->model->ensureRecordExists();
        
        if (!$data) {
             $_SESSION['error'] = 'Gagal memuat data Visi & Misi.';
             header("Location: index.php?page=admin-dashboard");
             return;
        }
        
        // Variabel $data akan tersedia di view/admin/visimisi/edit.php
        include __DIR__ . '/../../view/admin/visimisi/edit.php'; 
    }

    /**
     * Simpan perubahan Visi & Misi.
     */
    public function update() {
        // Ambil ID dan data dari form POST
        $id = $_POST['id'] ?? 0;
        
        if (!$id) {
             $_SESSION['error'] = 'ID Visi & Misi tidak valid untuk update.';
             header("Location: index.php?page=admin-visimisi");
             exit;
        }
        
        // Sanitasi dan ambil data
        $data = [
            'visi' => htmlspecialchars($_POST['visi'] ?? '', ENT_QUOTES, 'UTF-8'),
            'misi' => htmlspecialchars($_POST['misi'] ?? '', ENT_QUOTES, 'UTF-8')
        ];
        
        $success = $this->model->update($id, $data);
        
        if ($success) {
            $_SESSION['success'] = 'Visi & Misi berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate Visi & Misi. Silakan cek log database.';
        }
        // Redirect kembali ke halaman edit
        header("Location: index.php?page=admin-visimisi");
        exit;
    }
}
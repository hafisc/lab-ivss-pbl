<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/visimisi.php';

class VisimisiController {
    private $db;
    private $visimisi;
    public function __construct() {
        $this->db = getDb();
        $this->visimisi = new Visimisi($this->db);
    }

    // Action: Update (Edit existing news)
   public function update() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=admin-visimisi');
        exit;
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $redirect_error_edit = 'Location: index.php?page=admin-visimisi&action=edit&id=' . $id;

    if ($id <= 0) {
        $_SESSION['error'] = 'ID Visi Misi tidak valid';
        header('Location: index.php?page=admin-visimisi');
        exit;
    }

    // Get existing visimisi
    $existing_visimisi = $this->visimisi->getById($id);
    if (!$existing_visimisi) {
        $_SESSION['error'] = 'Visi Misi tidak ditemukan';
        header('Location: index.php?page=admin-visimisi'); // Menggunakan 'admin-visimisi'
        exit;
    }

    // Validasi input
    if (empty($_POST['visi']) || empty($_POST['misi'])) {
        $_SESSION['error'] = 'Visi dan Misi wajib diisi'; // Pesan yang lebih sesuai
        header($redirect_error_edit);
        exit;
    }
    
    // Set properties
    $this->visimisi->id = $id;
    // Ambil langsung dari POST, karena validasi sudah dilakukan
    $this->visimisi->visi = $_POST['visi'];
    $this->visimisi->misi = $_POST['misi'];
    
    // Update visimisi
    if ($this->visimisi->update()) {
        $_SESSION['success'] = 'Visi Misi berhasil diperbarui';
        header('Location: index.php?page=admin-visimisi'); // Menggunakan 'admin-visimisi'
    } else {
        $_SESSION['error'] = 'Gagal memperbarui Visi Misi';
        header($redirect_error_edit); // Redirect kembali ke halaman edit jika gagal
    }
    exit;
}
}
// Handle action dari URL
if (isset($_GET['action'])) {
    $controller = new VisimisiController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        header('Location: index.php?page=admin-visimisi');
        exit;
    }
}

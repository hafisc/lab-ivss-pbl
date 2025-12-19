<?php
// File: admin/profile/index.php

if (session_status() === PHP_SESSION_NONE) session_start();

// 1. Panggil AdminController (Hapus ProfileController karena sudah tidak dipakai)
require_once __DIR__ . '/../../../app/controllers/AdminController.php';

global $pg; // Koneksi dari database.php

// 2. Proteksi Halaman
if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: index.php?page=admin-login');
    exit;
}

// 3. Inisialisasi Controller
$adminController = new AdminController($pg); 

$action = $_GET['action'] ?? 'index'; 
$title = 'Manajemen Profil Laboratorium';

// 4. Logika Routing
// Kita gunakan Output Buffering (ob_start) agar tampilan dari AdminController 
// bisa ditampung ke dalam variabel $content untuk layout
ob_start();

if ($action === 'edit') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Memanggil fungsi baru Anda
        $adminController->updateProfil(); 
    } else {
        // Menampilkan form edit
        $adminController->editProfile();
    }
} else {
    // Default: Menampilkan view data profil
    $adminController->profileSettings();
}

$content = ob_get_clean();

// 5. Masukkan ke Layout Admin
include __DIR__ . '/../../layouts/admin.php';
?>
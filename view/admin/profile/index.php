<?php
// File: admin/profile/index.php

if (session_status() === PHP_SESSION_NONE) session_start();

// Panggil ProfileController (yang akan me-require database.php dan mendapatkan $pg)
require_once __DIR__ . '/../../../app/controllers/ProfileController.php';

global $pg;

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: index.php?page=admin-login');
    exit;
}

$profileController = new ProfileController($pg); 

$action = $_GET['action'] ?? 'index'; 
$title = 'Manajemen Profil Laboratorium';

$content = '';
if ($action === 'edit') {
    $content = $profileController->edit();
} else {
    $content = $profileController->index();
}

include __DIR__ . '/../../layouts/admin.php';
?>
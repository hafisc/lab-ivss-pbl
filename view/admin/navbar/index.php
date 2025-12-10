<?php
// --- Authorization ---
if (
    empty($_SESSION['user']) || 
    !in_array($_SESSION['user']['role'] ?? '', ['admin', 'ketua_lab'])
) {
    header('Location: index.php?page=login');
    exit;
}

// --- Load NavbarController ---
global $pg;
require_once __DIR__ . '/../../../app/controllers/NavbarController.php';
$controller = new NavbarController($pg);

// --- Detect action ---
$action = $_GET['action'] ?? 'index';

// --- Get page content (tanpa include layout di controller) ---
if ($action === 'edit') {
    $content = $controller->edit();
} elseif ($action === 'update') {
    $controller->update();
} else {
    $content = $controller->index();
}

// --- Set page title ---
$title = 'Manajemen Navbar';

// --- Render main admin layout ---
include __DIR__ . '/../../../view/layouts/admin.php';
?>

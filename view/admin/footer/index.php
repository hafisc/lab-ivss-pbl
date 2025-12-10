<?php
// Authorization check
if (empty($_SESSION['user']) || !in_array($_SESSION['user']['role'] ?? '', ['admin', 'ketua_lab'])) {
    header('Location: index.php?page=login');
    exit;
}

// Get footer settings if not already available
if (empty($footerSettings)) {
    global $pg;
    require_once __DIR__ . '/../../app/controllers/FooterController.php';
    $footerController = new FooterController($pg);
    $footerSettings = $footerController->getFooterSettings();
}

$action = $_GET['action'] ?? 'view';
$title = 'Manajemen Footer';

// Capture view content
ob_start();
if ($action === 'edit') {
    include __DIR__ . '/edit.php';
} else {
    include __DIR__ . '/view.php';
}
$content = ob_get_clean();

// Include admin layout
include __DIR__ . '/../../layouts/admin.php';
?>
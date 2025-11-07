<?php
// Session sudah di-start di index.php, tidak perlu session_start() lagi
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
if ($_SESSION['role'] !== 'member') {
    header('Location: index.php?page=home');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Member Area - IVSS' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Include Sidebar -->
    <?php include __DIR__ . '/../member/partials/sidebar.php'; ?>
    
    <!-- Main Content (offset untuk sidebar w-60) -->
    <main class="lg:ml-60 min-h-screen">
        <!-- Header -->
        <?php include __DIR__ . '/../member/partials/header.php'; ?>
        
        <!-- Content Area -->
        <div class="px-4 md:px-8 py-6">
            <?= $content ?? '' ?>
        </div>
    </main>
</body>
</html>

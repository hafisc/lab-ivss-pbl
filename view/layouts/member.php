<?php
/**
 * Layout Utama Member Area
 * 
 * Layout ini digunakan sebagai pembungkus utama seluruh halaman member.
 * Meng-handle session check, load CSS/JS, dan memuat partials.
 * 
 * @package View
 * @subpackage Layouts
 */

// Cek Sesi Login Member
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke login jika tidak ada sesi user
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'member') {
    header("Location: login.php");
    exit();
}

// Mengambil data user untuk digunakan di view
$me = $_SESSION['user'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Member Area' ?> - Lab IVSS</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Style Wrapper -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e2e8f0; border-radius: 20px; }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translate3d(0, -10px, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden">

    <!-- Memuat Partial: Sidebar -->
    <?php include __DIR__ . '/../member/partials/sidebar.php'; ?>

    <!-- Main Content Wrapper -->
    <div class="lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
        
        <!-- Memuat Partial: Header -->
        <?php include __DIR__ . '/../member/partials/header.php'; ?>
        
        <!-- Content Area -->
        <main class="flex-1 p-4 lg:p-8 mt-16">
            <div class="max-w-7xl mx-auto">
                <!-- Dynamic Content Loaded Here -->
                <?= $content ?? '' ?>
            </div>
        </main>
        
        <!-- Simple Footer -->
        <footer class="bg-white border-t border-slate-200 py-4 px-8 text-center lg:text-left">
            <p class="text-xs text-slate-500">
                &copy; <?= date('Y') ?> Laboratorium IVSS Polinema. All rights reserved.
            </p>
        </footer>
        
    </div>

</body>
</html>
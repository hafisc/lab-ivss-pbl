<?php
/**
 * Layout Utama Autentikasi
 * 
 * Layout untuk halaman login, register, dan forgot password.
 * Menyediakan kerangka dasar HTML dengan centering content.
 * 
 * @package View
 * @subpackage Layouts
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Masuk' ?> - Lab IVSS</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex items-center justify-center p-4">

    <!-- Background Decoration (Optional) -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-0 left-0 w-full h-full bg-slate-50"></div>
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-blue-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] bg-purple-100 rounded-full blur-3xl opacity-50"></div>
    </div>

    <!-- Main Container Auth -->
    <main class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        
        <!-- Header / Logo Area -->
        <div class="pt-8 px-8 pb-4 text-center">
            <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg mx-auto mb-4">
               <span class="text-2xl font-bold tracking-tighter">IV</span>
            </div>
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Lab IVSS</h1>
            <p class="text-xs text-slate-500 uppercase tracking-widest mt-1 mb-2">Member Portal</p>
        </div>

        <!-- Dynamic Content -->
        <div class="px-8 pb-8">
            <?= $content ?? '' ?>
        </div>
        
    </main>

    <!-- Footer Copyright -->
    <div class="fixed bottom-4 text-center w-full text-xs text-slate-400">
        &copy; <?= date('Y') ?> Lab IVSS Polinema
    </div>

</body>
</html>

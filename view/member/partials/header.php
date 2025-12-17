<?php
/**
 * View Partial Header Member
 * 
 * Header bagian atas yang responsif untuk area member.
 * Berisi tombol toggle sidebar (mobile), judul halaman, dan profil menu.
 * 
 * @package View
 * @subpackage Member/Partials
 */
?>

<header class="bg-white/80 border-b border-gray-100 h-16 fixed top-0 right-0 left-0 lg:left-64 z-30 backdrop-blur-md transition-all duration-300">
    <div class="h-full px-4 lg:px-8 flex items-center justify-between">
        
        <!-- Bagian Kiri: Tombol Toggle Sidebar & Judul Halaman -->
        <div class="flex items-center gap-4">
            <!-- Mobile Menu Button -->
            <button class="lg:hidden p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-100" onclick="document.querySelector('aside').classList.toggle('-translate-x-full')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Judul Halaman Breadcrumb / Title -->
            <div class="hidden sm:block">
                <h2 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-indigo-600">
                    <?= $title ?? 'Dashboard' ?>
                </h2>
            </div>
        </div>

        <!-- Bagian Kanan: User Profile Menu -->
        <div class="flex items-center gap-6">
            
            <!-- Notifikasi (Optional Placeholder) -->
            <button class="relative p-2 text-gray-400 hover:text-blue-600 transition-colors">
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </button>
            
            <!-- Divider Vertical -->
            <div class="h-8 w-px bg-gray-200"></div>

            <!-- User Info -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-700 leading-none">
                        <?= htmlspecialchars($_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'Member Lab') ?>
                    </p>
                    <p class="text-xs text-blue-600 font-medium mt-1">
                        <?= htmlspecialchars($_SESSION['user']['nim'] ?? $_SESSION['nim'] ?? 'Anggota') ?>
                    </p>
                </div>
                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 p-0.5 shadow-md flex items-center justify-center text-white font-bold text-lg border-2 border-white ring-2 ring-blue-50">
                    <?= strtoupper(substr($_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'M', 0, 1)) ?>
                </div>
            </div>
            
        </div>
    </div>
</header>

<?php
// Get current page for active state
$currentPage = $_GET['page'] ?? 'admin';
$userRole = $_SESSION['user']['role'] ?? ($_SESSION['role'] ?? 'member');
?>

<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden transition-opacity duration-300 cursor-pointer" style="opacity: 0;"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 w-60 h-screen bg-white border-r border-slate-200 flex flex-col z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl">
    
    <!-- Logo & Title -->
    <div class="p-4 border-b border-slate-200">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center overflow-hidden">
                <img src="assets/images/logo1.png" alt="IVSS Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h2 class="font-bold text-slate-800">IVSS Admin</h2>
                <span class="text-xs text-slate-500">Portal Lab</span>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
        
        <!-- Dashboard -->
        <a href="index.php?page=admin" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </div>
        </a>
        
        <?php if ($userRole === 'admin'): ?>
        <!-- === MENU ADMIN === -->
        
        <!-- Manajemen User -->
        <a href="index.php?page=admin-users" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-users' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>Manajemen User</span>
            </div>
        </a>
        
        <!-- Setting Landing Page - DROPDOWN -->
        <div class="menu-dropdown">
            <button onclick="toggleDropdown('landingPage')" class="w-full px-3 py-2 rounded-lg text-sm transition-colors text-slate-700 hover:bg-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                    <span>Setting Landing Page</span>
                </div>
                <svg class="w-4 h-4 transition-transform chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="dropdown-landingPage" class="dropdown-content hidden ml-4 mt-1 space-y-1">
                <a href="index.php?page=admin-news" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-news' ? 'bg-blue-100 text-blue-900 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <span>Portal Berita</span>
                    </div>
                </a>
                <a href="index.php?page=admin-team" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-team' ? 'bg-blue-100 text-blue-900 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Anggota Tim</span>
                    </div>
                </a>
                <a href="index.php?page=admin-perkuliahan" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-perkuliahan' ? 'bg-blue-100 text-blue-900 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        <span>Perkuliahan Terkait</span>
                    </div>
                </a>
                <a href="index.php?page=admin-gallery" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-gallery' ? 'bg-blue-100 text-blue-900 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Galeri Foto</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Inventaris & Fasilitas - DROPDOWN -->
        <div class="menu-dropdown">
            <button onclick="toggleDropdown('inventory')" class="w-full px-3 py-2 rounded-lg text-sm transition-colors text-slate-700 hover:bg-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <span>Inventaris & Fasilitas</span>
                </div>
                <svg class="w-4 h-4 transition-transform chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="dropdown-inventory" class="dropdown-content hidden ml-4 mt-1 space-y-1">
                <a href="index.php?page=admin-equip" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-equip' ? 'bg-blue-100 text-blue-900 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                        <span>Inventaris Lab</span>
                    </div>
                </a>
                <a href="index.php?page=admin-facilities" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-facilities' ? 'bg-blue-100 text-blue-900 font-medium' : 'text-slate-600 hover:bg-slate-50' ?>">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>Fasilitas Lab</span>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Publikasi & Penelitian -->
        <a href="index.php?page=admin-research" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-research' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Publikasi & Penelitian</span>
            </div>
        </a>

        <!-- Pengaturan Sistem -->
        <a href="index.php?page=admin-settings" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-settings' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Pengaturan</span>
            </div>
        </a>
        
        <?php elseif ($userRole === 'ketua_lab'): ?>
        <!-- === MENU KETUA LAB === -->
        
        <!-- Approval Member -->
        <a href="index.php?page=admin-registrations" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-registrations' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Approval Member</span>
                <?php if (isset($pendingCount) && $pendingCount > 0): ?>
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?= $pendingCount ?></span>
                <?php endif; ?>
            </div>
        </a>
        
        <!-- Manajemen Riset -->
        <a href="index.php?page=admin-research" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-research' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <span>Manajemen Riset</span>
            </div>
        </a>
        
        <!-- Daftar Dosen Pengampu -->
        <a href="index.php?page=admin-dosen" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-dosen' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Daftar Dosen Pengampu</span>
            </div>
        </a>
        
        <!-- Member & Alumni -->
        <a href="index.php?page=admin-members" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-members' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Member & Alumni</span>
            </div>
        </a>
        
        <!-- Berita Lab -->
        <a href="index.php?page=admin-news" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-news' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <span>Berita Lab</span>
            </div>
        </a>
        
        <!-- Setting Dasar -->
        <a href="index.php?page=admin-settings" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-settings' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                <span>Setting Dasar</span>
            </div>
        </a>
        
        <?php elseif ($userRole === 'dosen'): ?>
        <!-- === MENU DOSEN === -->
        
        <!-- Approval Member -->
        <a href="index.php?page=admin-registrations" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-registrations' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
                <span>Approval Member</span>
                <?php if (isset($pendingCount) && $pendingCount > 0): ?>
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?= $pendingCount ?></span>
                <?php endif; ?>
            </div>
        </a>
        
        <!-- Riset Bimbingan -->
        <a href="index.php?page=admin-research" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-research' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span>Riset Bimbingan</span>
            </div>
        </a>
        
        <!-- Publikasi Dosen -->
        <a href="index.php?page=admin-publications" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-publications' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span>Publikasi Dosen</span>
            </div>
        </a>
        
        <!-- Mahasiswa Bimbingan -->
        <a href="index.php?page=admin-students" class="block px-3 py-2 rounded-lg text-sm transition-colors <?= $currentPage === 'admin-students' ? 'bg-blue-900 text-white font-medium' : 'text-slate-700 hover:bg-slate-100' ?>">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
                <span>Mahasiswa Bimbingan</span>
            </div>
        </a>
        
        <?php endif; ?>
        
    </nav>
    
    <!-- Logout Button -->
    <div class="p-3 border-t border-slate-200">
        <a href="index.php?page=logout" class="block px-3 py-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition-colors">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Logout</span>
            </div>
        </a>
    </div>
    
</aside>

<script>
// Toggle sidebar on mobile
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const sidebarToggleBtn = document.getElementById('sidebarToggle');

if (sidebarToggleBtn) {
    sidebarToggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
    });
}

if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    });
}

// Dropdown toggle function
function toggleDropdown(id) {
    const dropdown = document.getElementById('dropdown-' + id);
    const button = dropdown.previousElementSibling;
    const chevron = button.querySelector('.chevron');
    
    // Toggle hidden class
    dropdown.classList.toggle('hidden');
    
    // Rotate chevron
    if (dropdown.classList.contains('hidden')) {
        chevron.style.transform = 'rotate(0deg)';
    } else {
        chevron.style.transform = 'rotate(180deg)';
    }
}

// Auto-open dropdown if current page is in submenu
document.addEventListener('DOMContentLoaded', function() {
    const currentPage = '<?= $currentPage ?>';
    const dropdowns = document.querySelectorAll('.dropdown-content');
    
    dropdowns.forEach(dropdown => {
        const links = dropdown.querySelectorAll('a');
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href.includes('page=' + currentPage)) {
                dropdown.classList.remove('hidden');
                const chevron = dropdown.previousElementSibling.querySelector('.chevron');
                if (chevron) {
                    chevron.style.transform = 'rotate(180deg)';
                }
            }
        });
    });
});
</script>

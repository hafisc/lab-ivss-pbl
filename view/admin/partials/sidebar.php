<?php
/**
 * View Partial Sidebar Admin
 * 
 * Sidebar navigasi utama untuk panel admin.
 * Responsif (collapsible di mobile), mendukung active state menu,
 * dan role-based menu (menampilkan menu berbeda sesuai role).
 * 
 * @package View
 * @subpackage Admin/Partials
 */

// 1. Ambil State Halaman Aktif dari URL
$currentPage = $_GET['page'] ?? 'admin';
$currentTab = $_GET['tab'] ?? ''; // Tab aktif (jika ada)

// 2. Ambil Role User
$userRole = $_SESSION['user']['role'] ?? ($_SESSION['role'] ?? 'member');

// 3. Helper Function untuk Cek Menu Aktif
function isMenuActive($pages) {
    global $currentPage;
    if (is_array($pages)) {
        return in_array($currentPage, $pages);
    }
    return $currentPage === $pages;
}

function isDropdownItemActive($page, $tab = null) {
    global $currentPage, $currentTab;
    if ($tab) {
        return $currentPage === $page && $currentTab === $tab;
    }
    return $currentPage === $page;
}

// 4. Definisi Group Menu untuk Dropdown Active State
$settingPages = ['admin-settings', 'admin-news', 'admin-team', 'admin-perkuliahan'];
$inventoryPages = ['admin-equip', 'admin-facilities', 'admin-gallery'];

$isSettingActive = isMenuActive($settingPages);
$isInventoryActive = isMenuActive($inventoryPages);
?>

<!-- Overlay Mobile (Gelap saat sidebar terbuka di mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden hidden transition-opacity duration-300 backdrop-blur-sm"></div>

<!-- Sidebar Container -->
<aside id="sidebar" class="fixed left-0 top-0 w-64 h-screen bg-white border-r border-slate-200 flex flex-col z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none">

    <!-- Logo Section -->
    <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-200">
                <!-- Logo IVSS Sederhana -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <div>
                <h2 class="font-bold text-slate-800 text-lg tracking-tight">IVSS Lab</h2>
                <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Admin Portal</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu (Scrollable) -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">

        <!-- DASHBOARD (Common) -->
        <a href="index.php?page=admin" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= $currentPage === 'admin' ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 transition-colors <?= $currentPage === 'admin' ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            Dashboard
        </a>

        <!-- MENU ADMINISTRATOR -->
        <?php if ($userRole === 'admin'): ?>
            <p class="px-3 pt-5 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Master Data</p>

            <!-- Menu: Manajemen User -->
            <a href="index.php?page=admin-users" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isDropdownItemActive('admin-users') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isDropdownItemActive('admin-users') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Manajemen User
            </a>

            <!-- Dropdown: Pengaturan Website -->
            <div class="menu-dropdown group">
                <button onclick="toggleDropdown('settings')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 <?= $isSettingActive ? 'bg-slate-50 text-slate-900' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 transition-colors <?= $isSettingActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Website Setup
                    </div>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="dropdown-settings" class="hidden pl-4 pr-2 py-2 space-y-1">
                    <a href="index.php?page=admin-settings&tab=system" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm transition-colors <?= isDropdownItemActive('admin-settings', 'system') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-500 hover:text-slate-800' ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?= isDropdownItemActive('admin-settings', 'system') ? 'bg-blue-600' : 'bg-slate-300' ?>"></span> Identitas Lab
                    </a>
                    <a href="index.php?page=admin-news" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm transition-colors <?= isDropdownItemActive('admin-news') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-500 hover:text-slate-800' ?>">
                         <span class="w-1.5 h-1.5 rounded-full <?= isDropdownItemActive('admin-news') ? 'bg-blue-600' : 'bg-slate-300' ?>"></span> Portal Berita
                    </a>
                    <a href="index.php?page=admin-team" class="flex items-center gap-2 px-3 py-2 rounded-md text-sm transition-colors <?= isDropdownItemActive('admin-team') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-500 hover:text-slate-800' ?>">
                         <span class="w-1.5 h-1.5 rounded-full <?= isDropdownItemActive('admin-team') ? 'bg-blue-600' : 'bg-slate-300' ?>"></span> Tim Lab
                    </a>
                </div>
            </div>
            
            <!-- Tambahan Menu Admin Lainnya (Inventaris, Galeri, dll) disederhanakan -->
            <a href="index.php?page=admin-equip" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isMenuActive('admin-equip') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isMenuActive('admin-equip') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Inventaris
            </a>

            <!-- Footer & Visi Misi -->
            <a href="index.php?page=admin-footer" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isMenuActive('admin-footer') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isMenuActive('admin-footer') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                Footer Settings
            </a>

        <!-- MENU KETUA LAB -->
        <?php elseif ($userRole === 'ketua_lab'): ?>
            <p class="px-3 pt-5 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Manajemen Lab</p>
            
            <!-- Approval -->
            <a href="index.php?page=admin-registrations" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isMenuActive('admin-registrations') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isMenuActive('admin-registrations') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Approval Member</span>
                <?php if (isset($pendingCount) && $pendingCount > 0): ?>
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?= $pendingCount ?></span>
                <?php endif; ?>
            </a>

            <!-- Riset & Member -->
            <a href="index.php?page=admin-research" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isMenuActive('admin-research') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isMenuActive('admin-research') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                Monitoring Riset
            </a>

            <a href="index.php?page=admin-members" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isMenuActive('admin-members') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isMenuActive('admin-members') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Data Member
            </a>
            
        <!-- MENU DOSEN -->
        <?php elseif ($userRole === 'dosen'): ?>
            <p class="px-3 pt-5 pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Bimbingan</p>

            <a href="index.php?page=admin-registrations" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isMenuActive('admin-registrations') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isMenuActive('admin-registrations') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Approval Mahasiswa
            </a>

            <a href="index.php?page=admin-research" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group <?= isMenuActive('admin-research') ? 'bg-blue-50 text-blue-700 shadow-sm border border-blue-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <svg class="w-5 h-5 transition-colors <?= isMenuActive('admin-research') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Riset & Publikasi
            </a>
        <?php endif; ?>

    </nav>

    <!-- Logout Action -->
    <div class="px-4 py-4 border-t border-slate-200 bg-slate-50">
        <a href="index.php?page=logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors group">
            <svg class="w-5 h-5 transition-colors text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Keluar Akun
        </a>
    </div>

</aside>

<!-- Script Logic Sidebar -->
<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById('dropdown-' + id);
        const btn = dropdown.previousElementSibling;
        const chevron = btn.querySelector('.chevron');
        
        // Toggle Visibility
        dropdown.classList.toggle('hidden');
        
        // Rotate Chevron
        if (dropdown.classList.contains('hidden')) {
            chevron.style.transform = 'rotate(0deg)';
            btn.classList.remove('bg-slate-50', 'text-slate-900');
            btn.classList.add('text-slate-600');
        } else {
            chevron.style.transform = 'rotate(180deg)';
            btn.classList.add('bg-slate-50', 'text-slate-900');
            btn.classList.remove('text-slate-600');
        }
    }

    // Auto-open dropdown jika ada item aktif di dalamnya
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.menu-dropdown').forEach(group => {
            const dropdown = group.querySelector('[id^="dropdown-"]');
            const activeLink = dropdown.querySelector('a.bg-blue-50');
            if (activeLink) {
                // Simulasikan klik untuk membuka
                group.querySelector('button').click();
            }
        });
    });
</script>
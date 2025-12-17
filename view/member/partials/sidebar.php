<?php
/**
 * View Partial Sidebar Member
 * 
 * Sidebar navigasi utama untuk area member. Responsif dan dapat dicollapse.
 * Berisi link ke dashboard, riset, publikasi, profil, dan logout.
 * 
 * @package View
 * @subpackage Member/Partials
 */

// Helper untuk mengecek menu aktif
function is_active($page_name, $current_page) {
    if (is_array($page_name)) {
        foreach ($page_name as $page) {
            if ($current_page === $page || (strpos($current_page, $page) === 0)) return true;
        }
        return false;
    }
    return $current_page === $page_name || (strpos($current_page, $page_name) === 0);
}

$page = $_GET['page'] ?? 'member-dashboard';
?>

<!-- Overlay Mobile -->
<div class="lg:hidden fixed inset-0 bg-black/50 z-20 hidden transition-opacity" 
     onclick="document.querySelector('aside').classList.add('-translate-x-full'); this.classList.add('hidden')"
     id="sidebarOverlay"></div>

<aside class="w-64 bg-white border-r border-gray-100 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-xl lg:shadow-none">
    
    <!-- Logo & Brand Header -->
    <div class="h-16 flex items-center px-6 border-b border-gray-100 bg-white">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-900 tracking-tight">Lab IVSS</h1>
                <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Member Area</p>
            </div>
        </div>
    </div>

    <!-- Navigasi Menu -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1 custom-scrollbar">
        
        <!-- Label Kategori -->
        <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>

        <!-- Menu: Dashboard -->
        <a href="index.php?page=member-dashboard" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group relative
           <?= is_active('member-dashboard', $page) ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 transition-colors <?= is_active('member-dashboard', $page) ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            Dashboard
            <?php if(is_active('member-dashboard', $page)): ?>
                <span class="absolute right-0 h-6 w-1 bg-blue-600 rounded-l-full"></span>
            <?php endif; ?>
        </a>

        <!-- Menu Dropdown: Riset -->
        <div class="space-y-1">
            <?php 
            $research_active = is_active(['member-research', 'member-publications'], $page);
            ?>
            <button onclick="document.getElementById('submenu-research').classList.toggle('hidden'); document.getElementById('arrow-research').classList.toggle('rotate-180')" 
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group
                    <?= $research_active ? 'bg-blue-50/50 text-blue-800' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 transition-colors <?= $research_active ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    Penelitian
                </div>
                <svg id="arrow-research" class="w-4 h-4 text-slate-400 transition-transform duration-200 <?= $research_active ? 'rotate-180' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="submenu-research" class="<?= $research_active ? '' : 'hidden' ?> pl-11 space-y-1">
                <a href="index.php?page=member-research" class="block py-2 text-sm font-medium transition-colors <?= is_active('member-research', $page) ? 'text-blue-600' : 'text-slate-500 hover:text-slate-900' ?>">Riset Saya</a>
                <a href="index.php?page=member-publications" class="block py-2 text-sm font-medium transition-colors <?= is_active('member-publications', $page) ? 'text-blue-600' : 'text-slate-500 hover:text-slate-900' ?>">Publikasi</a>
            </div>
        </div>

        <!-- Label Kategori -->
        <p class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Akun</p>
        
        <!-- Menu: Profil -->
        <a href="index.php?page=member-settings" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 group relative
           <?= is_active('member-settings', $page) || is_active('member-change-password', $page) ? 'bg-blue-50 text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
            <svg class="w-5 h-5 transition-colors <?= is_active('member-settings', $page) || is_active('member-change-password', $page) ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profil & Akun
            <?php if(is_active('member-settings', $page) || is_active('member-change-password', $page)): ?>
                <span class="absolute right-0 h-6 w-1 bg-blue-600 rounded-l-full"></span>
            <?php endif; ?>
        </a>

        <!-- Tombol Logout -->
        <form action="logout.php" method="POST" class="mt-4">
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200 group">
                <svg class="w-5 h-5 transition-colors text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Keluar
            </button>
        </form>
    </nav>
    
    <!-- Bagian Bawah Sidebar (Footer) -->
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            <p class="text-xs font-medium text-slate-500">Sistem Online</p>
        </div>
        <p class="text-[10px] text-slate-400 mt-1">Version 1.0.0 Beta</p>
    </div>
</aside>

<!-- Script Mobile Menu Listener -->
<script>
    const sidebar = document.querySelector('aside');
    const overlay = document.getElementById('sidebarOverlay');
    
    // Observer untuk toggle overlay
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === "attributes" && mutation.attributeName === "class") {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    overlay.classList.remove('hidden');
                } else {
                    overlay.classList.add('hidden');
                }
            }
        });
    });

    observer.observe(sidebar, {
        attributes: true
    });
</script>

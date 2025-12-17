<?php
/**
 * View Partial Header Admin
 * 
 * Header bagian atas untuk panel admin.
 * Memuat toggle sidebar (mobile), indikator role, dan notifikasi dropdown.
 * 
 * @package View
 * @subpackage Admin/Partials
 */
?>
<!-- Header Wrapper -->
<header class="bg-white/90 backdrop-blur-sm border-b border-slate-200 px-4 md:px-6 h-16 flex items-center justify-between sticky top-0 z-20 shadow-sm transition-all duration-300">
    
    <!-- Bagian Kiri: Hamburger & Judul Halaman -->
    <div class="flex items-center gap-4">
        <!-- Tombol Toggle Sidebar (Hanya Mobile) -->
        <button id="sidebarToggle" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-blue-600 transition-all duration-200" aria-label="Toggle Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Logika Badge Role -->
        <?php 
        $userRole = $_SESSION['user']['role'] ?? $_SESSION['role'] ?? 'member';
        $roleLabel = 'Member';
        $roleClass = 'bg-gray-100 text-gray-700';
        
        switch($userRole) {
            case 'admin':
                $roleLabel = 'Administrator';
                $roleClass = 'bg-blue-100 text-blue-700 border border-blue-200';
                break;
            case 'ketua_lab':
                $roleLabel = 'Ketua Lab';
                $roleClass = 'bg-orange-100 text-orange-700 border border-orange-200';
                break;
            case 'dosen':
                $roleLabel = 'Dosen Pembimbing';
                $roleClass = 'bg-purple-100 text-purple-700 border border-purple-200';
                break;
        }
        ?>

        <!-- Judul Halaman & Badge -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
            <h1 class="text-lg font-bold text-slate-800 tracking-tight"><?= $title ?? 'Admin Panel' ?></h1>
            <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $roleClass ?>">
                <?= $roleLabel ?>
            </span>
        </div>
    </div>
    
    <!-- Bagian Kanan: User & Notifikasi -->
    <div class="flex items-center gap-4">
        
        <!-- Dropdown Notifikasi -->
        <?php
        // Menggunakan variabel global $notificationCount dan $notifications dari layout utama
        $notifCount = $notificationCount ?? 0;
        $notifList = $notifications ?? [];
        ?>
        <div class="relative">
            <button id="notificationBtn" class="relative p-2 rounded-full text-slate-500 hover:bg-slate-100 hover:text-blue-600 transition-colors focus:outline-none" title="Notifikasi">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                
                <!-- Badge Hitungan Notifikasi -->
                <?php if ($notifCount > 0): ?>
                    <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white animate-pulse">
                        <?= $notifCount > 9 ? '9+' : $notifCount ?>
                    </span>
                <?php endif; ?>
            </button>
            
            <!-- Isi Dropdown Notifikasi -->
            <div id="notificationDropdown" class="hidden absolute right-0 mt-3 w-80 md:w-96 bg-white rounded-xl shadow-2xl border border-slate-100 z-50 transform origin-top-right transition-all">
                
                <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-xl">
                    <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                    <span class="text-xs text-blue-600 hover:underline cursor-pointer">Tandai sudah dibaca</span>
                </div>
                
                <div class="max-h-[350px] overflow-y-auto py-1">
                    <?php if ($notifCount > 0 && !empty($notifList)): ?>
                        <?php foreach ($notifList as $notif): ?>
                            <!-- Item Notifikasi -->
                            <a href="index.php?page=admin-registrations&action=view&id=<?= $notif['id'] ?>" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-50 last:border-0 transition-colors group">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs ring-2 ring-white shadow-sm">
                                            <?= strtoupper(substr($notif['name'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-slate-800 group-hover:text-blue-600 truncate transition-colors">
                                            <?= htmlspecialchars($notif['name']) ?>
                                        </p>
                                        <p class="text-xs text-slate-500 mt-0.5 truncate">
                                            <?= htmlspecialchars($notif['research_title'] ?? 'Registrasi baru menunggu approval') ?>
                                        </p>
                                        <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Baru saja
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 self-center">
                                        <span class="w-2 h-2 bg-blue-500 rounded-full block"></span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- State Kosong -->
                        <div class="px-4 py-8 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <p class="text-sm text-slate-500 font-medium">Tidak ada notifikasi baru</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($notifCount > 0): ?>
                <div class="px-4 py-2 border-t border-slate-100 bg-slate-50/50 rounded-b-xl text-center">
                    <a href="index.php?page=admin-registrations" class="text-xs font-bold text-blue-600 hover:text-blue-800">Lihat Semua</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Divider Vertical -->
        <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

        <!-- Profil User -->
        <div class="flex items-center gap-3 pl-1">
            <div class="hidden md:block text-right">
                <p class="text-sm font-bold text-slate-700 leading-tight">
                    <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?>
                </p>
                <p class="text-xs text-slate-500 font-medium truncate max-w-[120px]">
                    <?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>
                </p>
            </div>
            <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 p-0.5 shadow-md">
                <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                     <!-- Jika ada foto profil, gunakan img. Jika tidak, inisial. -->
                     <span class="text-blue-700 font-bold text-sm md:text-base">
                        <?= strtoupper(substr($_SESSION['user']['name'] ?? 'A', 0, 1)) ?>
                     </span>
                </div>
            </div>
        </div>
        
    </div>
    
</header>

<!-- Script Logic Dropdown Notifikasi -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('notificationBtn');
    const dropdown = document.getElementById('notificationDropdown');
    
    if (btn && dropdown) {
        // Toggle Dropdown
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });
        
        // Tutup jika klik di luar
        document.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
        
        // Mencegah penutupan jika klik di dalam dropdown
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>

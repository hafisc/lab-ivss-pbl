<!-- Header/Topbar -->
<header class="bg-white border-b border-slate-200 px-4 md:px-6 h-14 flex items-center justify-between">
    
    <!-- Left Section: Hamburger + Title -->
    <div class="flex items-center gap-3">
        <!-- Hamburger Menu Button (Mobile Only) -->
        <button id="sidebarToggle" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 active:bg-slate-200 transition-all duration-200" aria-label="Toggle Sidebar">
            <svg class="w-6 h-6 text-slate-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Page Title with Role Badge -->
        <?php 
        $userRole = $_SESSION['user']['role'] ?? $_SESSION['role'] ?? 'member';
        $roleLabel = '';
        $roleColor = '';
        
        switch($userRole) {
            case 'admin':
                $roleLabel = 'Admin';
                $roleColor = 'bg-blue-100 text-blue-800';
                break;
            case 'ketua_lab':
                $roleLabel = 'Ketua Lab';
                $roleColor = 'bg-orange-100 text-orange-800';
                break;
            case 'dosen':
                $roleLabel = 'Dosen';
                $roleColor = 'bg-purple-100 text-purple-800';
                break;
            default:
                $roleLabel = 'Member';
                $roleColor = 'bg-gray-100 text-gray-800';
        }
        ?>
        <div class="flex items-center gap-2">
            <h1 class="text-base md:text-lg font-semibold text-slate-800"><?= $title ?? 'Dashboard' ?></h1>
            <span class="hidden sm:inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $roleColor ?>">
                <?= $roleLabel ?>
            </span>
        </div>
    </div>
    
    <!-- User Info & Notifications -->
    <div class="flex items-center gap-3">
        <!-- Notification Bell -->
        <?php
        // Get notification count based on role
        $notifCount = 0;
        
        // Nanti akan diambil dari database sesuai role
        // Untuk sekarang dummy data
        if ($userRole === 'dosen') {
            // Notifikasi untuk dosen: pendaftar baru yang pilih dia, update riset, dll
            $notifCount = 3; // dummy
        } elseif ($userRole === 'ketua_lab') {
            // Notifikasi untuk ketua lab: pendaftar pending approval, pengumuman penting
            $notifCount = 5; // dummy
        } elseif ($userRole === 'admin') {
            // Notifikasi untuk admin: sistem, user baru, dll
            $notifCount = 2; // dummy
        }
        ?>
        
        <!-- Notification Dropdown -->
        <div class="relative">
            <button id="notificationBtn" class="relative p-2 rounded-lg hover:bg-slate-100 transition-colors group" title="Notifikasi">
                <svg class="w-5 h-5 text-slate-600 group-hover:text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <?php if ($notifCount > 0): ?>
                    <span class="absolute top-0 right-0 flex items-center justify-center min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full px-1 animate-pulse">
                        <?= $notifCount > 9 ? '9+' : $notifCount ?>
                    </span>
                <?php endif; ?>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-lg shadow-xl border border-slate-200 z-50 max-h-[500px] overflow-hidden">
                <!-- Header -->
                <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                    <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                    <button class="p-1 hover:bg-slate-200 rounded transition-colors" title="Pengaturan">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Tabs -->
                <div class="flex border-b border-slate-200 bg-white">
                    <button class="flex-1 px-4 py-2 text-xs font-medium text-slate-700 border-b-2 border-blue-600 bg-blue-50">
                        Penting
                    </button>
                    <button class="flex-1 px-4 py-2 text-xs font-medium text-slate-500 hover:bg-slate-50 transition-colors">
                        Notifikasi Lainnya
                    </button>
                </div>
                
                <!-- Notification List -->
                <div class="overflow-y-auto max-h-[400px]">
                    <?php if ($notifCount > 0): ?>
                        
                        <?php if ($userRole === 'admin'): ?>
                        <!-- Admin Notifications -->
                        <a href="index.php?page=admin-registrations" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-100 transition-colors">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-900 leading-tight">Pendaftar Member Baru</p>
                                    <p class="text-xs text-slate-600 mt-0.5">Ada <?= $notifCount ?> pendaftar yang menunggu approval</p>
                                    <p class="text-xs text-slate-400 mt-1">Baru saja</p>
                                </div>
                                <button class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </a>
                        
                        <?php elseif ($userRole === 'dosen'): ?>
                        <!-- Dosen Notifications -->
                        <a href="index.php?page=admin-registrations" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-100 transition-colors">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-900 leading-tight">Mahasiswa Memilih Anda Sebagai Pembimbing</p>
                                    <p class="text-xs text-slate-600 mt-0.5"><?= $notifCount ?> mahasiswa menunggu approval Anda</p>
                                    <p class="text-xs text-slate-400 mt-1">2 jam yang lalu</p>
                                </div>
                                <button class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </a>
                        
                        <?php elseif ($userRole === 'ketua_lab'): ?>
                        <!-- Ketua Lab Notifications -->
                        <a href="index.php?page=admin-registrations" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-100 transition-colors">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-900 leading-tight">Pending Final Approval</p>
                                    <p class="text-xs text-slate-600 mt-0.5"><?= $notifCount ?> pendaftar menunggu approval final Anda</p>
                                    <p class="text-xs text-slate-400 mt-1">1 jam yang lalu</p>
                                </div>
                                <button class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </a>
                        <?php endif; ?>
                        
                        <!-- Dummy notification 2 -->
                        <a href="#" class="block px-4 py-3 hover:bg-slate-50 border-b border-slate-100 transition-colors">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-slate-900 leading-tight">Update Sistem</p>
                                    <p class="text-xs text-slate-600 mt-0.5">Sistem berhasil diupdate ke versi terbaru</p>
                                    <p class="text-xs text-slate-400 mt-1">3 jam yang lalu</p>
                                </div>
                            </div>
                        </a>
                        
                    <?php else: ?>
                        <!-- Empty State -->
                        <div class="px-4 py-8 text-center">
                            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <p class="text-sm text-slate-600 font-medium">Tidak ada notifikasi</p>
                            <p class="text-xs text-slate-500 mt-1">Semua notifikasi sudah dibaca</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Footer -->
                <?php if ($notifCount > 0): ?>
                <div class="px-4 py-2 border-t border-slate-200 bg-slate-50">
                    <a href="index.php?page=admin-notifications" class="block text-center text-xs font-medium text-blue-600 hover:text-blue-800 py-1">
                        Lihat Semua Notifikasi
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <p class="text-xs md:text-sm text-slate-500 hidden sm:block">
            Halo, <span class="font-medium text-slate-700"><?= $_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'Admin' ?></span>
        </p>
        <div class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-slate-200 flex items-center justify-center">
            <span class="text-sm font-semibold text-slate-600">
                <?= strtoupper(substr($_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'A', 0, 1)) ?>
            </span>
        </div>
    </div>
    
</header>

<!-- Notification Dropdown Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    
    if (notificationBtn && notificationDropdown) {
        // Toggle dropdown saat button diklik
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown saat click di luar
        document.addEventListener('click', function(e) {
            if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
        
        // Prevent dropdown close saat click di dalam dropdown
        notificationDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>

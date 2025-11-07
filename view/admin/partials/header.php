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
        
        <a href="index.php?page=admin-notifications" class="relative p-2 rounded-lg hover:bg-slate-100 transition-colors group" title="Notifikasi">
            <svg class="w-5 h-5 text-slate-600 group-hover:text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <?php if ($notifCount > 0): ?>
                <span class="absolute top-0 right-0 flex items-center justify-center min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full px-1 animate-pulse">
                    <?= $notifCount > 9 ? '9+' : $notifCount ?>
                </span>
            <?php endif; ?>
        </a>
        
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

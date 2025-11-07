<!-- Header/Topbar -->
<header class="bg-white border-b border-slate-200 px-4 md:px-6 h-14 flex items-center justify-between">
    
    <!-- Left Section: Hamburger + Title -->
    <div class="flex items-center gap-3">
        <!-- Hamburger Menu Button (Mobile Only) -->
        <button id="sidebarToggle" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Toggle Sidebar">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- Page Title -->
        <h1 class="text-base md:text-lg font-semibold text-slate-800"><?= $title ?? 'Dashboard' ?></h1>
    </div>
    
    <!-- User Info -->
    <div class="flex items-center gap-3">
        <p class="text-xs md:text-sm text-slate-500 hidden sm:block">
            Halo, <span class="font-medium text-slate-700"><?= $_SESSION['name'] ?? $_SESSION['email'] ?? 'Member' ?></span>
        </p>
        <div class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-blue-600 flex items-center justify-center">
            <span class="text-sm font-semibold text-white">
                <?= strtoupper(substr($_SESSION['name'] ?? 'M', 0, 1)) ?>
            </span>
        </div>
    </div>
    
</header>

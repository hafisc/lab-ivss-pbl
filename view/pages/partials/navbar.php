<?php
$navbar = [];
try {
    $res = pg_query($GLOBALS['db'] ?? null, "SELECT * FROM navbar_settings LIMIT 1");
    if ($res && $row = pg_fetch_assoc($res)) {
        $navbar = $row;
        if (is_string($navbar['menu_items'])) $navbar['menu_items'] = json_decode($navbar['menu_items'], true);
    }
} catch (Exception $e) {}

$logo_url = !empty($navbar['logo_url']) && file_exists($navbar['logo_url']) ? $navbar['logo_url'] : 'assets/images/logo1.png';
$menu_items = $navbar['menu_items'] ?? [['label' => 'Beranda', 'url' => 'index.php?page=home#hero'], ['label' => 'Profil', 'url' => 'index.php?page=home#profil'], ['label' => 'Riset', 'url' => 'index.php?page=home#riset'], ['label' => 'Fasilitas', 'url' => 'index.php?page=home#fasilitas'], ['label' => 'Member', 'url' => 'index.php?page=home#team'], ['label' => 'Berita', 'url' => 'index.php?page=news'], ['label' => 'Kontak', 'url' => '#footer']];

// Ensure URLs are absolute/correct relative to root for shared usage
?>

<!-- Fixed Header Wrapper -->
<header class="fixed top-0 left-0 w-full z-[9999] transition-all duration-300 transform" id="main-header">
    <!-- Topbar -->
    <div class="bg-blue-900 text-white text-[10px] md:text-xs py-2 text-center transition-all duration-300" id="topbar">
        <?= htmlspecialchars($navbar['topbar_text'] ?? 'Laboratorium IVSS - POLINEMA') ?>
    </div>

    <!-- Main Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-md h-20 transition-all duration-300 border-b border-gray-100" id="navbar-inner">
        <div class="container mx-auto px-4 h-full flex items-center justify-between">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3 group cursor-pointer" onclick="window.location.href='index.php'">
                <img src="<?= $logo_url ?>" class="w-12 h-12 object-contain transition-transform group-hover:scale-105">
                <div class="flex flex-col">
                    <h1 class="text-blue-900 font-bold leading-tight text-sm md:text-base"><?= htmlspecialchars($navbar['institution_name'] ?? 'POLINEMA') ?></h1>
                    <p class="text-[10px] text-gray-500 font-medium"><?= htmlspecialchars($navbar['lab_name'] ?? 'Lab Intelligent Vision and Smart System') ?></p>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <?php foreach ($menu_items as $m): ?>
                    <a href="<?= htmlspecialchars($m['url']) ?>" class="text-sm font-semibold text-gray-600 hover:text-blue-900 transition-colors relative group">
                        <?= htmlspecialchars($m['label']) ?>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-900 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Login Button & Mobile Menu Toggle -->
            <div class="flex items-center gap-3">
                <a href="<?= htmlspecialchars($navbar['login_url'] ?? 'index.php?page=login') ?>" class="bg-blue-900 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-blue-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Login
                </a>
                
                <!-- Mobile Menu Button (Hamburger) -->
                <button class="md:hidden text-gray-700 hover:text-blue-900 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Menu Dropdown -->
    <div class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl" id="mobile-menu">
        <div class="px-4 pt-2 pb-4 space-y-1">
             <?php foreach ($menu_items as $m): ?>
                <a href="<?= htmlspecialchars($m['url']) ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-900 hover:bg-blue-50 rounded-md"><?= htmlspecialchars($m['label']) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</header>

<!-- Spacer to prevent content overlap -->
<div class="h-[100px]" id="header-spacer"></div>

<script>
    // Scroll Effect: Hide Topbar on Scroll to save space
    let lastScroll = 0;
    const header = document.getElementById('main-header');
    const topbar = document.getElementById('topbar');
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            // Scrolled down
            topbar.style.height = '0';
            topbar.style.padding = '0';
            topbar.style.overflow = 'hidden';
            topbar.style.opacity = '0';
        } else {
            // At top
            topbar.style.height = ''; // Reset (auto/defined by css)
            topbar.style.padding = '';
            topbar.style.opacity = '1';
        }
        lastScroll = currentScroll;
    });
</script>

<?php
// Get navbar settings from database
if (!isset($navbar)) {
    $navbar = [];
    try {
        if (isset($GLOBALS['db'])) {
            $result = pg_query($GLOBALS['db'], "SELECT * FROM navbar_settings LIMIT 1");
            if ($result && $row = pg_fetch_assoc($result)) {
                $navbar = $row;
                // Decode JSON fields
                if (isset($navbar['menu_items']) && is_string($navbar['menu_items'])) {
                    $navbar['menu_items'] = json_decode($navbar['menu_items'], true) ?? [];
                }
            }
        }
    } catch (Exception $e) {
        // Fallback to defaults
    }
}

// Set defaults
$topbar_text = htmlspecialchars($navbar['topbar_text'] ?? 'Laboratorium Intelligent Vision and Smart System (IVSS) – Jurusan Teknologi Informasi – Politeknik Negeri Malang');
$institution_name = htmlspecialchars($navbar['institution_name'] ?? 'Politeknik Negeri Malang');
$lab_name = htmlspecialchars($navbar['lab_name'] ?? 'Lab Intelligent Vision and Smart System');
$logo_url = htmlspecialchars($navbar['logo_url'] ?? 'assets/images/logo1.png');
$login_url = htmlspecialchars($navbar['login_url'] ?? 'index.php?page=login');
$menu_items = $navbar['menu_items'] ?? [
    ['label' => 'Beranda', 'url' => '#beranda', 'order' => 1],
    ['label' => 'Profil', 'url' => '#profil', 'order' => 2],
    ['label' => 'Riset', 'url' => '#riset', 'order' => 3],
    ['label' => 'Fasilitas', 'url' => '#fasilitas', 'order' => 4],
    ['label' => 'Member', 'url' => '#member', 'order' => 5],
    ['label' => 'Berita', 'url' => '#berita', 'order' => 6],
    ['label' => 'Kontak', 'url' => '#kontak', 'order' => 7],
];

// Sort by order
usort($menu_items, function ($a, $b) {
    return ($a['order'] ?? 999) - ($b['order'] ?? 999);
});
?>

<!-- Topbar Mini -->
<div class="bg-blue-900 text-white text-xs py-2">
    <div class="container mx-auto px-4">
        <p class="text-center">
            <?= $topbar_text ?>
        </p>
    </div>
</div>

<!-- Navbar Utama -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Logo dan Nama Lab -->
            <div class="flex items-center space-x-3">
                <img src="<?= $logo_url ?>" alt="Lab Logo" class="w-10 h-10 object-contain">
                <div>
                    <h1 class="text-xl font-bold text-blue-900"><?= $institution_name ?></h1>
                    <p class="text-xs text-gray-600"><?= $lab_name ?></p>
                </div>
            </div>

            <!-- Menu Desktop - Centered -->
            <div class="hidden md:flex items-center justify-center flex-1 space-x-6">
                <?php foreach ($menu_items as $menu): ?>
                    <a href="<?= htmlspecialchars($menu['url']) ?>" class="text-gray-700 hover:text-blue-900 font-medium transition">
                        <?= htmlspecialchars($menu['label']) ?>
                    </a>
                <?php endforeach; ?>
                <a href="#beranda" class="text-gray-700 hover:text-blue-900 font-medium transition">Beranda</a>
                <a href="#profil" class="text-gray-700 hover:text-blue-900 font-medium transition">Profil</a>
                <a href="#riset" class="text-gray-700 hover:text-blue-900 font-medium transition">Riset</a>
                <a href="#fasilitas" class="text-gray-700 hover:text-blue-900 font-medium transition">Fasilitas</a>
                <a href="#member" class="text-gray-700 hover:text-blue-900 font-medium transition">Member</a>
                <a href="#berita" class="text-gray-700 hover:text-blue-900 font-medium transition">Berita</a>
                <!-- <a href="#kontak" class="text-gray-700 hover:text-blue-900 font-medium transition">Kontak</a> -->
            </div>

            <!-- Tombol Login - Agak ke kiri -->
            <div class="hidden md:flex items-center pr-4">
                <a href="<?= $login_url ?>" target="_blank" rel="noopener noreferrer" class="px-4 py-2 bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800 transition">
                    Login
                </a>
            </div>

            <!-- Tombol Mobile Menu -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-4 py-3 space-y-2">
            <?php foreach ($menu_items as $menu): ?>
                <a href="<?= htmlspecialchars($menu['url']) ?>" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">
                    <?= htmlspecialchars($menu['label']) ?>
                </a>
            <?php endforeach; ?>
            <div class="pt-3 space-y-2">
                <a href="<?= $login_url ?>" target="_blank" rel="noopener noreferrer" class="block py-2 px-4 text-center bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800">
            <a href="#beranda" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Beranda</a>
            <a href="#profil" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Profil</a>
            <a href="#riset" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Riset</a>
            <a href="#fasilitas" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Fasilitas</a>
            <a href="#member" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Member</a>
            <a href="#berita" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Berita</a>
            <!-- <a href="#kontak" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Kontak</a> -->
                <div class="pt-3 space-y-2">
                <a href="index.php?page=login" target="_blank" rel="noopener noreferrer" class="block py-2 px-4 text-center bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Script Toggle Mobile Menu -->
<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });

    // Close mobile menu saat link diklik
    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.add('hidden');
        });
    });
</script>
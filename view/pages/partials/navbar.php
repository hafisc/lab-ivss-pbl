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
$menu_items = $navbar['menu_items'] ?? [['label' => 'Beranda', 'url' => '#beranda']];
?>

<div class="bg-blue-900 text-white text-[10px] md:text-xs py-2 text-center">
    <?= htmlspecialchars($navbar['topbar_text'] ?? 'Laboratorium IVSS - POLINEMA') ?>
</div>

<nav class="bg-white shadow-md sticky top-0 z-50 h-30">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="<?= $logo_url ?>" class="w-14 h-14 object-contain">
            <div>
                <h1 class="text-blue-900 font-bold leading-tight"><?= htmlspecialchars($navbar['institution_name'] ?? 'POLINEMA') ?></h1>
                <p class="text-[10px] text-gray-500"><?= htmlspecialchars($navbar['lab_name'] ?? 'Lab IVSS') ?></p>
            </div>
        </div>

        <div class="hidden md:flex space-x-6 items-center">
            <?php foreach ($menu_items as $m): ?>
                <a href="<?= htmlspecialchars($m['url']) ?>" class="text-sm font-medium text-gray-700 hover:text-blue-900"><?= htmlspecialchars($m['label']) ?></a>
            <?php endforeach; ?>
        </div>

        <div">
            <a href="<?= htmlspecialchars($navbar['login_url'] ?? 'index.php?page=login') ?>" class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm">Login</a>
        </div>
    </div>
</nav>
<?php ob_start(); ?>



<!-- Alert Messages -->
<?php if (isset($_SESSION['success'])): ?>
<div class="mb-3 bg-green-50 border-l-4 border-green-500 p-3 rounded-lg">
    <p class="text-xs text-green-700"><?= $_SESSION['success'] ?></p>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-3 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
    <p class="text-xs text-red-700"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="grid lg:grid-cols-3 gap-4">
    <!-- Sidebar Navigation -->
    <div class="lg:col-span-1">
        <div class="bg-white border border-slate-200 rounded-xl p-3">
            <h3 class="text-xs font-semibold text-slate-800 mb-2">Menu Pengaturan</h3>
            <nav class="space-y-1">
                <a href="?page=admin-settings&tab=profile" 
                   class="flex items-center gap-2 px-2 py-1.5 rounded-lg text-xs <?= (!isset($_GET['tab']) || $_GET['tab'] === 'profile') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-50' ?> transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </a>
                <a href="?page=admin-settings&tab=security" 
                   class="flex items-center gap-2 px-2 py-1.5 rounded-lg text-xs <?= (isset($_GET['tab']) && $_GET['tab'] === 'security') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-50' ?> transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Keamanan
                </a>
                <a href="?page=admin-settings&tab=system" 
                   class="flex items-center gap-2 px-2 py-1.5 rounded-lg text-xs <?= (isset($_GET['tab']) && $_GET['tab'] === 'system') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-50' ?> transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Sistem
                </a>
            </nav>
        </div>
    </div>

    <!-- Content Area -->
    <div class="lg:col-span-2">
        <?php 
        $tab = $_GET['tab'] ?? 'profile';
        
        if ($tab === 'profile') {
            include __DIR__ . '/profile.php';
        } elseif ($tab === 'security') {
            include __DIR__ . '/security.php';
        } elseif ($tab === 'system') {
            include __DIR__ . '/system.php';
        }
        ?>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Pengaturan";
include __DIR__ . "/../../layouts/admin.php";
?>

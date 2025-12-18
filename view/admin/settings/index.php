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

    <!-- Content Area -->
    <div>
        <?php 
        $tab = $_GET['tab'] ?? 'profile';
        
        if ($tab === 'profile') {
            include __DIR__ . '/profile.php';
        } elseif ($tab === 'security') {
            include __DIR__ . '/security.php';
        }
        ?>
    </div>

<?php
$content = ob_get_clean();
$title = "Pengaturan";
include __DIR__ . "/../../layouts/admin.php";
?>

<?php ob_start(); ?>

<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg md:text-xl font-bold text-slate-800">Edit visi misi</h2>
        <p class="text-xs text-slate-500 mt-0.5">Ubah informasi visi misi</p>
    </div>
    <a href="index.php?page=admin-news" 
       class="inline-flex items-center px-3 py-2 bg-slate-500 hover:bg-slate-600 text-white text-xs font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali
    </a>
</div>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-3 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
    <p class="text-xs text-red-700"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="bg-white border border-slate-200 rounded-xl p-4">
    <form method="POST" action="index.php?page=admin-visimisi&action=update&id=<?= $visimisiItem['id'] ?>" enctype="multipart/form-data" class="space-y-4">

        <div>
            <label for="visi" class="block text-xs font-medium text-slate-700 mb-1.5">visi</label>
            <textarea id="visi" name="visi" rows="10" required
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-xs"><?= htmlspecialchars($visimisiItem['visi']) ?></textarea>
        </div>
        <div>
            <label for="misi" class="block text-xs font-medium text-slate-700 mb-1.5">misi</label>
            <textarea id="misi" name="misi" rows="10" required
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-xs"><?= htmlspecialchars($visimisiItem['misi']) ?></textarea>
        </div>
        <div class="flex gap-2 pt-3 border-t">
            <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors text-xs">
                Update visi misi
            </button>
            <a href="index.php?page=admin-visimisi" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg text-xs">
                Batal
            </a>
        </div>
    </form>
</div>


<?php
$content = ob_get_clean();
$title = "Edit visi misi";
include __DIR__ . "/../../layouts/admin.php";
?>

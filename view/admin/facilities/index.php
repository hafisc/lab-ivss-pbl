<?php ob_start(); ?>

<!-- Alert Messages -->
<?php if (isset($_SESSION['success'])):?> 
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

<!-- Header & Add Button -->
<div class="mb-4 flex items-center justify-between">
    <h1 class="text-xl font-bold text-slate-800">Fasilitas Lab</h1>
    <a href="index.php?page=admin-facilities-create" 
       class="inline-flex items-center px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Fasilitas
    </a>
</div>

<!-- Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-500">
            <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-3">Gambar</th>
                    <th scope="col" class="px-6 py-3">Nama Fasilitas</th>
                    <th scope="col" class="px-6 py-3">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($facilities)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-500">Belum ada data fasilitas</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($facilities as $facility): ?>
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <?php if (!empty($facility['image'])): ?>
                                    <img src="<?= htmlspecialchars($facility['image']) ?>" alt="Facility" class="w-16 h-16 object-cover rounded-lg">
                                <?php else: ?>
                                    <span class="text-xs text-slate-400">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-900">
                                <?= htmlspecialchars($facility['name']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <?= htmlspecialchars($facility['description']) ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="index.php?page=admin-facilities-edit&id=<?= $facility['id'] ?>" class="font-medium text-blue-600 hover:underline">Edit</a>
                                    <a href="index.php?page=admin-facilities-delete&id=<?= $facility['id'] ?>" class="font-medium text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Manajemen Fasilitas";
include __DIR__ . "/../../layouts/admin.php";
?>

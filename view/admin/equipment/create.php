<?php ob_start(); ?>

<h2 class="text-lg font-semibold text-slate-800 mb-4">Tambah Peralatan</h2>

<form method="post" action="index.php?page=admin-equip&action=create" enctype="multipart/form-data" class="space-y-3">
    <div>
        <label class="block text-xs font-medium text-slate-700 mb-1">Nama Peralatan</label>
        <input type="text" name="name" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1">Kategori</label>
            <select name="category" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs">
                <option value="Hardware">Hardware</option>
                <option value="Software">Software</option>
                <option value="Aksesoris">Aksesoris</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1">Brand</label>
            <input type="text" name="brand" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1">Qty</label>
            <input type="number" name="quantity" value="1" min="1" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1">Kondisi</label>
            <select name="condition" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-700 mb-1">Lokasi</label>
            <input type="text" name="location" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs">
        </div>
    </div>

    <div>
        <label class="block text-xs font-medium text-slate-700 mb-1">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs"></textarea>
    </div>

    <div>
        <label class="block text-xs font-medium text-slate-700 mb-1">Gambar Peralatan (opsional)</label>
        <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white">
        <p class="text-[10px] text-slate-500 mt-1">Disarankan rasio 4:3.</p>
    </div>

    <div class="flex items-center gap-2">
        <input id="is_active" type="checkbox" name="is_active" value="1" checked class="h-4 w-4 text-blue-600 border-slate-300 rounded">
        <label for="is_active" class="text-xs text-slate-700">Tampilkan di landing page</label>
    </div>

    <div class="flex items-center gap-2 pt-2">
        <button type="submit" class="px-3 py-1.5 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded-lg">
            Simpan
        </button>
        <a href="index.php?page=admin-equip" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium rounded-lg">
            Batal
        </a>
    </div>
</form>

<?php
$content = ob_get_clean();
$title = "Tambah Peralatan";
include __DIR__ . "/../../layouts/admin.php";
?>

<?php ob_start(); ?>

<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800">Tambah Foto</h1>
        <a href="index.php?page=admin-gallery" class="text-slate-500 hover:text-slate-700 text-sm">Kembali</a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-6">
        <form action="index.php?page=admin-gallery-store" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul Foto</label>
                <input type="text" name="title" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Gambar (Wajib)</label>
                <input type="file" name="image" accept="image/*" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Tambah Foto";
include __DIR__ . "/../../layouts/admin.php";
?>

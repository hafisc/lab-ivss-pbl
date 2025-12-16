<?php 
// Mulai output buffering untuk menangkap konten
ob_start(); 
// Variabel $data diisi oleh VisiMisiController->edit()
// $data berisi: ['id', 'visi', 'misi'] 
?>

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

<div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-xl p-6 md:p-8 shadow-sm">
    <h2 class="text-xl font-semibold text-slate-800 mb-6 border-b pb-3">
        Edit Visi & Misi Laboratorium
    </h2>

    <form action="index.php?page=admin-visimisi&action=update" method="POST">
        
        <input type="hidden" name="id" value="<?= htmlspecialchars($data['id'] ?? '') ?>">

        <div class="mb-5">
            <label for="visi" class="block text-sm font-medium text-slate-700 mb-2">Visi</label>
            <textarea 
                name="visi" 
                id="visi" 
                rows="6" 
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm"
                required
            ><?= htmlspecialchars($data['visi'] ?? '') ?></textarea>
            <p class="mt-1 text-xs text-slate-500">Masukkan Pernyataan Visi Lab.</p>
        </div>

        <div class="mb-6">
            <label for="misi" class="block text-sm font-medium text-slate-700 mb-2">Misi</label>
            <textarea 
                name="misi" 
                id="misi" 
                rows="8" 
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm"
                required
            ><?= htmlspecialchars($data['misi'] ?? '') ?></textarea>
            <p class="mt-1 text-xs text-slate-500">Masukkan daftar Misi Lab.</p>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<?php
// Tangkap konten dan kirim ke layout admin
$content = ob_get_clean();
$title = "Edit Visi & Misi"; // Judul halaman
include __DIR__ . "/../../layouts/admin.php"; // Pastikan path ini benar ke file layout admin Anda
?>
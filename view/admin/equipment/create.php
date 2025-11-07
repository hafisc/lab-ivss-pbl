<?php ob_start(); ?>

<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg md:text-xl font-bold text-slate-800">Tambah Peralatan</h2>
        <p class="text-xs text-slate-500 mt-0.5">Tambah inventaris peralatan lab</p>
    </div>
    <a href="index.php?page=admin-equip" 
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
    <form method="POST" action="index.php?page=admin-equip&action=store" class="space-y-4">
        
        <div>
            <label for="name" class="block text-xs font-medium text-slate-700 mb-1.5">Nama Peralatan *</label>
            <input type="text" id="name" name="name" required
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"
                   placeholder="Contoh: Laptop Dell XPS, Router Cisco, dll">
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label for="category" class="block text-xs font-medium text-slate-700 mb-1.5">Kategori *</label>
                <select id="category" name="category" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                    <option value="">Pilih Kategori</option>
                    <option value="Hardware">Hardware</option>
                    <option value="Software">Software</option>
                    <option value="Aksesoris">Aksesoris</option>
                </select>
            </div>

            <div>
                <label for="brand" class="block text-xs font-medium text-slate-700 mb-1.5">Brand/Merek</label>
                <input type="text" id="brand" name="brand"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"
                       placeholder="Contoh: Dell, HP, Cisco">
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-3">
            <div>
                <label for="quantity" class="block text-xs font-medium text-slate-700 mb-1.5">Jumlah *</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
            </div>

            <div>
                <label for="condition" class="block text-xs font-medium text-slate-700 mb-1.5">Kondisi *</label>
                <select id="condition" name="condition" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                    <option value="baik">Baik</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="rusak">Rusak</option>
                </select>
            </div>

            <div>
                <label for="purchase_year" class="block text-xs font-medium text-slate-700 mb-1.5">Tahun Pembelian</label>
                <input type="number" id="purchase_year" name="purchase_year" min="1900" max="2100"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"
                       placeholder="<?= date('Y') ?>">
            </div>
        </div>

        <div>
            <label for="location" class="block text-xs font-medium text-slate-700 mb-1.5">Lokasi</label>
            <input type="text" id="location" name="location"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"
                   placeholder="Contoh: Ruang Lab A, Ruang Server, dll">
        </div>

        <div>
            <label for="specifications" class="block text-xs font-medium text-slate-700 mb-1.5">Spesifikasi</label>
            <textarea id="specifications" name="specifications" rows="3"
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"
                      placeholder="Spesifikasi teknis peralatan (opsional)"></textarea>
        </div>

        <div>
            <label for="notes" class="block text-xs font-medium text-slate-700 mb-1.5">Catatan</label>
            <textarea id="notes" name="notes" rows="2"
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"
                      placeholder="Catatan tambahan (opsional)"></textarea>
        </div>

        <div class="flex gap-2 pt-3 border-t">
            <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors text-xs">
                Simpan Peralatan
            </button>
            <a href="index.php?page=admin-equip" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg text-xs">
                Batal
            </a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = "Tambah Peralatan";
include __DIR__ . "/../../layouts/admin.php";
?>

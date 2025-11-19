<?php ob_start(); ?>

<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg md:text-xl font-bold text-slate-800">Edit Peralatan</h2>
        <p class="text-xs text-slate-500 mt-0.5">Ubah informasi peralatan</p>
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
    <form method="POST" action="index.php?page=admin-equip&action=edit&id=<?= $equip['id'] ?>" class="space-y-4">
        
        <div>
            <label for="name" class="block text-xs font-medium text-slate-700 mb-1.5">Nama Peralatan *</label>
            <input type="text" id="name" name="name" required
                   value="<?= htmlspecialchars($equip['name']) ?>"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label for="category" class="block text-xs font-medium text-slate-700 mb-1.5">Kategori *</label>
                <select id="category" name="category" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                    <option value="Hardware" <?= $equip['category']=='Hardware'?'selected':'' ?>>Hardware</option>
                    <option value="Software" <?= $equip['category']=='Software'?'selected':'' ?>>Software</option>
                    <option value="Aksesoris" <?= $equip['category']=='Aksesoris'?'selected':'' ?>>Aksesoris</option>
                </select>
            </div>

            <div>
                <label for="brand" class="block text-xs font-medium text-slate-700 mb-1.5">Brand/Merek</label>
                <input type="text" id="brand" name="brand"
                       value="<?= htmlspecialchars($equip['brand'] ?? '') ?>"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-3">
            <div>
                <label for="quantity" class="block text-xs font-medium text-slate-700 mb-1.5">Jumlah *</label>
                <input type="number" id="quantity" name="quantity" min="1" required
                       value="<?= (int)($equip['quantity'] ?? 1) ?>"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
            </div>

            <div>
                <label for="condition" class="block text-xs font-medium text-slate-700 mb-1.5">Kondisi *</label>
                <select id="condition" name="condition" required
                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
                    <option value="baik" <?= $equip['condition']=='baik'?'selected':'' ?>>Baik</option>
                    <option value="rusak" <?= $equip['condition']=='rusak'?'selected':'' ?>>Rusak</option>
                    <option value="maintenance" <?= $equip['condition']=='maintenance'?'selected':'' ?>>Maintenance</option>
                </select>
            </div>

            <div>
                <label for="purchase_year" class="block text-xs font-medium text-slate-700 mb-1.5">Tahun Pembelian</label>
                <input type="number" id="purchase_year" name="purchase_year" min="1900" max="2100"
                       value="<?= htmlspecialchars($equip['purchase_year'] ?? '') ?>"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
            </div>
        </div>

        <div>
            <label for="location" class="block text-xs font-medium text-slate-700 mb-1.5">Lokasi</label>
            <input type="text" id="location" name="location"
                   value="<?= htmlspecialchars($equip['location'] ?? '') ?>"
                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs">
        </div>

        <div>
            <label for="specifications" class="block text-xs font-medium text-slate-700 mb-1.5">Spesifikasi</label>
            <textarea id="specifications" name="specifications" rows="3"
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"><?= htmlspecialchars($equip['specifications'] ?? '') ?></textarea>
        </div>

        <div>
            <label for="notes" class="block text-xs font-medium text-slate-700 mb-1.5">Catatan</label>
            <textarea id="notes" name="notes" rows="2"
                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs"><?= htmlspecialchars($equip['notes'] ?? '') ?></textarea>
        </div>

        <div class="bg-slate-50 rounded-lg p-3 text-xs text-slate-600">
            <div class="grid md:grid-cols-2 gap-2">
                <div>
                    <span class="font-medium">Dibuat:</span>
                    <?= !empty($equip['created_at']) ? date('d M Y H:i', strtotime($equip['created_at'])) : '-' ?>
                </div>
                <?php if (!empty($equip['updated_at'])): ?>
                <div>
                    <span class="font-medium">Diupdate:</span>
                    <?= date('d M Y H:i', strtotime($equip['updated_at'])) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex gap-2 pt-3 border-t">
            <button type="submit" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors text-xs">
                Update Peralatan
            </button>
            <a href="index.php?page=admin-equip" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg text-xs">
                Batal
            </a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
$title = "Edit Peralatan";
include __DIR__ . "/../../layouts/admin.php";
?>

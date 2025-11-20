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

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
    <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Total Item</p>
                <h3 class="text-xl font-bold text-slate-800"><?= count($allEquipment ?? []) ?></h3>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Hardware</p>
                <h3 class="text-xl font-bold text-blue-600"><?= count(array_filter($allEquipment ?? [], fn($e) => $e['category'] === 'Hardware')) ?></h3>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Software</p>
                <h3 class="text-xl font-bold text-purple-600"><?= count(array_filter($allEquipment ?? [], fn($e) => $e['category'] === 'Software')) ?></h3>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Kondisi Baik</p>
                <h3 class="text-xl font-bold text-green-600"><?= count(array_filter($allEquipment ?? [], fn($e) => $e['condition'] === 'baik')) ?></h3>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs & Actions -->
<div class="mb-4 flex flex-wrap items-center justify-between gap-2">
    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-1.5">
        <a href="?page=admin-equip&filter=all" 
           class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
            Semua (<?= count($allEquipment ?? []) ?>)
        </a>
        <a href="?page=admin-equip&filter=Hardware" 
           class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'Hardware') ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
            Hardware (<?= count(array_filter($allEquipment ?? [], fn($e) => $e['category'] === 'Hardware')) ?>)
        </a>
        <a href="?page=admin-equip&filter=Software" 
           class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'Software') ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
            Software (<?= count(array_filter($allEquipment ?? [], fn($e) => $e['category'] === 'Software')) ?>)
        </a>
        <a href="?page=admin-equip&filter=Aksesoris" 
           class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'Aksesoris') ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
            Aksesoris (<?= count(array_filter($allEquipment ?? [], fn($e) => $e['category'] === 'Aksesoris')) ?>)
        </a>
    </div>
    
    <!-- Add Button -->
    <a href="index.php?page=admin-equip&action=create" 
       class="inline-flex items-center px-3 py-1.5 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Peralatan
    </a>
</div>

<!-- Equipment Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <?php if (empty($equipmentList)): ?>
            <!-- Empty State -->
            <div class="p-8 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                <h3 class="text-sm font-medium text-slate-700 mb-1">Belum ada peralatan</h3>
                <p class="text-xs text-slate-500 mb-3">Mulai tambahkan peralatan lab Anda</p>
                <a href="?page=admin-equip&action=create" class="inline-flex items-center px-3 py-1.5 bg-blue-700 text-white text-xs font-medium rounded-lg hover:bg-blue-800 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Peralatan
                </a>
            </div>
        <?php else: ?>
            <!-- Table -->
            <table class="w-full text-xs">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">#</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">Nama</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden md:table-cell">Kategori</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden lg:table-cell">Brand</th>
                        <th class="text-center px-3 py-2 font-medium text-slate-600 text-xs hidden sm:table-cell">Qty</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden xl:table-cell">Kondisi</th>
                        <th class="text-center px-3 py-2 font-medium text-slate-600 text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($equipmentList as $index => $equip): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-2.5 text-slate-500 text-xs"><?= $index + 1 ?></td>
                        <td class="px-3 py-2.5">
                            <div>
                                <p class="font-medium text-slate-800 text-xs"><?= htmlspecialchars($equip['name']) ?></p>
                                <p class="text-xs text-slate-500 mt-0.5"><?= htmlspecialchars($equip['location'] ?? '-') ?></p>
                            </div>
                        </td>
                        <td class="px-3 py-2.5 hidden md:table-cell">
                            <?php 
                            $categoryColor = [
                                'Hardware' => 'bg-blue-100 text-blue-700',
                                'Software' => 'bg-purple-100 text-purple-700',
                                'Aksesoris' => 'bg-green-100 text-green-700'
                            ];
                            $color = $categoryColor[$equip['category']] ?? 'bg-slate-100 text-slate-700';
                            ?>
                            <span class="inline-block px-2 py-0.5 <?= $color ?> text-xs font-medium rounded-full">
                                <?= htmlspecialchars($equip['category']) ?>
                            </span>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 text-xs hidden lg:table-cell">
                            <?= htmlspecialchars($equip['brand'] ?? '-') ?>
                        </td>
                        <td class="px-3 py-2.5 text-center text-slate-800 font-medium text-xs hidden sm:table-cell">
                            <?= $equip['quantity'] ?>
                        </td>
                        <td class="px-3 py-2.5 hidden xl:table-cell">
                            <?php if ($equip['condition'] === 'baik'): ?>
                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Baik</span>
                            <?php elseif ($equip['condition'] === 'rusak'): ?>
                                <span class="inline-block px-2 py-0.5 bg-red-100 text-red-700 text-xs font-medium rounded-full">Rusak</span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">Maintenance</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="?page=admin-equip&action=edit&id=<?= $equip['id'] ?>" 
                                   class="px-2 py-1 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded transition-colors">
                                    Edit
                                </a>
                                <a href="?page=admin-equip&action=delete&id=<?= $equip['id'] ?>" 
                                   onclick="return confirm('Hapus peralatan ini?')"
                                   class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition-colors">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Peralatan Lab";
include __DIR__ . "/../../layouts/admin.php";
?>
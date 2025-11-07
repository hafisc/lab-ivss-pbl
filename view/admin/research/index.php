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

<!-- Search & Action Bar -->
<div class="mb-3 flex flex-col sm:flex-row gap-2">
    <!-- Search Bar -->
    <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input type="text" id="searchInput" 
               class="w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-xs"
               placeholder="Cari riset berdasarkan judul atau deskripsi...">
    </div>
    
    <!-- Add Button -->
    <a href="index.php?page=admin-research&action=create" 
       class="inline-flex items-center justify-center px-3 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Riset
    </a>
</div>

<!-- Filter Tabs -->
<div class="mb-4 flex flex-wrap gap-1.5">
    <a href="?page=admin-research&filter=all" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'bg-blue-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Semua (<?= count($allResearch ?? []) ?>)
    </a>
    <a href="?page=admin-research&filter=active" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'active') ? 'bg-blue-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Active (<?= count(array_filter($allResearch ?? [], fn($r) => $r['status'] === 'active')) ?>)
    </a>
    <a href="?page=admin-research&filter=completed" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'completed') ? 'bg-blue-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Completed (<?= count(array_filter($allResearch ?? [], fn($r) => $r['status'] === 'completed')) ?>)
    </a>
</div>

<!-- Research Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <?php if (empty($researchList)): ?>
            <!-- Empty State -->
            <div class="p-8 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-sm font-medium text-slate-700 mb-1">Belum ada riset</h3>
                <p class="text-xs text-slate-500 mb-3">Mulai tambahkan riset pertama Anda</p>
                <a href="index.php?page=admin-research&action=create" class="inline-flex items-center px-3 py-1.5 bg-blue-900 text-white text-xs font-medium rounded-lg hover:bg-blue-800 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Riset
                </a>
            </div>
        <?php else: ?>
            <!-- Table -->
            <table class="w-full text-xs">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">#</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">Riset</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden lg:table-cell">Kategori</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden md:table-cell">Status</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden xl:table-cell">Funding</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden sm:table-cell">Tanggal</th>
                        <th class="text-center px-3 py-2 font-medium text-slate-600 text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($researchList as $index => $research): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-2.5 text-slate-500 text-xs"><?= $index + 1 ?></td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center gap-2">
                                <!-- Image Thumbnail -->
                                <div class="flex-shrink-0 w-12 h-12 rounded-lg overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600">
                                    <?php if (!empty($research['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($research['image_url']) ?>" 
                                             alt="<?= htmlspecialchars($research['title']) ?>"
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Title & Description -->
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-slate-800 truncate text-xs"><?= htmlspecialchars($research['title']) ?></p>
                                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-1"><?= htmlspecialchars(substr($research['description'], 0, 60) . '...') ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-2.5 hidden lg:table-cell">
                            <?php if ($research['category'] === 'Riset Utama'): ?>
                                <span class="inline-block px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Riset Utama</span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Riset Lainnya</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5 hidden md:table-cell">
                            <?php if ($research['status'] === 'active'): ?>
                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
                            <?php elseif ($research['status'] === 'completed'): ?>
                                <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-full">Completed</span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">On-Hold</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 hidden xl:table-cell text-xs">
                            <?= !empty($research['funding']) ? htmlspecialchars($research['funding']) : '-' ?>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 hidden sm:table-cell text-xs">
                            <?= !empty($research['start_date']) ? date('d M Y', strtotime($research['start_date'])) : '-' ?>
                        </td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="?page=admin-research&action=edit&id=<?= $research['id'] ?>" 
                                   class="px-2 py-1 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded transition-colors">
                                    Edit
                                </a>
                                <a href="?page=admin-research&action=delete&id=<?= $research['id'] ?>" 
                                   onclick="return confirm('Hapus riset ini?')"
                                   class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded transition-colors">
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

<!-- Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('tbody');
    
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const titleElement = row.querySelector('td:nth-child(2) .font-semibold');
                const descElement = row.querySelector('td:nth-child(2) .text-xs');
                
                if (titleElement && descElement) {
                    const title = titleElement.textContent.toLowerCase();
                    const desc = descElement.textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
            
            // Show "no results" message if needed
            const existingNoResults = document.getElementById('noResultsMessage');
            if (existingNoResults) {
                existingNoResults.remove();
            }
            
            if (visibleCount === 0 && searchTerm !== '') {
                const noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsMessage';
                noResultsRow.innerHTML = `
                    <td colspan="7" class="px-4 py-12 text-center">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-slate-600 font-medium mb-1">Tidak ada hasil</p>
                        <p class="text-sm text-slate-500">Tidak ditemukan riset dengan kata kunci "${searchTerm}"</p>
                    </td>
                `;
                tableBody.appendChild(noResultsRow);
            }
        });
        
        // Clear search on escape key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        });
    }
});
</script>

<?php
$content = ob_get_clean();
$title = "Kelola Riset";
include __DIR__ . "/../../layouts/admin.php";
?>

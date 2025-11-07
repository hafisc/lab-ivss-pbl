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
               placeholder="Cari berita berdasarkan judul atau konten...">
    </div>
    
    <!-- Add Button -->
    <a href="index.php?page=admin-news&action=create" 
       class="inline-flex items-center justify-center px-3 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Berita
    </a>
</div>

<!-- Filter Tabs -->
<div class="mb-4 flex flex-wrap gap-1.5">
    <a href="?page=admin-news&filter=all" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'bg-blue-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Semua (<?= count($allNews ?? []) ?>)
    </a>
    <a href="?page=admin-news&filter=published" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'published') ? 'bg-blue-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Published (<?= count(array_filter($allNews ?? [], fn($n) => $n['status'] === 'published')) ?>)
    </a>
    <a href="?page=admin-news&filter=draft" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'draft') ? 'bg-blue-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Draft (<?= count(array_filter($allNews ?? [], fn($n) => $n['status'] === 'draft')) ?>)
    </a>
</div>

<!-- News Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <?php if (empty($newsList)): ?>
            <!-- Empty State -->
            <div class="p-8 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="text-sm font-medium text-slate-700 mb-1">Belum ada berita</h3>
                <p class="text-xs text-slate-500 mb-3">Mulai tambahkan berita pertama Anda</p>
                <a href="index.php?page=admin-news&action=create" class="inline-flex items-center px-3 py-1.5 bg-blue-900 text-white text-xs font-medium rounded-lg hover:bg-blue-800 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Berita
                </a>
            </div>
        <?php else: ?>
            <!-- Table -->
            <table class="w-full text-xs">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">#</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">Berita</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden lg:table-cell">Kategori</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden md:table-cell">Status</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden xl:table-cell">Views</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden sm:table-cell">Tanggal</th>
                        <th class="text-center px-3 py-2 font-medium text-slate-600 text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($newsList as $index => $news): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-2.5 text-slate-500 text-xs"><?= $index + 1 ?></td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center gap-2">
                                <!-- Image Thumbnail -->
                                <div class="flex-shrink-0 w-12 h-12 rounded-lg overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600">
                                    <?php if (!empty($news['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($news['image_url']) ?>" 
                                             alt="<?= htmlspecialchars($news['title']) ?>"
                                             class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Title & Excerpt -->
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-slate-800 truncate text-xs"><?= htmlspecialchars($news['title']) ?></p>
                                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-1"><?= htmlspecialchars($news['excerpt'] ?? substr($news['content'], 0, 60) . '...') ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-2.5 hidden lg:table-cell">
                            <?php if (!empty($news['category'])): ?>
                                <span class="inline-block px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                    <?= htmlspecialchars($news['category']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-slate-400 text-xs">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5 hidden md:table-cell">
                            <?php if ($news['status'] === 'published'): ?>
                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Published</span>
                            <?php elseif ($news['status'] === 'draft'): ?>
                                <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-full">Draft</span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-0.5 bg-red-100 text-red-700 text-xs font-medium rounded-full">Archived</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 hidden xl:table-cell">
                            <div class="flex items-center gap-1 text-xs">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <?= number_format($news['views'] ?? 0) ?>
                            </div>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 hidden sm:table-cell text-xs">
                            <?= date('d M Y', strtotime($news['created_at'])) ?>
                        </td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="?page=admin-news&action=edit&id=<?= $news['id'] ?>" 
                                   class="px-2 py-1 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded transition-colors">
                                    Edit
                                </a>
                                <a href="?page=admin-news&action=delete&id=<?= $news['id'] ?>" 
                                   onclick="return confirm('Hapus berita ini?')"
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
                const excerptElement = row.querySelector('td:nth-child(2) .text-xs');
                
                if (titleElement && excerptElement) {
                    const title = titleElement.textContent.toLowerCase();
                    const excerpt = excerptElement.textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
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
                        <p class="text-sm text-slate-500">Tidak ditemukan berita dengan kata kunci "${searchTerm}"</p>
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
$title = "Kelola Berita";
include __DIR__ . "/../../layouts/admin.php";
?>

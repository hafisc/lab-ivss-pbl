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

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
    <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Total Member</p>
                <h3 class="text-xl font-bold text-slate-800"><?= count($allMembers ?? []) ?></h3>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Member Aktif</p>
                <h3 class="text-xl font-bold text-green-600"><?= count(array_filter($allMembers ?? [], fn($m) => $m['status'] === 'active')) ?></h3>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-slate-200 rounded-xl p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Alumni</p>
                <h3 class="text-xl font-bold text-slate-600"><?= count(array_filter($allMembers ?? [], fn($m) => $m['status'] === 'inactive')) ?></h3>
            </div>
            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

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
               placeholder="Cari member berdasarkan nama atau email...">
    </div>
    
    <!-- Add Button -->
    <a href="index.php?page=admin-members&action=create" 
       class="inline-flex items-center justify-center px-3 py-2 bg-blue-900 hover:bg-blue-800 text-white text-xs font-medium rounded-lg transition-colors whitespace-nowrap">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Member
    </a>
</div>

<!-- Filter Tabs -->
<div class="mb-4 flex flex-wrap gap-1.5">
    <a href="?page=admin-members&filter=all" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Semua (<?= count($allMembers ?? []) ?>)
    </a>
    <a href="?page=admin-members&filter=active" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'active') ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Aktif (<?= count(array_filter($allMembers ?? [], fn($m) => $m['status'] === 'active')) ?>)
    </a>
    <a href="?page=admin-members&filter=inactive" 
       class="px-3 py-1.5 rounded-lg text-xs font-medium <?= (isset($_GET['filter']) && $_GET['filter'] === 'inactive') ? 'bg-blue-700 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' ?> border border-slate-200 transition-colors">
        Alumni (<?= count(array_filter($allMembers ?? [], fn($m) => $m['status'] === 'inactive')) ?>)
    </a>
</div>

<!-- Members Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <?php if (empty($membersList)): ?>
            <!-- Empty State -->
            <div class="p-8 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-sm font-medium text-slate-700 mb-1">Belum ada member</h3>
                <p class="text-xs text-slate-500">Member akan muncul di sini setelah diapprove</p>
            </div>
        <?php else: ?>
            <!-- Table -->
            <table class="w-full text-xs">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">#</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">Nama</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden md:table-cell">Email</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden lg:table-cell">NIM</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden sm:table-cell">Status</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden xl:table-cell">Bergabung</th>
                        <th class="text-center px-3 py-2 font-medium text-slate-600 text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($membersList as $index => $member): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-2.5 text-slate-500 text-xs"><?= $index + 1 ?></td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-semibold text-blue-700">
                                        <?= strtoupper(substr($member['name'], 0, 1)) ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 text-xs"><?= htmlspecialchars($member['name']) ?></p>
                                    <p class="text-xs text-slate-500 md:hidden"><?= htmlspecialchars($member['email']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 text-xs hidden md:table-cell">
                            <?= htmlspecialchars($member['email']) ?>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 text-xs hidden lg:table-cell">
                            <?= htmlspecialchars($member['nim'] ?? '-') ?>
                        </td>
                        <td class="px-3 py-2.5 hidden sm:table-cell">
                            <?php if ($member['status'] === 'active'): ?>
                                <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Aktif</span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-full">Alumni</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 text-xs hidden xl:table-cell">
                            <?= date('d M Y', strtotime($member['created_at'])) ?>
                        </td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center justify-center gap-1">
                                <!-- Lihat Detail -->
                                <a href="?page=admin-members&action=view&id=<?= $member['id'] ?>" 
                                   class="inline-flex items-center justify-center w-7 h-7 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded transition-colors"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                
                                <!-- Toggle Status (Alumni/Aktif) -->
                                <?php if ($member['status'] === 'active'): ?>
                                    <a href="?page=admin-members&action=set-alumni&id=<?= $member['id'] ?>" 
                                       onclick="return confirm('Jadikan alumni?')"
                                       class="inline-flex items-center justify-center w-7 h-7 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded transition-colors"
                                       title="Jadikan Alumni">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    <a href="?page=admin-members&action=set-active&id=<?= $member['id'] ?>" 
                                       onclick="return confirm('Aktifkan kembali?')"
                                       class="inline-flex items-center justify-center w-7 h-7 bg-green-100 hover:bg-green-200 text-green-700 rounded transition-colors"
                                       title="Aktifkan Kembali">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Delete -->
                                <a href="?page=admin-members&action=delete&id=<?= $member['id'] ?>" 
                                   onclick="return confirm('Hapus member ini? Data tidak bisa dikembalikan!')"
                                   class="inline-flex items-center justify-center w-7 h-7 bg-red-100 hover:bg-red-200 text-red-700 rounded transition-colors"
                                   title="Hapus Member">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
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
                const nameElement = row.querySelector('td:nth-child(2) .font-medium');
                const emailElement = row.querySelector('td:nth-child(3)');
                
                if (nameElement) {
                    const name = nameElement.textContent.toLowerCase();
                    const email = emailElement ? emailElement.textContent.toLowerCase() : '';
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
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
                        <p class="text-sm text-slate-500">Tidak ditemukan member dengan kata kunci "${searchTerm}"</p>
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
$title = "Member & Alumni";
include __DIR__ . "/../../layouts/admin.php";
?>

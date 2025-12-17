<?php
/**
 * View Daftar Member & Alumni
 * 
 * Halaman ini menampilkan daftar seluruh member yang sudah aktif dan alumni.
 * Fitur: Pencarian, Filter (Aktif/Alumni), dan Aksi (Detail, Nonaktifkan, Hapus).
 * 
 * @package View
 * @subpackage Admin/Members
 */

ob_start(); 

// Data Statistik Sederhana untuk Header
$countAll = count($allMembers ?? []);
$countActive = count(array_filter($allMembers ?? [], fn($m) => $m['status'] === 'active'));
$countAlumni = count(array_filter($allMembers ?? [], fn($m) => $m['status'] === 'inactive'));
?>

<!-- Notifikasi Alert -->
<?php if (isset($_SESSION['success'])): ?>
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm animate-fade-in-down">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <p class="text-sm font-medium"><?= $_SESSION['success'] ?></p>
</div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center shadow-sm animate-fade-in-down">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <p class="text-sm font-medium"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); endif; ?>

<!-- Section: Statistik Ringkas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Card Total -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div>
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Total Database</p>
                <h3 class="text-2xl font-bold text-slate-800"><?= $countAll ?></h3>
            </div>
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>
    
    <!-- Card Active -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div>
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Member Aktif</p>
                <h3 class="text-2xl font-bold text-emerald-600"><?= $countActive ?></h3>
            </div>
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
    
    <!-- Card Alumni -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-1 bg-slate-500"></div>
        <div class="flex items-center justify-between relative z-10">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider mb-1">Alumni</p>
                <h3 class="text-2xl font-bold text-slate-700"><?= $countAlumni ?></h3>
            </div>
            <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center group-hover:bg-slate-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar: Pencarian & Tombol Aksi -->
<div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
    <!-- Search Bar -->
    <div class="relative w-full sm:max-w-md group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" id="searchInput" 
               class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-sm"
               placeholder="Cari nama, email, atau NIM...">
    </div>
    
    <!-- Tombol Tambah Member (Optional, jika admin butuh input manual) -->
    <a href="index.php?page=admin-members&action=create" 
       class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm hover:shadow-md">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Member
    </a>
</div>

<!-- Tabs Filter Status -->
<div class="flex border-b border-slate-200 mb-6 overflow-x-auto">
    <a href="?page=admin-members&filter=all" 
       class="px-4 py-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap <?= (!isset($_GET['filter']) || $_GET['filter'] === 'all') ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' ?>">
        Semua Member
    </a>
    <a href="?page=admin-members&filter=active" 
       class="px-4 py-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap <?= (isset($_GET['filter']) && $_GET['filter'] === 'active') ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' ?>">
        Aktif
    </a>
    <a href="?page=admin-members&filter=inactive" 
       class="px-4 py-2 text-sm font-medium border-b-2 transition-colors whitespace-nowrap <?= (isset($_GET['filter']) && $_GET['filter'] === 'inactive') ? 'border-slate-500 text-slate-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' ?>">
        Alumni
    </a>
</div>

<!-- Tabel Data Member -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <?php if (empty($membersList)): ?>
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <div class="bg-slate-50 rounded-full p-4 mb-4">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800 mb-1">Data Member Kosong</h3>
                <p class="text-sm text-slate-500 max-w-sm">Belum ada data member yang sesuai dengan filter ini.</p>
            </div>
        <?php else: ?>
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase tracking-wider text-xs">
                    <tr>
                        <th class="px-6 py-3 w-16 text-center">#</th>
                        <th class="px-6 py-3">Informasi Member</th>
                        <th class="px-6 py-3 hidden md:table-cell">Kontak</th>
                        <th class="px-6 py-3 hidden lg:table-cell">Status</th>
                        <th class="px-6 py-3 hidden xl:table-cell">Bergabung</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($membersList as $index => $member): ?>
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <!-- Nomor Urut -->
                        <td class="px-6 py-4 text-center text-slate-500 text-xs">
                            <?= $index + 1 ?>
                        </td>
                        
                        <!-- Info Utama -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 text-white flex items-center justify-center font-bold text-sm shadow-md">
                                    <?= strtoupper(substr($member['name'], 0, 1)) ?>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-slate-800 truncate"><?= htmlspecialchars($member['name']) ?></h4>
                                    <p class="text-xs text-slate-500 font-mono"><?= htmlspecialchars($member['nim'] ?? 'NIM tidak ada') ?></p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Email (Hidden Mobile) -->
                        <td class="px-6 py-4 hidden md:table-cell">
                            <div class="flex items-center text-slate-600 text-sm">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <?= htmlspecialchars($member['email']) ?>
                            </div>
                        </td>
                        
                        <!-- Status Badge -->
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <?php if ($member['status'] === 'active'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                                    Aktif
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    Alumni
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Tanggal -->
                        <td class="px-6 py-4 hidden xl:table-cell text-slate-500 text-xs">
                            <?= date('d M Y', strtotime($member['created_at'])) ?>
                        </td>
                        
                        <!-- Aksi Button -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                <!-- Detail -->
                                <a href="?page=admin-members&action=view&id=<?= $member['id'] ?>" 
                                   class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all shadow-sm"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>

                                <!-- Toggle Status -->
                                <?php if ($member['status'] === 'active'): ?>
                                    <a href="?page=admin-members&action=set-alumni&id=<?= $member['id'] ?>" 
                                       onclick="return confirm('Apakah Anda yakin ingin mengubah status member ini menjadi Alumni?')"
                                       class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg transition-all shadow-sm"
                                       title="Set Alumni">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                    </a>
                                <?php else: ?>
                                    <a href="?page=admin-members&action=set-active&id=<?= $member['id'] ?>" 
                                       onclick="return confirm('Aktifkan kembali member ini?')"
                                       class="p-2 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white rounded-lg transition-all shadow-sm"
                                       title="Set Aktif">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    </a>
                                <?php endif; ?>

                                <!-- Hapus -->
                                <a href="?page=admin-members&action=delete&id=<?= $member['id'] ?>" 
                                   onclick="return confirm('PERINGATAN: Hapus member secara permanen? Data tidak dapat dikembalikan!')"
                                   class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-all shadow-sm"
                                   title="Hapus Permanen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <!-- Bagian Footer Tabel (Pagination Placeholder) -->
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex items-center justify-between">
        <p class="text-xs text-slate-500">
            Menampilkan <span class="font-bold"><?= count($membersList ?? []) ?></span> data
        </p>
    </div>
</div>

<!-- Script Pencarian Realtime Client-side -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            
            tableRows.forEach(row => {
                const name = row.querySelector('h4') ? row.querySelector('h4').textContent.toLowerCase() : '';
                const email = row.querySelector('td:nth-child(3)') ? row.querySelector('td:nth-child(3)').textContent.toLowerCase() : '';
                
                if (name.includes(term) || email.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>

<?php
$content = ob_get_clean();
$title = "Manajemen Member";
include __DIR__ . "/../../layouts/admin.php";
?>

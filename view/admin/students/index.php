<?php 
ob_start(); 

// Get user role
$userRole = $_SESSION['user']['role'] ?? 'member';
$userId = $_SESSION['user']['id'] ?? 0;
?>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Mahasiswa Bimbingan</h2>
            <p class="text-sm text-slate-500 mt-1">Daftar mahasiswa yang Anda bimbing di Lab IVSS</p>
        </div>
        <div class="flex gap-2">
            <button onclick="exportData()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <!-- Total Mahasiswa -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90 mb-1">Total Mahasiswa</p>
                <p class="text-3xl font-bold">12</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Aktif Riset -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90 mb-1">Aktif Riset</p>
                <p class="text-3xl font-bold">8</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Angkatan 2024 -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90 mb-1">Angkatan 2024</p>
                <p class="text-3xl font-bold">5</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Alumni -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90 mb-1">Alumni</p>
                <p class="text-3xl font-bold">4</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="mb-4 bg-white border border-slate-200 rounded-xl p-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <!-- Search -->
        <div class="md:col-span-2">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Cari mahasiswa..." 
                       class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Filter Angkatan -->
        <div>
            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Angkatan</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
            </select>
        </div>
        
        <!-- Filter Status -->
        <div>
            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Alumni</option>
            </select>
        </div>
    </div>
</div>

<!-- Students Table -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Mahasiswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Angkatan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Topik Riset</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Kontak</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                
                <?php
                // $students sudah dikirim dari controller
                
                foreach ($students as $student):
                    // Normalisasi data
                    $studentName = $student['display_name'] ?? $student['nama'] ?? $student['username'] ?? '-';
                    $studentPhone = $student['phone'] ?? '-';
                    $studentTitle = $student['research_title'] ?? '-';
                    $studentStatus = $student['status'] ?? 'active';

                    $statusBadge = $studentStatus === 'active' 
                        ? '<span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Aktif</span>'
                        : '<span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-full">Alumni/Inactive</span>';
                ?>
                
                <tr class="hover:bg-slate-50 transition-colors">
                    <!-- Mahasiswa -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold text-white">
                                    <?= strtoupper(substr($studentName, 0, 1)) ?>
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($studentName) ?></p>
                                <p class="text-xs text-slate-500"><?= htmlspecialchars($student['email']) ?></p>
                            </div>
                        </div>
                    </td>
                    
                    <!-- NIM -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($student['nim'] ?? '-') ?></p>
                    </td>
                    
                    <!-- Angkatan -->
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                            <?= htmlspecialchars($student['angkatan'] ?? '-') ?>
                        </span>
                    </td>
                    
                    <!-- Topik Riset -->
                    <td class="px-6 py-4">
                        <p class="text-sm text-slate-700 max-w-xs truncate" title="<?= htmlspecialchars($studentTitle) ?>">
                            <?= htmlspecialchars($studentTitle) ?>
                        </p>
                    </td>
                    
                    <!-- Status -->
                    <td class="px-6 py-4">
                        <?= $statusBadge ?>
                    </td>
                    
                    <!-- Kontak -->
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="mailto:<?= htmlspecialchars($student['email']) ?>" 
                               class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" 
                               title="Email">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </a>
                            <a href="https://wa.me/<?= htmlspecialchars($studentPhone) ?>" 
                               target="_blank"
                               class="p-1.5 text-green-600 hover:bg-green-50 rounded transition-colors" 
                               title="WhatsApp">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                    
                    <!-- Aksi -->
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <button onclick="viewDetail(<?= $student['id'] ?>)" 
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                    title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button onclick="addNote(<?= $student['id'] ?>)" 
                                    class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" 
                                    title="Tambah Catatan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
</div>

<!-- Empty State -->
<?php if (empty($students)): ?>
<div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
    </svg>
    <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Mahasiswa Bimbingan</h3>
    <p class="text-sm text-slate-500">Mahasiswa yang memilih Anda sebagai pembimbing akan muncul di sini</p>
</div>
<?php endif; ?>

<script>
function viewDetail(id) {
    alert('Lihat detail mahasiswa ID: ' + id);
}

function addNote(id) {
    alert('Tambah catatan untuk mahasiswa ID: ' + id);
}

function exportData() {
    alert('Export data mahasiswa akan segera tersedia');
}

// Search functionality
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    console.log('Search:', e.target.value);
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>

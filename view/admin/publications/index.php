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
            <h2 class="text-2xl font-bold text-slate-800">Publikasi Dosen</h2>
            <p class="text-sm text-slate-500 mt-1">Kelola publikasi ilmiah dan jurnal penelitian</p>
        </div>
        <button onclick="showAddModal()" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Publikasi
        </button>
    </div>
</div>

<!-- Alert Messages -->
<?php if (isset($_SESSION['success'])): ?>
<div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
    <p class="text-sm text-green-700"><?= $_SESSION['success'] ?></p>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
    <p class="text-sm text-red-700"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Filters -->
<div class="mb-4 bg-white border border-slate-200 rounded-xl p-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <!-- Search -->
        <div class="md:col-span-2">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Cari publikasi..." 
                       class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Filter Tahun -->
        <div>
            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Tahun</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
            </select>
        </div>
        
        <!-- Filter Jenis -->
        <div>
            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Jenis</option>
                <option value="jurnal">Jurnal</option>
                <option value="konferensi">Konferensi</option>
                <option value="buku">Buku</option>
                <option value="prosiding">Prosiding</option>
            </select>
        </div>
    </div>
</div>

<!-- Publications Grid -->
<div class="grid grid-cols-1 gap-4">
    
    <?php
    // $publications sudah dikirim dari controller
    
    foreach ($publications as $pub):
        $typeColors = [
            'journal' => 'bg-blue-100 text-blue-700',
            'conference' => 'bg-purple-100 text-purple-700',
            'book' => 'bg-green-100 text-green-700',
            'prosiding' => 'bg-orange-100 text-orange-700'
        ];
        // Normalize type key
        $pubType = strtolower($pub['type'] ?? 'journal');
        $typeColor = $typeColors[$pubType] ?? 'bg-slate-100 text-slate-700';
        
        // Determine publisher
        $publisher = $pub['journal'] ?: ($pub['conference'] ?: '-');
    ?>
    
    <div class="bg-white border border-slate-200 rounded-xl p-5 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <!-- Title -->
                <h3 class="text-base font-bold text-slate-800 mb-2 hover:text-blue-600 cursor-pointer">
                    <?= htmlspecialchars($pub['title']) ?>
                </h3>
                
                <!-- Authors -->
                <p class="text-sm text-slate-600 mb-3">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <?= htmlspecialchars($pub['authors']) ?>
                </p>
                
                <!-- Publisher & Year -->
                <p class="text-sm text-slate-500 mb-3">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <?= htmlspecialchars($pub['publisher']) ?> • <?= $pub['year'] ?>
                </p>
                
                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="<?= $typeColor ?> px-2.5 py-1 text-xs font-semibold rounded-full">
                        <?= $pub['type'] ?>
                    </span>
                    <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 text-xs font-semibold rounded-full">
                        <?= $pub['indexed'] ?>
                    </span>
                    <span class="bg-slate-100 text-slate-600 px-2.5 py-1 text-xs font-medium rounded-full">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        <?= $pub['citation_count'] ?> Sitasi
                    </span>
                </div>
                
                <!-- DOI -->
                <p class="text-xs text-slate-500">
                    <strong>DOI:</strong> 
                    <a href="https://doi.org/<?= htmlspecialchars($pub['doi']) ?>" target="_blank" class="text-blue-600 hover:underline">
                        <?= htmlspecialchars($pub['doi']) ?>
                    </a>
                </p>
            </div>
            
            <!-- Actions -->
            <div class="flex flex-col gap-2">
                <button onclick="editPublication(<?= $pub['id'] ?>)" 
                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                        title="Edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </button>
                <button onclick="deletePublication(<?= $pub['id'] ?>)" 
                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                        title="Hapus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <?php endforeach; ?>
    
</div>

<!-- Empty State -->
<?php if (empty($publications)): ?>
<div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
    </svg>
    <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Publikasi</h3>
    <p class="text-sm text-slate-500 mb-4">Mulai tambahkan publikasi ilmiah Anda</p>
    <button onclick="showAddModal()" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors">
        Tambah Publikasi
    </button>
</div>
<?php endif; ?>

<script>
function showAddModal() {
    alert('Fitur tambah publikasi akan segera tersedia');
}

function editPublication(id) {
    alert('Edit publikasi ID: ' + id);
}

function deletePublication(id) {
    if (confirm('Hapus publikasi ini?')) {
        alert('Hapus publikasi ID: ' + id);
    }
}

// Search functionality
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    // Implementasi search
    console.log('Search:', e.target.value);
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>

<?php 
/**
 * View Publikasi Saya
 * 
 * Halaman untuk mengelola publikasi member (paper, jurnal, artikel).
 * Menampilkan daftar publikasi dengan filter status dan modal untuk tambah/edit.
 * 
 * @package View
 * @subpackage Member/Publications
 */

ob_start();

// Simulasi Data Publikasi (TODO: Ganti dengan data database)
$publications = [
    [
        'id' => 1,
        'title' => 'Implementasi Deep Learning untuk Deteksi Hama Padi',
        'journal' => 'Jurnal Teknologi Informasi dan Ilmu Komputer (JTIIK)',
        'year' => 2024,
        'status' => 'published', // draft, published
        'link' => 'https://jtiik.ub.ac.id/index.php/jtiik/article/view/1234'
    ],
    [
        'id' => 2,
        'title' => 'Analisis Kinerja Jaringan LoRaWAN pada Smart Farming',
        'journal' => 'Draft Penelitian',
        'year' => 2024,
        'status' => 'draft',
        'link' => '#'
    ]
];
?>

<!-- Header Halaman -->
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Publikasi Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar karya ilmiah dan publikasi yang telah dibuat</p>
        </div>
        <button onclick="openPublicationModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Publikasi
        </button>
    </div>
</div>

<!-- Statistik Ringkas -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <!-- Stat: Total -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500 font-medium uppercase">Total Publikasi</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= count($publications) ?></h3>
        </div>
        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
    </div>
    
    <!-- Stat: Published -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500 font-medium uppercase">Terpublikasi</p>
            <h3 class="text-2xl font-bold text-green-600 mt-1">
                <?= count(array_filter($publications, fn($p) => $p['status'] === 'published')) ?>
            </h3>
        </div>
        <div class="w-10 h-10 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
    
    <!-- Stat: Draft -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-500 font-medium uppercase">Draft</p>
            <h3 class="text-2xl font-bold text-amber-600 mt-1">
                <?= count(array_filter($publications, fn($p) => $p['status'] === 'draft')) ?>
            </h3>
        </div>
        <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Daftar Publikasi -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <!-- Filter Tabs (Opsional) -->
    <div class="border-b border-slate-200 px-4 flex gap-4">
        <button class="py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600">Semua</button>
        <button class="py-3 text-sm font-medium text-slate-500 hover:text-slate-700">Published</button>
        <button class="py-3 text-sm font-medium text-slate-500 hover:text-slate-700">Draft</button>
    </div>

    <!-- List Items -->
    <div class="divide-y divide-slate-100">
        <?php if (empty($publications)): ?>
            <div class="p-8 text-center text-slate-500">
                Belum ada publikasi yang ditambahkan.
            </div>
        <?php else: ?>
            <?php foreach ($publications as $pub): ?>
            <div class="p-4 hover:bg-slate-50 transition-colors group">
                <div class="flex items-start justify-between gap-4">
                    <!-- Icon Type -->
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-1">
                            <h3 class="text-base font-semibold text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-2">
                                <?= htmlspecialchars($pub['title']) ?>
                            </h3>
                            <!-- Badge Status -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ml-2 
                                <?= $pub['status'] == 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-800' ?>">
                                <?= ucfirst($pub['status']) ?>
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mb-1"><?= htmlspecialchars($pub['journal']) ?> • <?= $pub['year'] ?></p>
                        
                        <div class="flex items-center gap-3 mt-2">
                            <?php if ($pub['link'] && $pub['link'] != '#'): ?>
                            <a href="<?= htmlspecialchars($pub['link']) ?>" target="_blank" class="text-xs flex items-center gap-1 text-blue-600 hover:underline">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Link Publikasi
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Actions Dropdown (Bisa diganti button biasa) -->
                    <div class="flex items-center gap-2">
                        <button onclick="editPublication(<?= $pub['id'] ?>)" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah/Edit Publikasi -->
<div id="publicationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Tambah Publikasi</h3>
            <button onclick="closePublicationModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form action="" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Judul Publikasi</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Jurnal / Konferensi</label>
                <input type="text" name="journal" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                     <label class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                     <input type="number" name="year" value="<?= date('Y') ?>" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                     <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                     <select name="status" class="w-full px-4 py-2 border rounded-lg">
                         <option value="draft">Draft</option>
                         <option value="published">Published</option>
                     </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Link (Opsional)</label>
                <input type="url" name="link" class="w-full px-4 py-2 border rounded-lg">
            </div>
            
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closePublicationModal()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPublicationModal() {
    document.getElementById('publicationModal').classList.remove('hidden');
}
function closePublicationModal() {
    document.getElementById('publicationModal').classList.add('hidden');
}
function editPublication(id) {
    // TODO: Fetch data by ID and populate form
    document.getElementById('modalTitle').textContent = 'Edit Publikasi';
    openPublicationModal();
}
</script>

<?php
$content = ob_get_clean();
$title = "Publikasi Saya";
include __DIR__ . "/../../layouts/member.php";
?>
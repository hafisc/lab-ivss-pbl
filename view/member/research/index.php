<?php 
/**
 * View Riset Saya
 * 
 * Halaman daftar riset yang diikuti oleh member. Menampilkan status riset,
 * dokumen yang diupload, dan opsi untuk mengupload laporan baru.
 * 
 * @package View
 * @subpackage Member/Research
 */

ob_start();

// Mengambil info user dari session
$userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? 0;
$userName = $_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'Member';
?>

<!-- Header Halaman -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 mb-1">Riset Saya</h1>
            <p class="text-sm text-slate-500">Kelola riset dan upload hasil penelitian kamu</p>
        </div>
        <!-- Badge Total Riset Aktif (Desktop) -->
        <div class="hidden sm:flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs rounded-lg font-medium shadow-sm border border-blue-100">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <?= count($myResearches ?? []) ?> Riset Terdaftar
            </span>
        </div>
    </div>
</div>

<!-- Overview Statistik -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <!-- Kartu: Total Riset -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-2">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= count($myResearches ?? []) ?></h3>
        <p class="text-xs text-slate-600">Total Riset</p>
    </div>
    
    <!-- Kartu: Riset Aktif -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-2">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= count(array_filter($myResearches ?? [], fn($r) => $r['status'] === 'active')) ?></h3>
        <p class="text-xs text-slate-600">Riset Aktif</p>
    </div>
    
    <!-- Kartu: Dokumen -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-2">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= $totalDocuments ?? 0 ?></h3>
        <p class="text-xs text-slate-600">Dokumen</p>
    </div>
    
    <!-- Kartu: Selesai -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-2">
            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-slate-800"><?= count(array_filter($myResearches ?? [], fn($r) => $r['status'] === 'completed')) ?></h3>
        <p class="text-xs text-slate-600">Selesai</p>
    </div>
</div>

<!-- Konten Utama: Daftar Riset -->
<?php if (empty($myResearches)): ?>
    <!-- Empty State -->
    <div class="bg-white rounded-xl border border-slate-200 p-12 text-center shadow-sm">
        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Riset</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-md mx-auto">
            Kamu belum terdaftar dalam riset apapun. Hubungi dosen pembimbing untuk bergabung dalam riset lab.
        </p>
        <div class="flex items-center justify-center gap-3">
            <a href="index.php?page=member" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

<?php else: ?>
    <!-- Looping Daftar Riset -->
    <div class="space-y-4">
        <?php foreach ($myResearches as $research): ?>
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300">
            <!-- Header Card Riset -->
            <div class="p-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-start gap-3 mb-2">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-bold text-slate-800 mb-1"><?= htmlspecialchars($research['title']) ?></h3>
                                <div class="flex items-center gap-3 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <?= htmlspecialchars($research['category'] ?? 'Riset Lainnya') ?>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <?= date('d M Y', strtotime($research['start_date'] ?? 'now')) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Badge Status -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <?php if ($research['status'] === 'active'): ?>
                            <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full border border-green-200">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                Active
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-medium rounded-full border border-slate-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Completed
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Konten Card Riset -->
            <div class="p-5">
                <!-- Deskripsi -->
                <div class="mb-4">
                    <p class="text-sm text-slate-600 line-clamp-2"><?= htmlspecialchars($research['description'] ?? 'Tidak ada deskripsi') ?></p>
                </div>

                <!-- Info Tim -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-slate-500 mb-0.5">Leader</p>
                            <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($research['leader_name'] ?? '-') ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-slate-500 mb-0.5">Team Members</p>
                            <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($research['team_members'] ?? 'Solo') ?></p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center gap-2 pt-4 border-t border-slate-200">
                    <button onclick="showUploadModal(<?= $research['id'] ?>)" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Laporan
                    </button>
                    <button onclick="viewResearchDetail(<?= $research['id'] ?>)" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors border border-slate-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Modal Upload Laporan (Hidden by default) -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl transform transition-transform scale-100">
        <!-- Header Modal -->
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800">Upload Laporan Riset</h3>
                <button onclick="closeUploadModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Form Upload -->
        <form id="uploadForm" enctype="multipart/form-data" class="p-6">
            <input type="hidden" name="research_id" id="research_id">
            
            <!-- Area Upload File -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">File Dokumen <span class="text-red-500">*</span></label>
                <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer" onclick="document.getElementById('fileInput').click()">
                    <input type="file" id="fileInput" name="document" class="hidden" accept=".pdf,.doc,.docx" required>
                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-sm text-slate-600 font-medium">Klik untuk pilih file atau drag & drop</p>
                    <p class="text-xs text-slate-500 mt-1">Format: PDF, DOC, DOCX (Maks. 10MB)</p>
                </div>
                <!-- Indikator File Terpilih -->
                <div id="fileName" class="text-sm text-blue-600 mt-2 hidden flex items-center gap-2 bg-blue-50 p-2 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span id="fileNameText"></span>
                </div>
            </div>

            <!-- Input Judul -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Judul Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Laporan Progress Bulan 1"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focuse:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Tambahkan keterangan singkat mengenai dokumen ini..."
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"></textarea>
            </div>

            <!-- Tombol Aksi Modal -->
            <div class="flex items-center gap-3">
                <button type="button" onclick="closeUploadModal()" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Upload Dokumen
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Handling Modal & File -->
<script>
// Menampilkan nama file saat dipilih
document.getElementById('fileInput').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    const fileNameContainer = document.getElementById('fileName');
    const fileNameText = document.getElementById('fileNameText');
    
    if (fileName) {
        fileNameText.textContent = fileName;
        fileNameContainer.classList.remove('hidden');
    }
});

// Fungsi Membuka Modal
function showUploadModal(researchId) {
    document.getElementById('research_id').value = researchId;
    const modal = document.getElementById('uploadModal');
    modal.classList.remove('hidden');
    // Animasi fade in bisa ditambahkan di sini jika perlu
    document.body.style.overflow = 'hidden'; // Prevent scroll
}

// Fungsi Menutup Modal
function closeUploadModal() {
    const modal = document.getElementById('uploadModal');
    modal.classList.add('hidden');
    document.getElementById('uploadForm').reset();
    document.getElementById('fileName').classList.add('hidden');
    document.body.style.overflow = ''; // Restore scroll
}

// Navigasi ke Detail Riset
function viewResearchDetail(researchId) {
    window.location.href = 'index.php?page=member-research-detail&id=' + researchId;
}

// Tutup modal saat klik area luar
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUploadModal();
    }
});
</script>

<?php
// Mengakhiri buffer dan memuat layout
$content = ob_get_clean();
$title = "Riset Saya";
require_once __DIR__ . '/../../layouts/member.php';
?>
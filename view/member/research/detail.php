<?php 
/**
 * View Detail Riset
 * 
 * Halaman detail dari sebuah riset, menampilkan deskripsi lengkap,
 * anggota tim, status pengerjaan, dan daftar dokumen terkait.
 * 
 * @package View
 * @subpackage Member/Research
 */

ob_start();

// Validasi ID Riset dari URL
if (!isset($_GET['id'])) {
    header('Location: index.php?page=member-research');
    exit;
}

// Simulasi Data (TODO: Ganti dengan pengambilan data dari database)
$researchId = $_GET['id'];
$researchDetail = [
    'id' => $researchId,
    'title' => 'Pengembangan Sistem Cerdas untuk Deteksi Penyakit Tanaman',
    'description' => 'Membangun model deep learning untuk mendeteksi penyakit pada tanaman padi menggunakan citra drone. Penelitian ini bertujuan untuk membantu petani dalam mengidentifikasi masalah lebih dini.',
    'status' => 'active',
    'category' => 'Artificial Intelligence',
    'start_date' => '2024-01-15',
    'end_date' => '2024-12-31',
    'leader' => 'Dr. Budi Santoso',
    'members' => [
        ['name' => 'Ahmad Rizki', 'role' => 'Researcher', 'avatar' => null],
        ['name' => 'Siti Aminah', 'role' => 'Data Analyst', 'avatar' => null],
        ['name' => 'Budi Utomo', 'role' => 'Field Engineer', 'avatar' => null]
    ],
    'documents' => [
        ['id' => 1, 'title' => 'Proposal Penelitian', 'type' => 'pdf', 'date' => '2024-01-20', 'size' => '2.4 MB'],
        ['id' => 2, 'title' => 'Laporan Progress Q1', 'type' => 'docx', 'date' => '2024-04-10', 'size' => '1.8 MB']
    ]
];
?>

<!-- Breadcrumb Navigasi -->
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="index.php?page=member-dashboard" class="inline-flex items-center text-sm font-medium text-slate-700 hover:text-blue-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    Dashboard
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="index.php?page=member-research" class="ml-1 text-sm font-medium text-slate-700 hover:text-blue-600 md:ml-2">Riset Saya</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2">Detail Riset</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Header Detail Riset -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <?= htmlspecialchars($researchDetail['category']) ?>
                </span>
                <?php if ($researchDetail['status'] === 'active'): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Active
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">Completed</span>
                <?php endif; ?>
            </div>
            
            <h1 class="text-2xl font-bold text-slate-900 mb-2"><?= htmlspecialchars($researchDetail['title']) ?></h1>
            <p class="text-slate-600 leading-relaxed"><?= htmlspecialchars($researchDetail['description']) ?></p>
            
            <div class="flex items-center gap-6 mt-6">
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Mulai: <?= date('d M Y', strtotime($researchDetail['start_date'])) ?>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Target: <?= date('d M Y', strtotime($researchDetail['end_date'])) ?>
                </div>
            </div>
        </div>
        
        <!-- Action Button -->
        <button onclick="showUploadModal(<?= $researchId ?>)" class="flex-shrink-0 inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>
            Upload Laporan
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Anggota Tim & Detail -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- List Anggota Tim -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-base font-semibold text-slate-900">Anggota Tim</h3>
            </div>
            <div class="p-6">
                <!-- Leader -->
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                            <?= strtoupper(substr($researchDetail['leader'], 0, 1)) ?>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-slate-900"><?= $researchDetail['leader'] ?></h4>
                        <p class="text-xs text-slate-500">Project Leader / Supervisor</p>
                    </div>
                    <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Leader
                    </span>
                </div>
                
                <!-- Separator -->
                <div class="border-t border-slate-100 my-4"></div>
                
                <!-- Members List -->
                <div class="space-y-4">
                    <?php foreach ($researchDetail['members'] as $member): ?>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-9 w-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-medium text-sm">
                                <?= strtoupper(substr($member['name'], 0, 1)) ?>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-slate-900"><?= $member['name'] ?></h4>
                            <p class="text-xs text-slate-500"><?= $member['role'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Kolom Kanan: Dokumen -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <h3 class="text-base font-semibold text-slate-900">Dokumen</h3>
                <span class="bg-slate-200 text-slate-700 py-0.5 px-2 rounded-full text-xs font-medium"><?= count($researchDetail['documents']) ?></span>
            </div>
            <div class="divide-y divide-slate-100">
                <?php if (empty($researchDetail['documents'])): ?>
                    <div class="p-6 text-center text-slate-500 text-sm">
                        Belum ada dokumen yang diupload
                    </div>
                <?php else: ?>
                    <?php foreach ($researchDetail['documents'] as $doc): ?>
                    <div class="p-4 hover:bg-slate-50 transition-colors group">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <?php if ($doc['type'] === 'pdf'): ?>
                                    <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path><path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path></svg>
                                <?php else: ?>
                                    <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"></path><path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"></path></svg>
                                <?php endif; ?>
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate"><?= $doc['title'] ?></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-slate-500 uppercase"><?= $doc['type'] ?></span>
                                    <span class="text-xs text-slate-300">•</span>
                                    <span class="text-xs text-slate-500"><?= $doc['size'] ?></span>
                                    <span class="text-xs text-slate-300">•</span>
                                    <span class="text-xs text-slate-500"><?= date('d M', strtotime($doc['date'])) ?></span>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0">
                                <button class="text-slate-400 hover:text-blue-600 transition-colors p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!-- Footer Card -->
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-200">
                <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center justify-center">
                    Lihat Semua Dokumen
                </a>
            </div>
        </div>
    </div>
    
</div>

<!-- Modal Upload (Sama seperti di index, bisa di-include atau diload dinamis) -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-2xl">
        <h3 class="text-lg font-bold mb-4">Upload Dokumen Laporan</h3>
        <p class="text-sm text-slate-500 mb-4">Upload dokumen baru untuk riset ini.</p>
        <form>
            <div class="space-y-4">
                <div class="border-2 border-dashed border-slate-300 rounded-lg p-8 text-center cursor-pointer hover:bg-slate-50">
                    <span class="text-sm text-slate-500">Klik untuk pilih file</span>
                </div>
                <input type="text" placeholder="Judul Dokumen" class="w-full px-4 py-2 border rounded-lg">
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeUploadModal()" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function showUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}
function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
}
</script>

<?php
$content = ob_get_clean();
$title = "Detail Riset";
include __DIR__ . "/../../layouts/member.php";
?>

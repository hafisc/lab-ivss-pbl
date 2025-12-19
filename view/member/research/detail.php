<?php 
ob_start();

// Get research ID from URL
$researchId = $_GET['id'] ?? 0;

// Get user info
$userId = $_SESSION['user_id'] ?? 0;

// Fetch research detail from database
require_once __DIR__ . '/../../../app/config/Database.php';
$db = Database::getInstance()->getPgConnection();

// Get research detail with leader info
$query = "SELECT r.*, u.username as leader_name 
          FROM research r 
          LEFT JOIN users u ON r.leader_id = u.id 
          WHERE r.id = $1 
          LIMIT 1";
$result = pg_query_params($db, $query, [$researchId]);

$research = null;
if ($result && pg_num_rows($result) > 0) {
    $research = pg_fetch_assoc($result);
    pg_free_result($result);
}

// If research not found or user doesn't have access, redirect
if (!$research) {
    $_SESSION['error'] = 'Riset tidak ditemukan.';
    header('Location: index.php?page=member-research');
    exit;
}

// Verify access - user should be the leader or team member
// For now, we only check if user is the leader
if ($research['leader_id'] != $userId) {
    $_SESSION['error'] = 'Anda tidak memiliki akses ke riset ini.';
    header('Location: index.php?page=member-research');
    exit;
}

// TODO: Fetch documents from database
// For now using empty array as documents table doesn't exist yet
$documents = [];

// Helper function to format file size
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' B';
    }
}
?>

<!-- Breadcrumb -->
<div class="mb-6">
    <nav class="flex items-center gap-2 text-sm text-slate-500">
        <a href="index.php?page=member-research" class="hover:text-blue-600 transition-colors">Riset Saya</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-slate-800 font-medium">Detail Riset</span>
    </nav>
</div>

<!-- Research Header -->
<div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
    <div class="flex items-start justify-between gap-4 mb-4">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-slate-800 mb-1"><?= htmlspecialchars($research['title']) ?></h1>
                    <div class="flex items-center gap-3 text-sm text-slate-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <?= htmlspecialchars($research['category']) ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?= date('d M Y', strtotime($research['start_date'])) ?> - <?= date('d M Y', strtotime($research['end_date'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-shrink-0">
            <?php if ($research['status'] === 'active'): ?>
                <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 text-sm font-medium rounded-full">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    Active
                </span>
            <?php else: ?>
                <span class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-full">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Completed
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Description -->
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-2">Deskripsi Riset</h3>
        <p class="text-sm text-slate-600 leading-relaxed"><?= htmlspecialchars($research['description']) ?></p>
    </div>

    <!-- Research Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4 bg-slate-50 rounded-lg">
        <!-- Leader -->
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Leader</p>
                <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($research['leader_name']) ?></p>
            </div>
        </div>

        <!-- Team -->
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Team Members</p>
                <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($research['team_members']) ?></p>
            </div>
        </div>

        <!-- Funding -->
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Funding</p>
                <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($research['funding']) ?></p>
            </div>
        </div>

        <!-- Publications -->
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <div>
                <p class="text-xs text-slate-500 mb-0.5">Publications</p>
                <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($research['publications'] ?? '-') ?></p>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="mt-6 pt-6 border-t border-slate-200">
        <button onclick="showUploadModal(<?= $research['id'] ?>)" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            Upload Dokumen Baru
        </button>
    </div>
</div>

<!-- Documents Section -->
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    Dokumen & Laporan
                </h2>
                <p class="text-xs text-slate-500 mt-1">Total <?= count($documents) ?> dokumen telah diupload</p>
            </div>
        </div>
    </div>

    <?php if (empty($documents)): ?>
        <!-- Empty State -->
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-slate-700 mb-1">Belum Ada Dokumen</h3>
            <p class="text-xs text-slate-500">Upload dokumen pertama kamu sekarang</p>
        </div>
    <?php else: ?>
        <!-- Documents List -->
        <div class="divide-y divide-slate-200">
            <?php foreach ($documents as $doc): ?>
            <div class="p-5 hover:bg-slate-50 transition-colors">
                <div class="flex items-start gap-4">
                    <!-- File Icon -->
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>

                    <!-- Document Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-slate-800 mb-1"><?= htmlspecialchars($doc['title']) ?></h3>
                        <p class="text-xs text-slate-600 mb-2"><?= htmlspecialchars($doc['description']) ?></p>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <?= htmlspecialchars($doc['file_name']) ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                                <?= formatFileSize($doc['file_size']) ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?= htmlspecialchars($doc['uploaded_by']) ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?= date('d M Y H:i', strtotime($doc['uploaded_at'])) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="#" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Download">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                        <button onclick="deleteDocument(<?= $doc['id'] ?>)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Upload Modal (Same as in index.php) -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800">Upload Dokumen Baru</h3>
                <button onclick="closeUploadModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <form id="uploadForm" enctype="multipart/form-data" class="p-6">
            <input type="hidden" name="research_id" id="research_id" value="<?= $research['id'] ?>">
            
            <!-- File Upload -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">File Dokumen *</label>
                <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors cursor-pointer" onclick="document.getElementById('fileInput').click()">
                    <input type="file" id="fileInput" name="document" class="hidden" accept=".pdf,.doc,.docx" required>
                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-sm text-slate-600 font-medium">Click to upload atau drag and drop</p>
                    <p class="text-xs text-slate-500 mt-1">PDF, DOC, DOCX (Max. 10MB)</p>
                </div>
                <div id="fileName" class="text-sm text-slate-600 mt-2 hidden"></div>
            </div>

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Judul Dokumen *</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Upload Dokumen
                </button>
                <button type="button" onclick="closeUploadModal()" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// File input handler
document.getElementById('fileInput').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    const fileNameDiv = document.getElementById('fileName');
    if (fileName) {
        fileNameDiv.textContent = '📄 ' + fileName;
        fileNameDiv.classList.remove('hidden');
    }
});

// Modal functions
function showUploadModal(researchId) {
    document.getElementById('research_id').value = researchId;
    document.getElementById('uploadModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
    document.getElementById('uploadForm').reset();
    document.getElementById('fileName').classList.add('hidden');
    document.body.style.overflow = '';
}

// Delete document
function deleteDocument(docId) {
    if (confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
        // TODO: Implement delete via AJAX
        console.log('Delete document:', docId);
        alert('Fitur hapus dokumen akan segera ditambahkan');
    }
}

// Close modal when clicking outside
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUploadModal();
    }
});
</script>

<?php
$content = ob_get_clean();
$title = "Detail Riset - " . $research['title'];
require_once __DIR__ . '/../../layouts/member.php';
?>

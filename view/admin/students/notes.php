<?php
ob_start();

// Get student ID from URL
$studentId = $_GET['id'] ?? 0;

// Fetch student detail from database
require_once __DIR__ . '/../../../app/config/Database.php';
$db = Database::getInstance()->getPgConnection();

// Get student detail
$query = "SELECT m.*, u.email, u.username,
          COALESCE(m.nama, u.username) as display_name
          FROM mahasiswa m 
          JOIN users u ON m.user_id = u.id 
          WHERE m.id = $1 
          LIMIT 1";
$result = pg_query_params($db, $query, [$studentId]);

$student = null;
if ($result && pg_num_rows($result) > 0) {
    $student = pg_fetch_assoc($result);
    pg_free_result($result);
}

// If student not found, redirect
if (!$student) {
    $_SESSION['error'] = 'Mahasiswa tidak ditemukan.';
    header('Location: index.php?page=admin-students');
    exit;
}

// Get notes for this student
$queryNotes = "SELECT n.*, u.username as created_by_name 
               FROM student_notes n
               LEFT JOIN users u ON n.created_by = u.id
               WHERE n.student_id = $1 
               ORDER BY n.created_at DESC";
$resNotes = pg_query_params($db, $queryNotes, [$studentId]);
$notes = [];
if ($resNotes) {
    while ($row = pg_fetch_assoc($resNotes)) {
        $notes[] = $row;
    }
    pg_free_result($resNotes);
}
?>

<!-- Back Button -->
<div class="mb-4">
    <a href="index.php?page=admin-students&action=detail&id=<?= $studentId ?>" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Detail
    </a>
</div>

<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Catatan Bimbingan</h2>
            <p class="text-sm text-slate-500 mt-1">
                Catatan untuk: <span class="font-semibold text-slate-700"><?= htmlspecialchars($student['display_name']) ?></span>
            </p>
        </div>
        <button onclick="showAddNoteModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Catatan
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

<!-- Notes Timeline -->
<div class="max-w-4xl">
    <?php if (empty($notes)): ?>
        <!-- Empty State -->
        <div class="bg-white border border-slate-200 rounded-xl p-12 text-center">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Catatan</h3>
            <p class="text-sm text-slate-500 mb-4">Mulai tambahkan catatan bimbingan untuk mahasiswa ini</p>
            <button onclick="showAddNoteModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Tambah Catatan Pertama
            </button>
        </div>
    <?php else: ?>
        <!-- Notes List -->
        <div class="space-y-4">
            <?php foreach ($notes as $note): ?>
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                <!-- Note Header -->
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                            <span class="text-sm font-bold text-white">
                                <?= strtoupper(substr($note['created_by_name'] ?? 'A', 0, 1)) ?>
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($note['created_by_name'] ?? 'Admin') ?></p>
                            <p class="text-xs text-slate-500">
                                <?= date('d M Y, H:i', strtotime($note['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <?php
                        $typeColors = [
                            'bimbingan' => 'bg-blue-100 text-blue-700',
                            'progress' => 'bg-green-100 text-green-700',
                            'peringatan' => 'bg-red-100 text-red-700',
                            'lainnya' => 'bg-slate-100 text-slate-700'
                        ];
                        $typeColor = $typeColors[$note['type'] ?? 'lainnya'] ?? 'bg-slate-100 text-slate-700';
                        ?>
                        <span class="<?= $typeColor ?> px-3 py-1 text-xs font-semibold rounded-full">
                            <?= ucfirst($note['type'] ?? 'Lainnya') ?>
                        </span>
                        <button onclick="deleteNote(<?= $note['id'] ?>)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Note Content -->
                <div class="px-6 py-4">
                    <?php if (!empty($note['title'])): ?>
                        <h4 class="text-sm font-semibold text-slate-800 mb-2"><?= htmlspecialchars($note['title']) ?></h4>
                    <?php endif; ?>
                    <p class="text-sm text-slate-700 whitespace-pre-wrap"><?= htmlspecialchars($note['content']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Add Note Modal -->
<div id="addNoteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800">Tambah Catatan Bimbingan</h3>
                <button onclick="closeAddNoteModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form action="index.php?page=admin-students&action=save-note" method="POST" class="p-6">
            <input type="hidden" name="student_id" value="<?= $studentId ?>">
            
            <!-- Type -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Catatan *</label>
                <select name="type" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    <option value="bimbingan">Bimbingan</option>
                    <option value="progress">Progress</option>
                    <option value="peringatan">Peringatan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            
            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Judul (Opsional)</label>
                <input type="text" name="title" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Judul catatan">
            </div>
            
            <!-- Content -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Isi Catatan *</label>
                <textarea name="content" required rows="6" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" placeholder="Tulis catatan bimbingan..."></textarea>
            </div>
            
            <!-- Buttons -->
            <div class="flex items-center gap-3">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Simpan Catatan
                </button>
                <button type="button" onclick="closeAddNoteModal()" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddNoteModal() {
    document.getElementById('addNoteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddNoteModal() {
    document.getElementById('addNoteModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function deleteNote(id) {
    if (confirm('Hapus catatan ini?')) {
        window.location.href = 'index.php?page=admin-students&action=delete-note&id=' + id + '&student_id=<?= $studentId ?>';
    }
}

// Close modal when clicking outside
document.getElementById('addNoteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddNoteModal();
    }
});
</script>

<?php
$content = ob_get_clean();
$title = "Catatan Bimbingan";
include __DIR__ . '/../../layouts/admin.php';
?>

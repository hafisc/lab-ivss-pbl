<?php
ob_start();

// Get student ID from URL
$studentId = $_GET['id'] ?? 0;

// Fetch student detail from database
require_once __DIR__ . '/../../../app/config/Database.php';
$db = Database::getInstance()->getPgConnection();

// Get student detail with user info
$query = "SELECT m.*, u.email, u.status, u.username, u.created_at as join_date,
          COALESCE(m.nama, u.username) as display_name,
          d.nama as supervisor_name
          FROM mahasiswa m 
          JOIN users u ON m.user_id = u.id 
          LEFT JOIN dosen d ON m.supervisor_id = d.id
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

// Get student's publications (skip for now - table doesn't exist yet)
$publications = [];
// TODO: Implement when member_publications table is created

// Get student's research involvement via research_members table
$queryResearch = "SELECT r.*, u.username as leader_name 
                  FROM research r 
                  LEFT JOIN users u ON r.leader_id = u.id 
                  INNER JOIN research_members rm ON r.id = rm.research_id
                  WHERE rm.user_id = $1
                  ORDER BY r.created_at DESC";
$resResearch = pg_query_params($db, $queryResearch, [$student['user_id']]);
$researches = [];
if ($resResearch) {
    while ($row = pg_fetch_assoc($resResearch)) {
        $researches[] = $row;
    }
    pg_free_result($resResearch);
}
?>

<!-- Back Button -->
<div class="mb-4">
    <a href="index.php?page=admin-students" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Daftar Mahasiswa
    </a>
</div>

<!-- Page Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Detail Mahasiswa</h2>
    <p class="text-sm text-slate-500 mt-1">Informasi lengkap mahasiswa bimbingan</p>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Left Column: Student Info -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Profile Card -->
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-blue-50 to-purple-50">
                <div class="flex items-start gap-4">
                    <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0 border-4 border-white shadow-lg">
                        <span class="text-3xl font-bold text-white">
                            <?= strtoupper(substr($student['display_name'], 0, 1)) ?>
                        </span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($student['display_name']) ?></h3>
                        <p class="text-sm text-slate-600 mt-1"><?= htmlspecialchars($student['email']) ?></p>
                        <div class="flex items-center gap-3 mt-3">
                            <?php if ($student['status'] === 'active'): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Aktif</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-semibold rounded-full">Alumni</span>
                            <?php endif; ?>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                Angkatan <?= htmlspecialchars($student['angkatan'] ?? '-') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Details -->
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- NIM -->
                    <div>
                        <p class="text-xs text-slate-500 mb-1">NIM</p>
                        <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($student['nim'] ?? '-') ?></p>
                    </div>
                    
                    <!-- Angkatan -->
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Angkatan</p>
                        <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($student['angkatan'] ?? '-') ?></p>
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Telepon</p>
                        <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($student['phone'] ?? '-') ?></p>
                    </div>
                    
                    <!-- Supervisor -->
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Pembimbing</p>
                        <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($student['supervisor_name'] ?? '-') ?></p>
                    </div>
                    
                    <!-- Join Date -->
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Bergabung</p>
                        <p class="text-sm font-semibold text-slate-800">
                            <?= date('d M Y', strtotime($student['join_date'] ?? 'now')) ?>
                        </p>
                    </div>
                    
                    <!-- Origin -->
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Asal Prodi/Kelas</p>
                        <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($student['origin'] ?? '-') ?></p>
                    </div>
                </div>
                
                <!-- Research Topic -->
                <?php if (!empty($student['research_title'])): ?>
                <div class="pt-4 border-t border-slate-200">
                    <p class="text-xs text-slate-500 mb-1">Topik Riset</p>
                    <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($student['research_title']) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Research Involvement -->
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h4 class="font-semibold text-slate-800">Riset yang Diikuti</h4>
            </div>
            <div class="p-6">
                <?php if (empty($researches)): ?>
                    <p class="text-sm text-slate-500 text-center py-4">Belum terlibat dalam riset</p>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($researches as $research): ?>
                        <div class="p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                            <h5 class="text-sm font-semibold text-slate-800 mb-1"><?= htmlspecialchars($research['title']) ?></h5>
                            <p class="text-xs text-slate-600 mb-2"><?= htmlspecialchars($research['category'] ?? 'Riset') ?></p>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-slate-500">Leader: <?= htmlspecialchars($research['leader_name'] ?? '-') ?></span>
                                <?php if ($research['status'] === 'active'): ?>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">Active</span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-xs rounded-full">Completed</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Publications -->
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h4 class="font-semibold text-slate-800">Publikasi</h4>
            </div>
            <div class="p-6">
                <?php if (empty($publications)): ?>
                    <p class="text-sm text-slate-500 text-center py-4">Belum ada publikasi</p>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($publications as $pub): ?>
                        <div class="p-4 border border-slate-200 rounded-lg">
                            <h5 class="text-sm font-semibold text-slate-800 mb-1"><?= htmlspecialchars($pub['title']) ?></h5>
                            <p class="text-xs text-slate-600 mb-2"><?= htmlspecialchars($pub['authors']) ?></p>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span><?= htmlspecialchars($pub['journal'] ?? '-') ?></span>
                                <span>•</span>
                                <span><?= $pub['year'] ?></span>
                                <?php if ($pub['status'] === 'published'): ?>
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">Published</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
    
    <!-- Right Sidebar: Quick Actions -->
    <div class="space-y-4">
        
        <!-- Contact Card -->
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <h4 class="font-semibold text-slate-800 mb-4">Kontak</h4>
            <div class="space-y-3">
                <a href="mailto:<?= htmlspecialchars($student['email']) ?>" 
                   class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-blue-600 font-medium">Email</p>
                        <p class="text-xs text-slate-600 truncate"><?= htmlspecialchars($student['email']) ?></p>
                    </div>
                </a>
                
                <?php if (!empty($student['phone'])): ?>
                <a href="https://wa.me/<?= htmlspecialchars($student['phone']) ?>" 
                   target="_blank"
                   class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-green-600 font-medium">WhatsApp</p>
                        <p class="text-xs text-slate-600"><?= htmlspecialchars($student['phone']) ?></p>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <h4 class="font-semibold text-slate-800 mb-4">Statistik</h4>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Riset</span>
                    <span class="text-sm font-bold text-slate-800"><?= count($researches) ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Publikasi</span>
                    <span class="text-sm font-bold text-slate-800"><?= count($publications) ?></span>
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<?php
$content = ob_get_clean();
$title = "Detail Mahasiswa";
include __DIR__ . '/../../layouts/admin.php';
?>

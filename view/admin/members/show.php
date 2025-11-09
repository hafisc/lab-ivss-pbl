<?php 
ob_start(); 

// Get user role
$userRole = $_SESSION['user']['role'] ?? 'member';
$canApprove = ($userRole === 'dosen' || $userRole === 'ketua_lab');
?>

<!-- Back Button -->
<div class="mb-4">
    <a href="index.php?page=admin-registrations" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Daftar Pendaftar
    </a>
</div>

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

<!-- Info Box for Admin -->
<?php if ($userRole === 'admin'): ?>
<div class="mb-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
    <div class="flex items-start">
        <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <div class="flex-1">
            <h4 class="text-sm font-semibold text-blue-900 mb-1">ℹ️ Mode View-Only</h4>
            <p class="text-xs text-blue-800">
                Sebagai Admin, Anda <strong>hanya dapat melihat detail</strong> pendaftar. 
                Approval dilakukan oleh <strong>Dosen Pembimbing</strong> dan <strong>Ketua Lab</strong>.
            </p>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Detail Pendaftar -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <div class="text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl font-bold text-white">
                        <?= strtoupper(substr($registration['name'], 0, 1)) ?>
                    </span>
                </div>
                <h2 class="text-lg font-bold text-slate-900"><?= htmlspecialchars($registration['name']) ?></h2>
                <p class="text-sm text-slate-600"><?= htmlspecialchars($registration['email']) ?></p>
                
                <!-- Status Badge -->
                <div class="mt-4">
                    <?php 
                    $status = $registration['status'] ?? 'pending_supervisor';
                    $statusConfig = [
                        'pending_supervisor' => ['label' => 'Menunggu Approval Dosen', 'color' => 'bg-amber-100 text-amber-700 border-amber-200'],
                        'pending_lab_head' => ['label' => 'Menunggu Approval Ketua Lab', 'color' => 'bg-blue-100 text-blue-700 border-blue-200'],
                        'approved' => ['label' => 'Disetujui - Member Aktif', 'color' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                        'rejected_supervisor' => ['label' => 'Ditolak Dosen', 'color' => 'bg-red-100 text-red-700 border-red-200'],
                        'rejected_lab_head' => ['label' => 'Ditolak Ketua Lab', 'color' => 'bg-red-100 text-red-700 border-red-200']
                    ];
                    $config = $statusConfig[$status] ?? $statusConfig['pending_supervisor'];
                    ?>
                    <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-medium border <?= $config['color'] ?>">
                        <?= $config['label'] ?>
                    </span>
                </div>
                
                <!-- Action Buttons (Dosen & Ketua Lab only) -->
                <?php if (($status === 'pending_supervisor' || $status === 'pending_lab_head') && $canApprove): ?>
                <div class="mt-6 flex gap-2">
                    <a href="index.php?page=admin-registrations&action=approve&id=<?= $registration['id'] ?>" 
                       onclick="return confirm('Approve pendaftar ini?')"
                       class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors">
                        ✓ Approve
                    </a>
                    <a href="index.php?page=admin-registrations&action=reject&id=<?= $registration['id'] ?>" 
                       onclick="return confirm('Tolak pendaftar ini?')"
                       class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                        ✗ Tolak
                    </a>
                </div>
                <?php elseif (($status === 'pending_supervisor' || $status === 'pending_lab_head') && $userRole === 'admin'): ?>
                <!-- Admin View-Only Message -->
                <div class="mt-6 p-3 bg-slate-100 rounded-lg text-center">
                    <p class="text-xs text-slate-600">
                        👁️ <strong>View-Only Mode</strong><br>
                        Approval dilakukan oleh Dosen & Ketua Lab
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Detail Information -->
    <div class="lg:col-span-2">
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="px-4 py-3 bg-slate-800 border-b border-slate-700">
                <h3 class="font-bold text-white">Detail Pendaftaran</h3>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Data Pribadi -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Data Pribadi
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">NIM</p>
                            <p class="text-sm font-medium text-slate-900"><?= htmlspecialchars($registration['nim'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Angkatan</p>
                            <p class="text-sm font-medium text-slate-900"><?= htmlspecialchars($registration['angkatan'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">No. Telepon</p>
                            <p class="text-sm font-medium text-slate-900"><?= htmlspecialchars($registration['phone'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Asal</p>
                            <p class="text-sm font-medium text-slate-900"><?= htmlspecialchars($registration['origin'] ?? '-') ?></p>
                        </div>
                    </div>
                </div>
                
                <hr class="border-slate-200">
                
                <!-- Penelitian -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Penelitian
                    </h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Judul Penelitian</p>
                            <p class="text-sm font-medium text-slate-900"><?= htmlspecialchars($registration['research_title'] ?? '-') ?></p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Dosen Pengampu</p>
                            <p class="text-sm font-medium text-slate-900">
                                <?= htmlspecialchars($registration['supervisor_name'] ?? '-') ?>
                                <?php if (!empty($registration['supervisor_email'])): ?>
                                <span class="text-xs text-slate-500">(<?= htmlspecialchars($registration['supervisor_email']) ?>)</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <hr class="border-slate-200">
                
                <!-- Motivasi -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Motivasi Bergabung
                    </h4>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <p class="text-sm text-slate-700 leading-relaxed">
                            <?= nl2br(htmlspecialchars($registration['motivation'] ?? '-')) ?>
                        </p>
                    </div>
                </div>
                
                <hr class="border-slate-200">
                
                <!-- Timeline Approval -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Timeline
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-blue-600 mt-1.5"></div>
                            <div>
                                <p class="text-xs font-medium text-slate-900">Mendaftar</p>
                                <p class="text-xs text-slate-500"><?= date('d M Y H:i', strtotime($registration['created_at'])) ?></p>
                            </div>
                        </div>
                        <?php if (!empty($registration['supervisor_approved_at'])): ?>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-600 mt-1.5"></div>
                            <div>
                                <p class="text-xs font-medium text-slate-900">Approved Dosen</p>
                                <p class="text-xs text-slate-500"><?= date('d M Y H:i', strtotime($registration['supervisor_approved_at'])) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($registration['lab_head_approved_at'])): ?>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-600 mt-1.5"></div>
                            <div>
                                <p class="text-xs font-medium text-slate-900">Approved Ketua Lab</p>
                                <p class="text-xs text-slate-500"><?= date('d M Y H:i', strtotime($registration['lab_head_approved_at'])) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php
$content = ob_get_clean();
$title = "Detail Pendaftar - " . htmlspecialchars($registration['name']);
include __DIR__ . "/../../layouts/admin.php";
?>

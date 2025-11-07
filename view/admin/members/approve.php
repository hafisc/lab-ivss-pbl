<?php ob_start(); ?>



<!-- Alert Messages -->
<?php if (isset($_SESSION['success'])): ?>
<div class="mb-3 bg-green-50 border-l-4 border-green-500 p-3 rounded-lg">
    <div class="flex items-center">
        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <p class="text-xs text-green-700 font-medium"><?= $_SESSION['success'] ?></p>
    </div>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-3 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
    <div class="flex items-center">
        <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
        </svg>
        <p class="text-xs text-red-700 font-medium"><?= $_SESSION['error'] ?></p>
    </div>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Table Card -->
<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    
    <!-- Table Header -->
    <div class="p-3 border-b border-slate-200 bg-slate-50">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-800 text-sm">Daftar Pendaftar</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Total: <span class="font-medium text-slate-700"><?= count($registrations ?? []) ?></span> pendaftar menunggu approval
                </p>
            </div>
        </div>
    </div>
    
    <!-- Table Content -->
    <div class="overflow-x-auto">
        <?php if (empty($registrations)): ?>
            <!-- Empty State -->
            <div class="p-8 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-sm font-medium text-slate-700 mb-1">Tidak ada pendaftar baru</h3>
                <p class="text-xs text-slate-500">Semua pendaftar sudah di-review atau belum ada yang mendaftar.</p>
            </div>
        <?php else: ?>
            <!-- Table -->
            <table class="w-full text-xs">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">#</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">Nama</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden md:table-cell">Judul Penelitian</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden lg:table-cell">Asal</th>
                        <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">Status Approval</th>
                        <th class="text-center px-3 py-2 font-medium text-slate-600 text-xs">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php foreach ($registrations as $index => $reg): ?>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-2.5 text-slate-500 text-xs"><?= $index + 1 ?></td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-semibold text-blue-700">
                                        <?= strtoupper(substr($reg['name'], 0, 1)) ?>
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 text-xs"><?= htmlspecialchars($reg['name']) ?></p>
                                    <p class="text-xs text-slate-500"><?= htmlspecialchars($reg['email']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 text-xs hidden md:table-cell">
                            <?= htmlspecialchars($reg['research_title'] ?? '-') ?>
                        </td>
                        <td class="px-3 py-2.5 text-slate-600 text-xs hidden lg:table-cell">
                            <?= htmlspecialchars($reg['origin'] ?? '-') ?>
                        </td>
                        <td class="px-3 py-2.5">
                            <?php 
                            $status = $reg['status'] ?? 'pending_supervisor';
                            $statusConfig = [
                                'pending_supervisor' => [
                                    'label' => 'Menunggu Approval Dosen',
                                    'icon' => '⏱️',
                                    'bg' => 'bg-amber-100',
                                    'text' => 'text-amber-700',
                                    'border' => 'border-amber-200'
                                ],
                                'pending_lab_head' => [
                                    'label' => 'Menunggu Approval Ketua Lab',
                                    'icon' => '✓',
                                    'bg' => 'bg-blue-100',
                                    'text' => 'text-blue-700',
                                    'border' => 'border-blue-200'
                                ],
                                'approved' => [
                                    'label' => 'Disetujui - Member Aktif',
                                    'icon' => '✓✓',
                                    'bg' => 'bg-emerald-100',
                                    'text' => 'text-emerald-700',
                                    'border' => 'border-emerald-200'
                                ],
                                'rejected_supervisor' => [
                                    'label' => 'Ditolak Dosen',
                                    'icon' => '✗',
                                    'bg' => 'bg-red-100',
                                    'text' => 'text-red-700',
                                    'border' => 'border-red-200'
                                ],
                                'rejected_lab_head' => [
                                    'label' => 'Ditolak Ketua Lab',
                                    'icon' => '✗',
                                    'bg' => 'bg-red-100',
                                    'text' => 'text-red-700',
                                    'border' => 'border-red-200'
                                ]
                            ];
                            
                            $config = $statusConfig[$status] ?? $statusConfig['pending_supervisor'];
                            ?>
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium border <?= $config['bg'] ?> <?= $config['text'] ?> <?= $config['border'] ?>">
                                <span><?= $config['icon'] ?></span>
                                <span class="hidden sm:inline"><?= $config['label'] ?></span>
                            </span>
                        </td>
                        <td class="px-3 py-2.5">
                            <div class="flex items-center justify-center gap-1">
                                <!-- Lihat Detail -->
                                <a href="index.php?page=admin-registrations&action=view&id=<?= $reg['id'] ?>" 
                                   class="inline-flex items-center justify-center w-7 h-7 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded transition-colors"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                
                                <?php if ($status === 'pending_supervisor' || $status === 'pending_lab_head'): ?>
                                <!-- Approve -->
                                <a href="index.php?page=admin-registrations&action=approve&id=<?= $reg['id'] ?>" 
                                   onclick="return confirm('Approve pendaftar ini?')"
                                   class="inline-flex items-center justify-center w-7 h-7 bg-green-100 hover:bg-green-200 text-green-700 rounded transition-colors"
                                   title="Approve">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </a>
                                
                                <!-- Reject -->
                                <a href="index.php?page=admin-registrations&action=reject&id=<?= $reg['id'] ?>" 
                                   onclick="return confirm('Tolak pendaftar ini?')"
                                   class="inline-flex items-center justify-center w-7 h-7 bg-red-100 hover:bg-red-200 text-red-700 rounded transition-colors"
                                   title="Tolak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
</div>

<!-- Info Card - Alur Approval -->
<div class="mt-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <div class="flex-1">
            <h4 class="text-sm font-bold text-blue-900 mb-2">🔄 Alur Approval Bertingkat</h4>
            <div class="space-y-2">
                <!-- Step 1 -->
                <div class="flex items-start gap-2">
                    <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center flex-shrink-0 text-xs font-bold">1</div>
                    <div>
                        <p class="text-xs font-semibold text-slate-800">Mahasiswa Mendaftar</p>
                        <p class="text-xs text-slate-600">Mengisi form + pilih dosen pengampu → Status: <strong class="text-amber-700">Menunggu Approval Dosen</strong></p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="flex items-start gap-2">
                    <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center flex-shrink-0 text-xs font-bold">2</div>
                    <div>
                        <p class="text-xs font-semibold text-slate-800">Dosen Review & Approve</p>
                        <p class="text-xs text-slate-600">Dosen melihat pendaftar yang pilih dia → Approve → Status: <strong class="text-blue-700">Menunggu Approval Ketua Lab</strong></p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="flex items-start gap-2">
                    <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 text-xs font-bold">3</div>
                    <div>
                        <p class="text-xs font-semibold text-slate-800">Ketua Lab Final Approval</p>
                        <p class="text-xs text-slate-600">Ketua Lab review yang sudah lolos dosen → Approve → Status: <strong class="text-emerald-700">Member Aktif</strong> ✓</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-3 pt-3 border-t border-blue-200">
                <p class="text-xs text-blue-900"><strong>Note:</strong> Jika ditolak di salah satu tahap, status berubah menjadi "Ditolak" dan email notifikasi otomatis terkirim.</p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = "Approve Pendaftar";
include __DIR__ . "/../../layouts/admin.php";
?>

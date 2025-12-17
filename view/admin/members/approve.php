<?php 
/**
 * View Approval Member
 * 
 * Halaman ini menampilkan daftar pendaftar baru yang menunggu persetujuan.
 * Menggunakan sistem approval bertingkat (Dosen -> Ketua Lab).
 * 
 * @package View
 * @subpackage Admin/Members
 */

ob_start(); 

// Cek hak akses approval
$userRole = $_SESSION['user']['role'] ?? 'member';
$canApprove = ($userRole === 'dosen' || $userRole === 'ketua_lab');
?>

<!-- Alert Feedback -->
<?php if (isset($_SESSION['success'])): ?>
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center shadow-sm animate-fade-in-down">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
    <p class="text-sm font-medium"><?= $_SESSION['success'] ?></p>
</div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center shadow-sm animate-fade-in-down">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
    <p class="text-sm font-medium"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); endif; ?>


<!-- Grid Layout Utama -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Daftar Pendaftar (Lebih Lebar) -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Tabel Card -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800">Daftar Pendaftar Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Menampilkan pendaftar yang perlu review</p>
                </div>
                <!-- Badge Count -->
                <span class="inline-flex items-center justify-center px-2.5 py-0.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">
                    <?= count($registrations ?? []) ?> Pending
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-5 py-3 text-center">#</th>
                            <th class="px-5 py-3">Nama Pendaftar</th>
                            <th class="px-5 py-3 hidden md:table-cell">Judul Riset</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($registrations)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-sm font-medium">Tidak ada pendaftaran pending.</p>
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($registrations as $index => $reg): ?>
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-5 py-4 text-center text-xs text-slate-500"><?= $index + 1 ?></td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                            <?= strtoupper(substr($reg['name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800 text-sm"><?= htmlspecialchars($reg['name']) ?></p>
                                            <p class="text-xs text-slate-500"><?= htmlspecialchars($reg['email']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell">
                                    <p class="text-xs text-slate-600 line-clamp-2 max-w-[200px]" title="<?= htmlspecialchars($reg['research_title']) ?>">
                                        <?= htmlspecialchars($reg['research_title'] ?? '-') ?>
                                    </p>
                                </td>
                                <td class="px-5 py-4">
                                    <?php 
                                    $statusKeys = [
                                        'pending_supervisor' => ['bg'=>'bg-amber-100', 'text'=>'text-amber-700', 'label'=>'Menunggu Dosen'],
                                        'pending_lab_head'   => ['bg'=>'bg-blue-100', 'text'=>'text-blue-700', 'label'=>'Menunggu Ka.Lab'],
                                    ];
                                    $currStatus = $reg['status'] ?? 'pending_supervisor';
                                    $s = $statusKeys[$currStatus] ?? ['bg'=>'bg-gray-100', 'text'=>'text-gray-600', 'label'=>$currStatus];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?= $s['bg'] ?> <?= $s['text'] ?>">
                                        <?= $s['label'] ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Detail Button -->
                                        <a href="index.php?page=admin-registrations&action=view&id=<?= $reg['id'] ?>" 
                                           class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>

                                        <?php if ($canApprove): ?>
                                            <!-- Approve -->
                                            <a href="index.php?page=admin-registrations&action=approve&id=<?= $reg['id'] ?>" onclick="return confirm('Setujui pendaftar ini?')"
                                               class="p-1.5 text-slate-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Setujui">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </a>
                                            <!-- Reject -->
                                            <a href="index.php?page=admin-registrations&action=reject&id=<?= $reg['id'] ?>" onclick="return confirm('Tolak pendaftar ini?')"
                                               class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Kolom Kanan: Info Panel -->
    <div class="space-y-6">
        
        <!-- Info Khusus Role -->
        <?php if ($userRole === 'admin'): ?>
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5 shadow-sm">
            <h4 class="flex items-center text-indigo-900 font-bold mb-3">
                <span class="text-xl mr-2">ℹ️</span> Informasi Admin
            </h4>
            <p class="text-sm text-indigo-800 leading-relaxed mb-3">
                Anda login sebagai <strong>Administrator</strong>. Anda memiliki akses untuk melihat seluruh proses, namun tidak memiliki wewenang untuk melakukan approval langsung.
            </p>
            <div class="text-xs text-indigo-700 bg-white/50 p-2 rounded border border-indigo-100">
                Persetujuan dilakukan berjenjang oleh <strong>Dosen Pembimbing</strong> kemudian <strong>Ketua Lab</strong>.
            </div>
        </div>
        <?php endif; ?>

        <!-- Alur Approval Legend -->
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <h4 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Alur Pendaftaran</h4>
            
            <div class="relative pl-4 border-l-2 border-slate-200 space-y-6">
                <!-- Step 1 -->
                <div class="relative">
                    <span class="absolute -left-[21px] top-0 w-4 h-4 rounded-full bg-slate-200 border-2 border-white"></span>
                    <h5 class="text-sm font-semibold text-slate-700">1. Registrasi Online</h5>
                    <p class="text-xs text-slate-500 mt-1">Mahasiswa mengisi form dan memilih dosen pembimbing.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <span class="absolute -left-[21px] top-0 w-4 h-4 rounded-full bg-amber-400 border-2 border-white ring-2 ring-amber-100"></span>
                    <h5 class="text-sm font-semibold text-slate-700">2. Review Dosen</h5>
                    <p class="text-xs text-slate-500 mt-1">Dosen memverifikasi judul dan kesediaan membimbing.</p>
                    <span class="inline-block mt-1 px-1.5 py-0.5 bg-amber-100 text-amber-700 text-[10px] rounded font-medium">Pending Dosen</span>
                </div>

                <!-- Step 3 -->
                <div class="relative">
                    <span class="absolute -left-[21px] top-0 w-4 h-4 rounded-full bg-blue-500 border-2 border-white"></span>
                    <h5 class="text-sm font-semibold text-slate-700">3. Review Ketua Lab</h5>
                    <p class="text-xs text-slate-500 mt-1">Final check administrasi oleh Ketua Lab.</p>
                    <span class="inline-block mt-1 px-1.5 py-0.5 bg-blue-100 text-blue-700 text-[10px] rounded font-medium">Pending Ka.Lab</span>
                </div>

                <!-- Step 4 -->
                <div class="relative">
                    <span class="absolute -left-[21px] top-0 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white"></span>
                    <h5 class="text-sm font-semibold text-slate-700">4. Resmi Bergabung</h5>
                    <p class="text-xs text-slate-500 mt-1">Akun aktif dan member dapat login.</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php 
$content = ob_get_clean(); 
$title = "Approval Pendaftar";
include __DIR__ . "/../../layouts/admin.php"; 
?>

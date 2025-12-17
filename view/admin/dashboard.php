<?php 
/**
 * View Dashboard Admin
 * 
 * Halaman utama dashboard untuk administrator, dosen, dan ketua lab.
 * Menampilkan statistik ringkas (KPI) dan widget aktivitas terkini
 * yang disesuaikan dengan role user yang sedang login.
 * 
 * @package View
 * @subpackage Admin
 */

ob_start(); 

// Ambil Informasi Role & User
$userRole = $_SESSION['user']['role'] ?? $_SESSION['role'] ?? 'member';
$userName = $_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'User';
?>

<!-- Container Utama -->
<div class="space-y-6 animate-fade-in-down"> 
    
    <!-- Bagian 1: Banner Selamat Datang -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-8 text-white shadow-xl">
        <!-- Dekorasi Background -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-500 opacity-10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2 tracking-tight">
                <?php
                switch($userRole) {
                    case 'admin':
                        echo "Control Panel Admin";
                        break;
                    case 'ketua_lab':
                        echo "Dashboard Ketua Lab";
                        break;
                    case 'dosen':
                        echo "Dashboard Dosen";
                        break;
                    default:
                        echo "Dashboard";
                }
                ?>
            </h1>
            <p class="text-slate-300 text-lg">
                Selamat datang kembali, <span class="text-white font-semibold border-b-2 border-blue-500 pb-0.5"><?= htmlspecialchars($userName) ?></span>.
            </p>
        </div>
    </div>

    <!-- Bagian 2: Kartu Statistik (KPI) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        
        <?php if ($userRole === 'admin'): ?>
            <!-- === TAMPILAN KHUSUS ADMIN === -->
            
            <!-- Card: Total Pengguna -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Users</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalUsers ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> System Active
                </div>
            </div>
            
            <!-- Card: Pendaftar Pending -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Registrasi Pending</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= count($pendingRegistrations ?? []) ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-orange-600 font-medium">
                    Menunggu Approval
                </div>
            </div>
            
            <!-- Card: Member Aktif -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Member Aktif</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalMemberAktif ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-emerald-600 font-medium">
                    + Terverifikasi
                </div>
            </div>
            
            <!-- Card: Inventaris -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Inventaris</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalEquipment ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-slate-400">
                    Peralatan Lab
                </div>
            </div>
        
        <?php elseif ($userRole === 'ketua_lab'): ?>
            <!-- === TAMPILAN KHUSUS KETUA LAB === -->
            
            <!-- Card: Registrasi Perlu Review -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Perlu Approval</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= count($pendingRegistrations ?? []) ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-red-600 font-medium">
                    Status: Pending Final
                </div>
            </div>

            <!-- Card: Member Aktif -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Member</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalMemberAktif ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-blue-600 font-medium">
                    Aktif di Lab
                </div>
            </div>

            <!-- Card: Riset Berjalan -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Riset Berjalan</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalRiset ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-emerald-600 font-medium">
                    Status: Active
                </div>
            </div>

            <!-- Card: Alumni -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Alumni Lab</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalAlumni ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-slate-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-slate-500">
                    Lulusan
                </div>
            </div>

        <?php elseif ($userRole === 'dosen'): ?>
            <!-- === TAMPILAN KHUSUS DOSEN === -->
            
            <!-- Card: Bimbingan Baru -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Permintaan Bimbingan</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= count($pendingRegistrations ?? []) ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-orange-600 font-medium">
                    Mahasiswa Baru
                </div>
            </div>

            <!-- Card: Total Bimbingan -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Mahasiswa Bimbingan</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalMemberAktif ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-blue-600 font-medium">
                    Aktif
                </div>
            </div>

            <!-- Card: Proyek Riset -->
            <div class="bg-white rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Proyek Riset</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $totalRiset ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center text-xs text-indigo-600 font-medium">
                    Dalam Pengerjaan
                </div>
            </div>
            
        <?php endif; ?>

    </div>

    <!-- Bagian 3: Tabel Aktivitas & Widget -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Widget: Pendaftaran Terbaru (Tabel) -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm md:text-base">
                        <?php
                        if ($userRole === 'admin') echo 'Registrasi Terbaru';
                        elseif ($userRole === 'ketua_lab') echo 'Persetujuan Diperlukan';
                        else echo 'Permintaan Bimbingan Terbaru';
                        ?>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar calon member yang belum diverifikasi</p>
                </div>
                <!-- Badge Counter -->
                <?php if(!empty($pendingRegistrations)): ?>
                    <span class="px-2.5 py-0.5 rounded-full bg-red-100 text-red-600 text-xs font-bold">
                        <?= count($pendingRegistrations) ?> Baru
                    </span>
                <?php endif; ?>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 font-medium border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3">Nama Lengkap</th>
                            <th class="px-6 py-3 hidden md:table-cell">Judul Riset</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($pendingRegistrations)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Tidak ada pendaftaran pending saat ini.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pendingRegistrations as $reg): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 font-medium text-slate-800">
                                    <div class="flex flex-col">
                                        <span><?= htmlspecialchars($reg['name']) ?></span>
                                        <span class="text-xs text-slate-400 font-normal"><?= htmlspecialchars($reg['email']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-slate-600 hidden md:table-cell truncate max-w-xs">
                                    <?= htmlspecialchars($reg['research_title'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-3">
                                    <!-- Badge Status -->
                                    <?php 
                                    $statusLabels = [
                                        'pending_supervisor' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Review Dosen'],
                                        'pending_lab_head'   => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Review Ka.Lab']
                                    ];
                                    $currStatus = $reg['status'] ?? 'pending_supervisor';
                                    $badge = $statusLabels[$currStatus] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'label' => $currStatus];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badge['bg'] ?> <?= $badge['text'] ?>">
                                        <?= $badge['label'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <a href="index.php?page=admin-registrations&action=view&id=<?= $reg['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium text-xs hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="bg-slate-50 px-6 py-3 border-t border-slate-200">
                <a href="index.php?page=admin-registrations" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1 group">
                    Lihat Semua Pendaftar
                    <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>
        </div>

        <!-- Widget: Berita / Quick Links -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-800 text-white flex justify-between items-center">
                <h3 class="font-bold text-sm md:text-base">Berita Internal</h3>
                <span class="text-xs text-slate-300">Terbaru</span>
            </div>
            
            <div class="p-4 flex-1 overflow-y-auto max-h-[400px]">
                <?php if (empty($latestNews)): ?>
                    <div class="text-center py-8 text-slate-400">
                         <p class="text-sm">Belum ada berita dipublikasikan.</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($latestNews as $news): ?>
                        <div class="group cursor-pointer">
                            <p class="text-xs text-slate-400 mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <?= date('d M Y', strtotime($news['created_at'])) ?>
                            </p>
                            <h4 class="text-sm font-semibold text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-2">
                                <?= htmlspecialchars($news['title']) ?>
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                <?= htmlspecialchars(strip_tags($news['content'] ?? '')) ?>
                            </p>
                            <div class="border-b border-slate-100 mt-3"></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 mt-auto">
                <a href="index.php?page=admin-news" class="text-xs font-semibold text-slate-600 hover:text-slate-800 flex items-center justify-center gap-1">
                    Kelola Berita Lab
                </a>
            </div>
        </div>

    </div>

</div>

<?php 
$content = ob_get_clean(); 
$title = "Dashboard Admin";
include __DIR__ . "/../layouts/admin.php"; 
?>

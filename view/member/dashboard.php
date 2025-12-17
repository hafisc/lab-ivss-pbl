<?php 
/**
 * View Dashboard Member
 * 
 * Halaman utama (dashboard) untuk member yang menampilkan ringkasan aktivitas,
 * statistik riset, dan informasi penting lainnya.
 * 
 * @package View
 * @subpackage Member
 */

ob_start();

// Mengambil data user dari session dengan fallback
$userName = $_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'Member';
$userNIM = $_SESSION['user']['nim'] ?? $_SESSION['nim'] ?? '-';
$userAngkatan = $_SESSION['user']['angkatan'] ?? $_SESSION['angkatan'] ?? '-';
?>

<!-- Bagian: Banner Selamat Datang -->
<div class="mb-6 bg-gradient-to-r from-blue-900 to-blue-800 rounded-xl p-6 text-white shadow-lg">
    <div class="flex items-start justify-between">
        <div>
            <!-- Sapaan Personal -->
            <h1 class="text-2xl font-bold mb-2">👋 Halo, <?= htmlspecialchars(explode(' ', $userName)[0]) ?>!</h1>
            <p class="text-blue-100 text-sm mb-1">Selamat datang di Dashboard Member Lab IVSS</p>
            
            <!-- Info Singkat User -->
            <div class="flex items-center gap-4 text-xs text-blue-200 mt-3">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                    </svg>
                    NIM: <?= htmlspecialchars($userNIM) ?>
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Angkatan <?= htmlspecialchars($userAngkatan) ?>
                </span>
            </div>
        </div>
        
        <!-- Avatar Inisial (Hidden pada mobile) -->
        <div class="hidden md:block">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <span class="text-2xl font-bold"><?= strtoupper(substr($userName, 0, 1)) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Bagian: Statistik Card -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    
    <!-- Statistik 1: Riset yang Diikuti -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Active</span>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalMyResearch ?? 0 ?></h3>
        <p class="text-xs text-slate-600 font-medium">Riset yang Diikuti</p>
    </div>
    
    <!-- Statistik 2: Publikasi Saya -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full">Total</span>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalMyPublications ?? 0 ?></h3>
        <p class="text-xs text-slate-600 font-medium">Publikasi Saya</p>
    </div>
    
    <!-- Statistik 3: Status Member -->
    <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300 group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Verified</span>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-0.5 capitalize"><?= $currentMemberStatus ?? 'Aktif' ?></h3>
        <p class="text-xs text-slate-600 font-medium">Status Keanggotaan</p>
    </div>
    
</div>

<!-- Grid Layout Utama -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    <!-- Kolom Kiri: Info Utama (Riset & Pembimbing) -->
    <div class="lg:col-span-2 space-y-4">
        
        <!-- Info Dosen Pembimbing -->
        <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
            <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Dosen Pembimbing
                </h3>
            </div>
            <div class="p-4">
                <?php if (isset($supervisorInfo) && $supervisorInfo): ?>
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-lg font-bold text-blue-600"><?= strtoupper(substr($supervisorInfo['name'] ?? 'D', 0, 1)) ?></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($supervisorInfo['name'] ?? '-') ?></h4>
                            <p class="text-xs text-slate-500 mt-0.5"><?= htmlspecialchars($supervisorInfo['email'] ?? '-') ?></p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-2 py-1 bg-green-50 text-green-700 text-xs rounded-md font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approved
                                </span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-slate-500">Belum ada pembimbing</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Tabel Riset yang Diikuti -->
        <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
            <div class="px-4 py-3 bg-gradient-to-r from-slate-50 to-white border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Riset yang Diikuti
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar riset aktif kamu</p>
                    </div>
                    <a href="index.php?page=member-research" class="text-xs text-blue-600 hover:text-blue-700 font-medium hover:underline">Lihat Semua →</a>
                </div>
            </div>
        
        <!-- Tabel Scrollable -->
        <div class="overflow-x-auto">
            <?php if (empty($myResearches)): ?>
                <!-- Empty State jika tidak ada riset -->
                <div class="p-6 text-center">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-1">Belum Ada Riset</h4>
                    <p class="text-xs text-slate-500">Kamu belum terdaftar di riset manapun</p>
                </div>
            <?php else: ?>
                <!-- Tabel Daftar Riset -->
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs">Judul Riset</th>
                            <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden md:table-cell">Kategori</th>
                            <th class="text-left px-3 py-2 font-medium text-slate-600 text-xs hidden sm:table-cell">Leader</th>
                            <th class="text-center px-3 py-2 font-medium text-slate-600 text-xs">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php foreach ($myResearches as $research): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-3 py-2 text-slate-800 font-medium text-xs"><?= htmlspecialchars($research['title']) ?></td>
                            <td class="px-3 py-2 text-slate-600 hidden md:table-cell">
                                <span class="inline-block px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs rounded-full font-medium">
                                    <?= htmlspecialchars($research['category'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="px-3 py-2 text-slate-600 hidden sm:table-cell text-xs"><?= htmlspecialchars($research['leader_name'] ?? '-') ?></td>
                            <td class="px-3 py-2 text-center">
                                <?php if ($research['status'] === 'active'): ?>
                                    <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-medium rounded-full">Active</span>
                                <?php else: ?>
                                    <span class="inline-block px-2 py-0.5 bg-slate-100 text-slate-700 text-xs font-medium rounded-full">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        </div>
    
    </div>
    
    <!-- Kolom Kanan: Quick Links & Aktivitas -->
    <div class="space-y-4">
        
        <!-- Panel Aksi Cepat -->
        <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
            <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-slate-200">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Aksi Cepat
                </h3>
            </div>
            
            <div class="p-3 space-y-2">
                <!-- Link: Kelola Riset Saya -->
                <a href="index.php?page=member-research" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors group">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">Riset Saya</p>
                        <p class="text-xs text-slate-500">Kelola riset</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <!-- Link: Kelola Publikasi -->
                <a href="index.php?page=member-publications" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors group">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-purple-200 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">Publikasi</p>
                        <p class="text-xs text-slate-500">Paper & jurnal</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <!-- Link: Profil Saya -->
                <a href="index.php?page=member-profile" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors group">
                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-slate-200 transition-colors">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">Profil Saya</p>
                        <p class="text-xs text-slate-500">Edit profil</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <!-- Link: Berita & Event -->
                <a href="index.php?page=member-news" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 transition-colors group">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-orange-200 transition-colors">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">Berita & Event</p>
                        <p class="text-xs text-slate-500">Info terbaru</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-orange-600 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    
</div>

<?php
// Mengakhiri buffer output dan memuat layout utama
$content = ob_get_clean();
$title = "Dashboard Member";
include __DIR__ . "/../layouts/member.php";
?>

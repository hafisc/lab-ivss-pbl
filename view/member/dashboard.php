<?php ob_start(); ?>

<!-- Welcome Banner -->
<!-- <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl p-8 mb-8 overflow-hidden shadow-xl">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="relative flex items-center justify-between">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Selamat Datang, <?= explode(' ', $_SESSION['name'] ?? 'Member')[0] ?>! 👋</h1>
            <p class="text-blue-100">Mari produktif hari ini di Lab IVSS</p>
        </div>
        <div class="hidden md:block">
            <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>
</div> -->

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    
    <!-- Card 1: Riset -->
    <div class="group relative bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl p-4 text-white overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-3xl font-bold mb-1.5"><?= $totalMyResearch ?? 0 ?></h3>
            <p class="text-blue-50 text-xs font-medium">Riset yang Kamu Ikuti</p>
        </div>
    </div>
    
    <!-- Card 2: Dokumen -->
    <div class="group relative bg-gradient-to-br from-violet-600 to-purple-600 rounded-xl p-4 text-white overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-3xl font-bold mb-1.5"><?= $totalMyUploads ?? 0 ?></h3>
            <p class="text-purple-50 text-xs font-medium">Dokumen Terupload</p>
        </div>
    </div>
    
    <!-- Card 3: Status -->
    <div class="group relative bg-gradient-to-br from-teal-600 to-cyan-600 rounded-xl p-4 text-white overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <svg class="w-5 h-5 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </div>
            <h3 class="text-3xl font-bold mb-1.5 capitalize"><?= $currentMemberStatus ?? 'Aktif' ?></h3>
            <p class="text-teal-50 text-xs font-medium">Status Keanggotaan</p>
        </div>
    </div>
    
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    <!-- Riset Kamu -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden border border-slate-100">
        <div class="bg-gradient-to-r from-slate-50 to-white p-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Riset Kamu
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar riset yang sedang kamu ikuti</p>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <?php if (empty($myResearches)): ?>
                <!-- Empty State -->
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-semibold text-slate-700 mb-1.5">Belum Ada Riset</h4>
                    <p class="text-xs text-slate-500 mb-3">Kamu belum terdaftar di riset manapun</p>
                    <a href="#" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Jelajahi Riset
                    </a>
                </div>
            <?php else: ?>
                <!-- Table -->
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
    
    <!-- Aksi Cepat -->
    <div class="space-y-4">
        <!-- Quick Actions Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-100">
            <div class="bg-gradient-to-r from-slate-50 to-white p-4 border-b border-slate-200">
                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Aksi Cepat
                </h3>
                <p class="text-sm text-slate-500 mt-1">Menu yang sering digunakan</p>
            </div>
            
            <div class="p-6 space-y-3">
                <!-- Upload Laporan -->
                <a href="index.php?page=member-upload" class="group relative bg-gradient-to-r from-blue-600 to-indigo-600 p-4 rounded-xl text-white overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 block">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative flex items-center gap-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0 backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold">Upload Laporan</p>
                            <p class="text-xs text-blue-50">Upload dokumen riset kamu</p>
                        </div>
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Lihat Absensi -->
                <a href="index.php?page=member-attendance" class="group relative bg-gradient-to-r from-violet-600 to-purple-600 p-4 rounded-xl text-white overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 block">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative flex items-center gap-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0 backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold">Lihat Absensi</p>
                            <p class="text-xs text-purple-50">Riwayat kehadiran kamu</p>
                        </div>
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
                
                <!-- Edit Profil -->
                <a href="index.php?page=member-profile" class="group relative bg-gradient-to-r from-teal-600 to-cyan-600 p-4 rounded-xl text-white overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 block">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-12 -mt-12"></div>
                    <div class="relative flex items-center gap-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0 backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold">Edit Profil</p>
                            <p class="text-xs text-teal-50">Ubah data diri kamu</p>
                        </div>
                        <svg class="w-5 h-5 opacity-70 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
</div>

<?php
$content = ob_get_clean();
$title = "Dashboard Member";
include __DIR__ . "/../layouts/member.php";
?>

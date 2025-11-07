<?php 
ob_start(); 

// Get user role untuk customize dashboard
$userRole = $_SESSION['user']['role'] ?? $_SESSION['role'] ?? 'member';
$userName = $_SESSION['user']['name'] ?? $_SESSION['name'] ?? 'User';
?>

<div class="max-w-7xl mx-auto">
    
    <!-- Welcome Message based on Role -->
    <div class="mb-6 bg-gradient-to-r from-blue-900 to-blue-800 rounded-xl p-6 text-white shadow-lg">
        <h1 class="text-2xl font-bold mb-2">
            <?php
            switch($userRole) {
                case 'admin':
                    echo "🎛️ Admin Dashboard";
                    break;
                case 'ketua_lab':
                    echo "👔 Dashboard Ketua Lab";
                    break;
                case 'dosen':
                    echo "👨‍🏫 Dashboard Dosen";
                    break;
                default:
                    echo "📊 Dashboard";
            }
            ?>
        </h1>
        <p class="text-blue-100">Selamat datang, <span class="font-semibold"><?= htmlspecialchars($userName) ?></span></p>
    </div>

<!-- Statistics Cards - Customize by Role -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
    
    <?php if ($userRole === 'admin'): ?>
        <!-- ADMIN: Semua Statistik -->
        
        <!-- Total Member Aktif -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">+12%</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalMemberAktif ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Total Member Aktif</p>
        </div>
        
        <!-- Alumni / Mantan -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">All Time</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalAlumni ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Alumni / Mantan</p>
        </div>
        
        <!-- Riset Berjalan -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-800 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">Active</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalRiset ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Riset Berjalan</p>
        </div>
        
        <!-- Berita Dipublikasikan -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-700 bg-blue-100 px-2.5 py-1 rounded-full">Live</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalNews ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Berita Dipublikasikan</p>
        </div>
    
    <?php elseif ($userRole === 'ketua_lab'): ?>
        <!-- KETUA LAB: Fokus Monitoring & Approval -->
        
        <!-- Pendaftar Menunggu Approval -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">Pending</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= count($pendingRegistrations ?? []) ?></h3>
            <p class="text-xs text-slate-600 font-medium">Menunggu Approval</p>
        </div>
        
        <!-- Total Member Aktif -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Active</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalMemberAktif ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Member Aktif</p>
        </div>
        
        <!-- Riset Aktif -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-800 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">Running</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalRiset ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Riset Aktif</p>
        </div>
        
        <!-- Alumni -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalAlumni ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Total Alumni</p>
        </div>
    
    <?php elseif ($userRole === 'dosen'): ?>
        <!-- DOSEN: Fokus Bimbingan -->
        
        <!-- Pendaftar Baru (yang pilih dia) -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full">New</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= count($pendingRegistrations ?? []) ?></h3>
            <p class="text-xs text-slate-600 font-medium">Pendaftar Baru</p>
        </div>
        
        <!-- Mahasiswa Bimbingan (dummy - nanti dari query) -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Active</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalMemberAktif ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Mahasiswa Bimbingan</p>
        </div>
        
        <!-- Riset Dibimbing -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-800 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">Running</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5"><?= $totalRiset ?? 0 ?></h3>
            <p class="text-xs text-slate-600 font-medium">Riset Dibimbing</p>
        </div>
        
        <!-- Publikasi (dummy) -->
        <div class="bg-white border border-slate-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-0.5">0</h3>
            <p class="text-xs text-slate-600 font-medium">Publikasi</p>
        </div>
    
    <?php endif; ?>
    
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-4">
    
    <!-- Pendaftar Member Baru - Customize by Role -->
    <div class="lg:col-span-2 bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
        <div class="px-4 py-3 <?= $userRole === 'admin' ? 'bg-blue-900' : ($userRole === 'ketua_lab' ? 'bg-orange-600' : 'bg-blue-800') ?>">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-white text-base flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <?php
                        if ($userRole === 'admin') {
                            echo 'Semua Pendaftar Member';
                        } elseif ($userRole === 'ketua_lab') {
                            echo 'Menunggu Approval Anda';
                        } else {
                            echo 'Pendaftar Memilih Anda';
                        }
                        ?>
                    </h3>
                    <p class="text-xs text-blue-100 mt-0.5">
                        <?php
                        if ($userRole === 'admin') {
                            echo 'Overview seluruh pendaftar';
                        } elseif ($userRole === 'ketua_lab') {
                            echo 'Status: pending_lab_head - butuh final approval';
                        } else {
                            echo 'Status: pending_supervisor - butuh review dosen';
                        }
                        ?>
                    </p>
                </div>
                <div class="<?= $userRole === 'ketua_lab' ? 'bg-red-600' : 'bg-red-500' ?> text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow">
                    <?= count($pendingRegistrations ?? []) ?> Pending
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <?php if (empty($pendingRegistrations)): ?>
                <div class="p-6 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-xs text-slate-500">Tidak ada pendaftar baru.</p>
                </div>
            <?php else: ?>
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-4 py-2 font-semibold text-slate-700 text-xs">Nama</th>
                            <th class="text-left px-4 py-2 font-semibold text-slate-700 text-xs hidden md:table-cell">Judul Penelitian</th>
                            <th class="text-left px-4 py-2 font-semibold text-slate-700 text-xs hidden lg:table-cell">Asal</th>
                            <th class="text-left px-4 py-2 font-semibold text-slate-700 text-xs">Status Approval</th>
                            <th class="text-center px-4 py-2 font-semibold text-slate-700 text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php foreach ($pendingRegistrations as $reg): ?>
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-4 py-2.5">
                                <div class="text-slate-900 font-medium text-sm"><?= htmlspecialchars($reg['name']) ?></div>
                                <div class="text-slate-500 text-xs"><?= htmlspecialchars($reg['email']) ?></div>
                            </td>
                            <td class="px-4 py-2.5 text-slate-600 text-xs hidden md:table-cell">
                                <?= htmlspecialchars($reg['research_title'] ?? '-') ?>
                            </td>
                            <td class="px-4 py-2.5 text-slate-600 text-xs hidden lg:table-cell"><?= htmlspecialchars($reg['origin'] ?? '-') ?></td>
                            
                            <td class="px-4 py-2.5">
                                <?php 
                                $status = $reg['status'] ?? 'pending_supervisor';
                                $statusConfig = [
                                    'pending_supervisor' => [
                                        'label' => 'Menunggu Approval Dosen',
                                        'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>',
                                        'bg' => 'bg-amber-100',
                                        'text' => 'text-amber-700',
                                        'border' => 'border-amber-200'
                                    ],
                                    'pending_lab_head' => [
                                        'label' => 'Menunggu Approval Ketua Lab',
                                        'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                                        'bg' => 'bg-blue-100',
                                        'text' => 'text-blue-700',
                                        'border' => 'border-blue-200'
                                    ],
                                    'approved' => [
                                        'label' => 'Disetujui - Member Aktif',
                                        'icon' => '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                                        'bg' => 'bg-emerald-100',
                                        'text' => 'text-emerald-700',
                                        'border' => 'border-emerald-200'
                                    ]
                                ];
                                
                                $config = $statusConfig[$status] ?? $statusConfig['pending_supervisor'];
                                ?>
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium border <?= $config['bg'] ?> <?= $config['text'] ?> <?= $config['border'] ?>">
                                        <?= $config['icon'] ?>
                                        <span class="hidden sm:inline"><?= $config['label'] ?></span>
                                        <span class="sm:hidden">
                                            <?php if ($status === 'pending_supervisor'): ?>
                                                Dosen
                                            <?php elseif ($status === 'pending_lab_head'): ?>
                                                Ketua Lab
                                            <?php else: ?>
                                                Disetujui
                                            <?php endif; ?>
                                        </span>
                                    </span>
                                </div>
                            </td>
                            
                            <td class="px-4 py-2.5">
                                <div class="flex gap-1.5 justify-center">
                                    <a href="index.php?page=admin-registrations&action=view&id=<?= $reg['id'] ?>" 
                                       class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded transition-colors">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <!-- Footer dengan tombol Lihat Semua (selalu tampil) -->
        <div class="p-3 border-t border-slate-200 bg-blue-50 text-center">
            <a href="index.php?page=admin-registrations" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-900 hover:text-blue-800 group">
                Lihat Semua Pendaftar 
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
    
    <!-- Berita Terbaru -->
    <div class="bg-white rounded-xl overflow-hidden border border-slate-200 shadow-sm">
        <div class="px-4 py-3 bg-slate-800">
            <h3 class="font-bold text-white text-base flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                Berita Terbaru
            </h3>
            <p class="text-xs text-slate-300 mt-0.5">Publikasi terkini</p>
        </div>
        
        <div class="p-4">
            <?php if (empty($latestNews)): ?>
                <div class="text-center py-6">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-500">Belum ada berita</p>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php foreach ($latestNews as $news): ?>
                    <div class="pb-3 border-b border-slate-200 last:border-0 last:pb-0 hover:bg-slate-50 p-2 rounded transition-colors">
                        <h4 class="text-xs font-semibold text-slate-900 mb-1 line-clamp-2 hover:text-blue-900 cursor-pointer transition-colors">
                            <?= htmlspecialchars($news['title']) ?>
                        </h4>
                        <p class="text-xs text-slate-500">
                            📅 <?= date('d M Y', strtotime($news['created_at'] ?? 'now')) ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($latestNews)): ?>
        <div class="p-3 border-t border-slate-200 bg-slate-50 text-center">
            <a href="index.php?page=admin-news" class="text-xs text-blue-900 hover:text-blue-800 font-semibold inline-flex items-center gap-1">
                Kelola Berita 
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <?php endif; ?>
    </div>
    
</div>

</div>

<?php
$content = ob_get_clean();
$title = "Dashboard Admin";
include __DIR__ . "/../layouts/admin.php";
?>

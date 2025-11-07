<?php ob_start(); ?>

<div class="max-w-6xl mx-auto">
    
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="text-lg font-bold text-slate-900">Riwayat Absensi</h1>
        <p class="text-slate-600 text-xs mt-0.5">Daftar kehadiran kamu di Lab IVSS</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- Total Hadir -->
        <div class="bg-white rounded-lg shadow border border-slate-200 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-600 mb-0.5">Total Kehadiran</p>
                    <h3 class="text-2xl font-bold text-blue-900"><?= count($myAttendances ?? []) ?></h3>
                </div>
                <div class="w-12 h-12 bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Bulan Ini -->
        <div class="bg-white rounded-lg shadow border border-slate-200 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-600 mb-0.5">Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-blue-800">
                        <?php
                        $thisMonth = count(array_filter($myAttendances ?? [], function($att) {
                            return date('Y-m', strtotime($att['date'])) === date('Y-m');
                        }));
                        echo $thisMonth;
                        ?>
                    </h3>
                </div>
                <div class="w-12 h-12 bg-blue-800 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Terakhir -->
        <div class="bg-white rounded-lg shadow border border-slate-200 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-600 mb-0.5">Absen Terakhir</p>
                    <h3 class="text-base font-bold text-slate-900">
                        <?php
                        if (!empty($myAttendances)) {
                            echo date('d M Y', strtotime($myAttendances[0]['date']));
                        } else {
                            echo '-';
                        }
                        ?>
                    </h3>
                </div>
                <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-lg shadow border border-slate-200 overflow-hidden">
        <!-- Table Header -->
        <div class="bg-blue-900 px-4 py-3">
            <h3 class="font-bold text-white text-base">Daftar Absensi</h3>
            <p class="text-xs text-blue-100 mt-0.5">Riwayat kehadiran lengkap</p>
        </div>
        
        <div class="overflow-x-auto">
            <?php if (empty($myAttendances)): ?>
                <!-- Empty State -->
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-slate-700 mb-1.5">Belum Ada Data Absensi</h3>
                    <p class="text-xs text-slate-500">Riwayat kehadiran kamu akan muncul di sini</p>
                </div>
            <?php else: ?>
                <!-- Table -->
                <table class="w-full text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="text-left px-3 py-2 font-semibold text-slate-700 text-xs">#</th>
                            <th class="text-left px-3 py-2 font-semibold text-slate-700 text-xs">Tanggal</th>
                            <th class="text-left px-3 py-2 font-semibold text-slate-700 text-xs hidden sm:table-cell">Waktu</th>
                            <th class="text-left px-3 py-2 font-semibold text-slate-700 text-xs hidden md:table-cell">Metode</th>
                            <th class="text-left px-3 py-2 font-semibold text-slate-700 text-xs hidden lg:table-cell">Lokasi</th>
                            <th class="text-center px-3 py-2 font-semibold text-slate-700 text-xs">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php foreach ($myAttendances as $index => $attendance): ?>
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-3 py-2.5 text-slate-600 font-medium text-xs"><?= $index + 1 ?></td>
                            <td class="px-3 py-2.5 text-slate-900 font-semibold text-xs">
                                <?= date('d M Y', strtotime($attendance['date'])) ?>
                            </td>
                            <td class="px-3 py-2.5 text-slate-700 text-xs hidden sm:table-cell">
                                <?= htmlspecialchars($attendance['time'] ?? '-') ?>
                            </td>
                            <td class="px-3 py-2.5 hidden md:table-cell">
                                <?php
                                $method = $attendance['method'] ?? 'Manual';
                                $methodColor = $method === 'QR Code' ? 'bg-blue-900 text-white' : 'bg-slate-600 text-white';
                                ?>
                                <span class="inline-block px-2 py-0.5 <?= $methodColor ?> text-xs font-medium rounded">
                                    <?= htmlspecialchars($method) ?>
                                </span>
                            </td>
                            <td class="px-3 py-2.5 text-slate-700 text-xs hidden lg:table-cell">
                                <?= htmlspecialchars($attendance['room'] ?? 'Lab IVSS') ?>
                            </td>
                            <td class="px-3 py-2.5 text-center">
                                <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded">
                                    ✓ Hadir
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-blue-900 mb-1.5">ℹ️ Informasi Penting</h4>
                <ul class="text-xs text-blue-800 space-y-1">
                    <li class="flex items-start gap-2">
                        <span class="text-blue-900 font-bold">•</span>
                        <span>Minimal kehadiran <strong>75%</strong> per semester untuk member aktif</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-900 font-bold">•</span>
                        <span>Absensi dilakukan saat datang ke lab atau meeting riset</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-900 font-bold">•</span>
                        <span>Jika ada kendala, hubungi admin atau ketua lab</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
$title = "Riwayat Absensi";
include __DIR__ . "/../layouts/member.php";
?>

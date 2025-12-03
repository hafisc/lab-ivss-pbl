<?php
require_once __DIR__ . '/../../app/controllers/DashboardController.php';

$dashboardController = new DashboardController();
$stats = $dashboardController->index();
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Dashboard Lab IVSS</h1>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm uppercase">Total Research</h3>
            <p class="text-3xl font-bold text-blue-600"><?= $stats['research']['total_research'] ?? 0 ?></p>
            <p class="text-sm text-gray-400">Active: <?= $stats['research']['active_research'] ?? 0 ?></p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm uppercase">Pending Registrations</h3>
            <p class="text-3xl font-bold text-yellow-600"><?= $stats['pending_registrations']['total_pending'] ?? 0 ?></p>
            <p class="text-sm text-gray-400">Needs Approval</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm uppercase">Completed Research</h3>
            <p class="text-3xl font-bold text-green-600"><?= $stats['research']['completed_research'] ?? 0 ?></p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm uppercase">Total Members</h3>
            <p class="text-3xl font-bold text-purple-600"><?= $stats['research']['total_members'] ?? 0 ?></p>
        </div>
    </div>

    <!-- Dosen Performance Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Dosen Performance</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Dosen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa Bimbingan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active Research</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publikasi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (!empty($stats['dosen_performance'])): ?>
                        <?php foreach ($stats['dosen_performance'] as $dosen): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($dosen['nama']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?= $dosen['jumlah_mahasiswa'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $dosen['jumlah_research'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $dosen['jumlah_publikasi'] ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

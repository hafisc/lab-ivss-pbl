<?php

/**
 * View untuk menampilkan daftar dosen
 */

if (!isset($dosen)) {
    $dosen = [];
}

// Calculate statistics
$totalDosen = count($dosen);
$totalMahasiswa = array_sum(array_map(fn($d) => intval($d['jumlah_mahasiswa'] ?? 0), $dosen));
$avgMahasiswa = $totalDosen > 0 ? round($totalMahasiswa / $totalDosen, 1) : 0;
$dosenAktif = count(array_filter($dosen, fn($d) => ($d['status'] ?? '') === 'active'));
?>

<div class="container mx-auto px-4 py-8">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 text-white mb-8">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold mb-2">Daftar Dosen Pengampu</h1>
                <p class="text-blue-100 text-lg">Kelola data dosen Lab IVSS Polinema</p>
            </div>
            <a href="index.php?page=admin-dosen-create" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition inline-flex items-center shadow-md hover:shadow-lg">
                <i class="fas fa-plus-circle mr-2 text-lg"></i>Tambah Dosen Baru
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Dosen -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Total Dosen</p>
                    <p class="text-4xl font-bold text-blue-600 mt-2"><?= $totalDosen ?></p>
                </div>
                <i class="fas fa-graduation-cap text-5xl text-blue-100"></i>
            </div>
        </div>

        <!-- Dosen Aktif -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Dosen Aktif</p>
                    <p class="text-4xl font-bold text-green-600 mt-2"><?= $dosenAktif ?></p>
                </div>
                <i class="fas fa-check-circle text-5xl text-green-100"></i>
            </div>
        </div>

        <!-- Total Mahasiswa -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Total Mahasiswa</p>
                    <p class="text-4xl font-bold text-purple-600 mt-2"><?= $totalMahasiswa ?></p>
                </div>
                <i class="fas fa-users text-5xl text-purple-100"></i>
            </div>
        </div>

        <!-- Rata-rata Mahasiswa -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide">Rata-rata/Dosen</p>
                    <p class="text-4xl font-bold text-orange-600 mt-2"><?= $avgMahasiswa ?></p>
                </div>
                <i class="fas fa-chart-bar text-5xl text-orange-100"></i>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8 sticky top-0 z-10">
        <form method="GET" class="space-y-4">
            <input type="hidden" name="page" value="admin-dosen">

            <!-- Title -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-filter mr-2 text-blue-600"></i>Pencarian & Filter
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search by Name/NIP -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>Cari Dosen (Nama / NIP)
                    </label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                        placeholder="Ketik nama atau NIP dosen..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent hover:border-gray-400 transition">
                </div>

                <!-- Filter by Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-1"></i>Filter Status
                    </label>
                    <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent hover:border-gray-400 transition">
                        <option value="all" <?= ($_GET['status'] ?? 'active') === 'all' ? 'selected' : '' ?>>Semua Status</option>
                        <option value="active" <?= ($_GET['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>✓ Aktif</option>
                        <option value="inactive" <?= ($_GET['status'] ?? 'active') === 'inactive' ? 'selected' : '' ?>>✗ Tidak Aktif</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center shadow-md hover:shadow-lg">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                </div>
            </div>

            <!-- Reset Filter (if any filter is active) -->
            <?php if (!empty($_GET['search']) || ($_GET['status'] ?? 'active') !== 'active'): ?>
                <div class="pt-2 flex justify-end">
                    <a href="index.php?page=admin-dosen" class="text-sm text-gray-600 hover:text-gray-900 underline flex items-center">
                        <i class="fas fa-redo mr-1"></i>Reset Filter
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <!-- Daftar Dosen Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <?php if (empty($dosen)): ?>
            <div class="p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">Tidak ada data dosen yang ditemukan</p>
                <p class="text-gray-400 text-sm mt-2">Coba ubah pencarian atau filter, atau <a href="index.php?page=admin-dosen-create" class="text-blue-600 hover:underline">tambah dosen baru</a></p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 w-12">#</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Nama Dosen</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">NIP</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Asal Institusi</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">
                                <i class="fas fa-users mr-1 text-purple-600"></i>Mahasiswa
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">
                                <i class="fas fa-check-circle mr-1 text-green-600"></i>Status
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">
                                <i class="fas fa-cog mr-1 text-blue-600"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($dosen as $index => $d): ?>
                            <tr class="hover:bg-blue-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 text-sm font-semibold text-gray-600 bg-gray-50 w-12">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full">
                                        <?= $index + 1 ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?= htmlspecialchars($d['nama'] ?? '') ?></div>
                                    <div class="text-xs text-gray-500 flex items-center mt-1">
                                        <i class="fas fa-phone mr-1"></i><?= htmlspecialchars($d['no_hp'] ?? '-') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-mono bg-gray-50"><?= htmlspecialchars($d['nip'] ?? '-') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <i class="fas fa-envelope mr-1 text-blue-500"></i><?= htmlspecialchars($d['email'] ?? '-') ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span class="inline-block max-w-xs truncate" title="<?= htmlspecialchars($d['origin'] ?? '') ?>">
                                        <i class="fas fa-university mr-1 text-purple-500"></i><?= htmlspecialchars(substr($d['origin'] ?? '', 0, 40)) ?>...
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-bold bg-purple-100 text-purple-800 min-w-16">
                                        <i class="fas fa-users mr-1"></i><?= intval($d['jumlah_mahasiswa'] ?? 0) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if (($d['status'] ?? '') === 'active'): ?>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Tidak Aktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center text-sm space-x-2 flex items-center justify-center flex-wrap gap-2">
                                    <a href="index.php?page=admin-dosen-detail&id=<?= $d['dosen_id'] ?? $d['id'] ?>" class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold rounded-lg transition" title="Lihat Detail">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                    <a href="index.php?page=admin-dosen-edit&id=<?= $d['dosen_id'] ?? $d['id'] ?>" class="inline-flex items-center px-3 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 font-semibold rounded-lg transition" title="Edit Data">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary Stats Footer -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-6 border-t-2 border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-white rounded-lg shadow-sm border-l-4 border-blue-500">
                        <p class="text-gray-600 text-sm font-medium uppercase tracking-wider">Ditampilkan</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2"><?= count($dosen) ?></p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg shadow-sm border-l-4 border-purple-500">
                        <p class="text-gray-600 text-sm font-medium uppercase tracking-wider">Total Mahasiswa</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2"><?= $totalMahasiswa ?></p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg shadow-sm border-l-4 border-green-500">
                        <p class="text-gray-600 text-sm font-medium uppercase tracking-wider">Rata-rata Mahasiswa</p>
                        <p class="text-3xl font-bold text-green-600 mt-2"><?= $avgMahasiswa ?></p>
                    </div>
                    <div class="text-center p-4 bg-white rounded-lg shadow-sm border-l-4 border-orange-500">
                        <p class="text-gray-600 text-sm font-medium uppercase tracking-wider">Dosen Aktif</p>
                        <p class="text-3xl font-bold text-orange-600 mt-2"><?= $dosenAktif ?> / <?= $totalDosen ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .container {
        max-width: 1400px;
    }

    /* Scrollbar styling untuk table */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Smooth hover effect on table rows */
    tbody tr {
        transition: all 0.2s ease-in-out;
    }

    tbody tr:hover {
        background-color: rgb(239, 246, 255);
        box-shadow: inset 4px 0 0 rgb(59, 130, 246);
    }
</style>
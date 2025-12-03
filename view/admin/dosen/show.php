<?php

/**
 * View untuk menampilkan detail dosen
 */

if (!isset($dosen) || !$dosen) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Data dosen tidak ditemukan!</div>';
    exit;
}

$mahasiswaCount = $dosen['jumlah_mahasiswa'] ?? 0;
?>

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="index.php?page=admin-dosen" class="text-blue-600 hover:text-blue-900 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Dosen
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-8 text-white mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2"><?= htmlspecialchars($dosen['nama']) ?></h1>
                <p class="text-blue-100 mb-4">
                    <i class="fas fa-id-card mr-2"></i>NIP: <?= htmlspecialchars($dosen['nip']) ?>
                </p>
                <div class="flex flex-wrap gap-3">
                    <?php if ($dosen['status'] === 'active'): ?>
                        <span class="bg-green-400 text-white px-4 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                    <?php else: ?>
                        <span class="bg-gray-400 text-white px-4 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-pause-circle mr-1"></i>Tidak Aktif
                        </span>
                    <?php endif; ?>
                    <span class="bg-blue-400 text-white px-4 py-1 rounded-full text-sm font-semibold">
                        <i class="fas fa-users mr-1"></i><?= $mahasiswaCount ?> Mahasiswa
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Information -->
        <div class="lg:col-span-2">
            <!-- Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-information-circle mr-2 text-blue-600"></i>Informasi Dosen
                </h2>

                <div class="space-y-4">
                    <!-- Email -->
                    <div class="pb-4 border-b border-gray-200">
                        <p class="text-sm text-gray-600 font-medium">Email</p>
                        <p class="text-lg text-gray-900">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>
                            <a href="mailto:<?= htmlspecialchars($dosen['email']) ?>" class="text-blue-600 hover:text-blue-900">
                                <?= htmlspecialchars($dosen['email']) ?>
                            </a>
                        </p>
                    </div>

                    <!-- Phone -->
                    <div class="pb-4 border-b border-gray-200">
                        <p class="text-sm text-gray-600 font-medium">No. Telpon</p>
                        <p class="text-lg text-gray-900">
                            <i class="fas fa-phone mr-2 text-green-600"></i>
                            <a href="tel:<?= htmlspecialchars($dosen['no_hp']) ?>" class="text-blue-600 hover:text-blue-900">
                                <?= htmlspecialchars($dosen['no_hp'] ?? 'Tidak tersedia') ?>
                            </a>
                        </p>
                    </div>

                    <!-- Institusi Asal -->
                    <div class="pb-4 border-b border-gray-200">
                        <p class="text-sm text-gray-600 font-medium">Asal Institusi / Pendidikan</p>
                        <p class="text-lg text-gray-900">
                            <i class="fas fa-graduation-cap mr-2 text-purple-600"></i>
                            <?= htmlspecialchars($dosen['origin'] ?? 'Tidak tersedia') ?>
                        </p>
                    </div>

                    <!-- Bergabung Sejak -->
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Bergabung Sejak</p>
                        <p class="text-lg text-gray-900">
                            <i class="fas fa-calendar mr-2 text-orange-600"></i>
                            <?= date('d M Y', strtotime($dosen['created_at'])) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-list mr-2 text-blue-600"></i>Mahasiswa Bimbingan
                </h2>

                <?php if ($mahasiswaCount > 0): ?>
                    <div class="space-y-3">
                        <?php
                        // Query untuk mendapatkan mahasiswa bimbingan
                        $mahasiswaQuery = "SELECT m.*, u.email, u.status as user_status
                                         FROM mahasiswa m
                                         JOIN users u ON m.user_id = u.id
                                         WHERE m.supervisor_id = $1
                                         ORDER BY m.nama ASC";
                        $mahasiswaResult = @pg_query_params($GLOBALS['db'] ?? $_db, $mahasiswaQuery, [$dosen['dosen_id']]);

                        if ($mahasiswaResult):
                            while ($m = pg_fetch_assoc($mahasiswaResult)):
                        ?>
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold text-gray-900"><?= htmlspecialchars($m['nama']) ?></p>
                                            <p class="text-sm text-gray-600">NIM: <?= htmlspecialchars($m['nim']) ?></p>
                                            <p class="text-sm text-gray-600">Angkatan: <?= htmlspecialchars($m['angkatan'] ?? '-') ?></p>
                                            <p class="text-sm text-gray-700 mt-2"><strong>Topik Riset:</strong> <?= htmlspecialchars($m['research_title'] ?? 'Belum ditentukan') ?></p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $m['user_status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                            <?= $m['user_status'] === 'active' ? 'Aktif' : 'Tidak Aktif' ?>
                                        </span>
                                    </div>
                                </div>
                        <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                <?php else: ?>
                    <div class="bg-gray-100 rounded-lg p-6 text-center">
                        <p class="text-gray-600">
                            <i class="fas fa-inbox mr-2"></i>Belum ada mahasiswa bimbingan
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Statistics -->
        <div class="lg:col-span-1">
            <!-- Stats Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-chart-bar mr-2 text-blue-600"></i>Statistik
                </h3>

                <div class="space-y-4">
                    <!-- Jumlah Mahasiswa -->
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 font-medium">Jumlah Mahasiswa</p>
                        <p class="text-3xl font-bold text-blue-600"><?= $mahasiswaCount ?></p>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 font-medium">Status</p>
                        <p class="text-xl font-semibold <?= $dosen['status'] === 'active' ? 'text-green-600' : 'text-gray-600' ?>">
                            <?= $dosen['status'] === 'active' ? 'Aktif' : 'Tidak Aktif' ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-cogs mr-2 text-blue-600"></i>Aksi
                </h3>

                <div class="space-y-2">
                    <a href="index.php?page=admin-dosen-edit&id=<?= $dosen['dosen_id'] ?>"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-edit mr-2"></i>Edit Dosen
                    </a>

                    <button
                        onclick="confirmDelete(<?= $dosen['dosen_id'] ?>)"
                        class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i>Hapus Dosen
                    </button>

                    <a href="index.php?page=admin-dosen&search=<?= urlencode($dosen['nama']) ?>"
                        class="block w-full text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-search mr-2"></i>Dosen Lainnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
    }
</style>
<?php

?>

<div class="max-w-6xl mx-auto p-6">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manajemen Profil Laboratorium</h1>
                <p class="mt-2 text-gray-600">Lihat data yang sedang ditampilkan di halaman publik.</p>
            </div>
            <a href="index.php?page=admin-profile-settings&action=edit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-900 hover:bg-blue-800 transition">
                Edit Profil
            </a>
        </div>
    </div>

    <?php
    if (isset($_SESSION['success'])) {
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
            <label class="block text-xs font-medium text-slate-700 mb-1.5">Gambar Profil Saat Ini</label>
            <?php
            // Gunakan fallback jika image kosong
            $imgName = !empty($profileData['image']) ? $profileData['image'] : 'default.png';

            // Gunakan path absolut dengan awalan /
            $imgPath = "/public/uploads/profiles/" . $imgName;
            ?>
            <div class="mb-3">
                <img src="profiles/<?= $profileData['image'] ?>" alt="Profil"
                    class="max-h-40 w-auto rounded-lg border border-slate-300">
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Informasi Dasar Lab</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Nama Lab (Singkatan)</label>
                    <p class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($profileData['singkatan'] ?? '-') ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Lokasi Ruangan</label>
                    <p class="text-gray-700"><?= htmlspecialchars($profileData['lokasi_ruangan'] ?? '-') ?></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Deskripsi Singkat</label>
                    <p class="text-gray-700 whitespace-pre-wrap">"<?= htmlspecialchars($profileData['deskripsi_singkat'] ?? '-') ?>"</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Fitur Promosi (Riset)</h3>
                <div class="space-y-2">
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($profileData['riset_fitur_judul'] ?? '-') ?></p>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($profileData['riset_fitur_desk'] ?? '-') ?></p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Fitur Promosi (Fasilitas)</h3>
                <div class="space-y-2">
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($profileData['fasilitas_fitur_judul'] ?? '-') ?></p>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($profileData['fasilitas_fitur_desk'] ?? '-') ?></p>
                </div>
            </div>
        </div>

    </div>
</div>
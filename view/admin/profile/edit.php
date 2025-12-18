<?php 
// File: app/Views/admin/profile/edit.php 
// Perbaikan: Menggunakan Null Coalescing Operator (??) untuk mencegah Undefined Index/Variable Warning
// Catatan: Ini adalah perbaikan sementara; masalah utama tetap di Controller.
?>

<div class="max-w-4xl mx-auto p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profil Laboratorium</h1>
        <p class="mt-2 text-gray-600">Perbarui semua informasi yang relevan dengan profil Lab Anda.</p>
    </div>

    <form action="index.php?page=admin-profile-settings&action=edit" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-8 space-y-6">

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label for="nama_lab" class="block text-sm font-medium text-gray-700 mb-1">Nama Laboratorium Lengkap</label>
                <input type="text" id="nama_lab" name="nama_lab" value="<?= htmlspecialchars($profileData['nama_lab'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div>
                <label for="singkatan" class="block text-sm font-medium text-gray-700 mb-1">Singkatan</label>
                <input type="text" id="singkatan" name="singkatan" value="<?= htmlspecialchars($profileData['singkatan'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>
        </div>

        <div>
            <label for="lokasi_ruangan" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Ruangan Lab</label>
            <input type="text" id="lokasi_ruangan" name="lokasi_ruangan" value="<?= htmlspecialchars($profileData['lokasi_ruangan'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm p-2">
        </div>

        <div>
            <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat (Body Text)</label>
            <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="5" class="w-full border-gray-300 rounded-md shadow-sm p-2"><?= htmlspecialchars($profileData['deskripsi_singkat'] ?? '') ?></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Logo / Gambar Profil Lab</label>
            <div class="mt-1 flex items-center space-x-4">
                 <?php if (!empty($profileData['image'])): ?>
                    <img src="<?= htmlspecialchars($profileData['image']) ?>" alt="Current Logo" class="w-20 h-20 object-contain border rounded-md">
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/*" class="block w-full text-sm text-gray-500
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-md file:border-0
                  file:text-sm file:font-semibold
                  file:bg-blue-50 file:text-blue-700
                  hover:file:bg-blue-100
                "/>
            </div>
            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maks 2MB.</p>
        </div>

        <hr class="border-gray-200">

        <h3 class="text-lg font-bold text-gray-900 mb-2">Fitur Kotak 1 (Riset Inovatif)</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label for="riset_fitur_judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Kotak 1</label>
                <input type="text" id="riset_fitur_judul" name="riset_fitur_judul" value="<?= htmlspecialchars($profileData['riset_fitur_judul'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div>
                <label for="riset_fitur_desk" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kotak 1</label>
                <input type="text" id="riset_fitur_desk" name="riset_fitur_desk" value="<?= htmlspecialchars($profileData['riset_fitur_desk'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>
        </div>

        <h3 class="text-lg font-bold text-gray-900 mb-2">Fitur Kotak 2 (Fasilitas Modern)</h3>
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label for="fasilitas_fitur_judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Kotak 2</label>
                <input type="text" id="fasilitas_fitur_judul" name="fasilitas_fitur_judul" value="<?= htmlspecialchars($profileData['fasilitas_fitur_judul'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div>
                <label for="fasilitas_fitur_desk" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kotak 2</label>
                <input type="text" id="fasilitas_fitur_desk" name="fasilitas_fitur_desk" value="<?= htmlspecialchars($profileData['fasilitas_fitur_desk'] ?? '') ?>" class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>
        </div>
        
        <div class="pt-4 flex justify-end gap-3">
            <a href="index.php?page=admin-profile-settings" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">Batal</a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-md hover:bg-blue-800 transition shadow-md">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
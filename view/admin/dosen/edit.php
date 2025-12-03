<?php

/**
 * View untuk mengedit data dosen
 */

if (!isset($dosen) || !$dosen) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Data dosen tidak ditemukan!</div>';
    exit;
}
?>

<div class="container mx-auto px-4 py-8 max-w-2xl">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="index.php?page=admin-dosen" class="text-blue-600 hover:text-blue-900 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Dosen
        </a>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-edit mr-2 text-blue-600"></i>Edit Data Dosen
        </h1>
        <p class="text-gray-600"><?= htmlspecialchars($dosen['nama']) ?></p>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <p class="font-medium"><?= $_SESSION['error'] ?></p>
            </div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <p class="font-medium"><?= $_SESSION['success'] ?></p>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <form method="POST" action="index.php?page=admin-dosen-update&id=<?= $dosen['dosen_id'] ?>" class="space-y-6">

            <!-- Data Akun (User) Section -->
            <div class="border-b border-gray-200 pb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-user-circle mr-2 text-blue-600"></i>Data Akun Login
                </h2>

                <!-- Email (read-only) -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email (Tidak bisa diubah)
                    </label>
                    <input
                        type="email"
                        id="email"
                        value="<?= htmlspecialchars($dosen['email'] ?? '') ?>"
                        disabled
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    <p class="mt-1 text-xs text-gray-500">Email tidak bisa diubah untuk alasan keamanan</p>
                </div>

                <!-- Password (optional) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru (Kosongkan jika tidak ingin diubah)
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            minlength="8"
                            placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti password</p>
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input
                            type="password"
                            id="password_confirm"
                            name="password_confirm"
                            minlength="8"
                            placeholder="Ketik ulang password baru"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Data Dosen Section -->
            <div class="border-b border-gray-200 pb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-graduation-cap mr-2 text-green-600"></i>Data Dosen
                </h2>

                <!-- NIP (read-only) -->
                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">
                        NIP (Tidak bisa diubah)
                    </label>
                    <input
                        type="text"
                        id="nip"
                        value="<?= htmlspecialchars($dosen['nip'] ?? '') ?>"
                        disabled
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    <p class="mt-1 text-xs text-gray-500">NIP tidak bisa diubah untuk integritas data</p>
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        required
                        value="<?= htmlspecialchars($dosen['nama'] ?? '') ?>"
                        placeholder="Contoh: Dr. Budi Santoso"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Origin (Asal Institusi) -->
                <div class="mb-4">
                    <label for="origin" class="block text-sm font-medium text-gray-700 mb-2">
                        Asal Institusi / Pendidikan <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="origin"
                        name="origin"
                        required
                        rows="2"
                        placeholder="Contoh: S3 Teknik Informatika - Institut Teknologi Bandung"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"><?= htmlspecialchars($dosen['origin'] ?? '') ?></textarea>
                </div>

                <!-- No. Telepon -->
                <div class="mb-4">
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon / HP
                    </label>
                    <input
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        value="<?= htmlspecialchars($dosen['no_hp'] ?? '') ?>"
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Status Section -->
            <div class="pb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-toggle-on mr-2 text-purple-600"></i>Status
                </h2>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Dosen
                    </label>
                    <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="active" <?= ($dosen['status'] ?? '') === 'active' ? 'selected' : '' ?>>Aktif</option>
                        <option value="inactive" <?= ($dosen['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Tidak Aktif</option>
                        <option value="cuti" <?= ($dosen['status'] ?? '') === 'cuti' ? 'selected' : '' ?>>Cuti</option>
                    </select>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button
                    type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <button
                    type="reset"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-redo mr-2"></i>Reset Form
                </button>
                <a
                    href="index.php?page=admin-dosen-detail&id=<?= $dosen['dosen_id'] ?>"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
    }
</style>

<script>
    // Validasi password match saat input
    document.getElementById('password_confirm').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;

        if (confirmPassword && password !== confirmPassword) {
            this.setCustomValidity('Password tidak cocok!');
        } else {
            this.setCustomValidity('');
        }
    });

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirm').value;

        // Jika salah satu password diisi, keduanya harus diisi
        if ((password || confirmPassword) && password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return false;
        }

        if (password && password.length < 8) {
            e.preventDefault();
            alert('Password minimal 8 karakter!');
            return false;
        }
    });
</script>
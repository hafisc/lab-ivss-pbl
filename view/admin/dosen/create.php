<?php

/**
 * View untuk menambahkan data dosen baru
 */
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
            <i class="fas fa-plus-circle mr-2 text-blue-600"></i>Tambah Dosen Baru
        </h1>
        <p class="text-gray-600">Masukkan data dosen baru ke dalam sistem</p>
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
        <form method="POST" action="index.php?page=admin-dosen-store" class="space-y-6">

            <!-- Data Akun (User) Section -->
            <div class="border-b border-gray-200 pb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-user-circle mr-2 text-blue-600"></i>Data Akun Login
                </h2>

                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        placeholder="Contoh: budi_dosen"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Gunakan huruf kecil, tidak ada spasi</p>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="Contoh: budi.dosen@polinema.ac.id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Gunakan email institusi</p>
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            minlength="8"
                            placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            id="password_confirm"
                            name="password_confirm"
                            required
                            minlength="8"
                            placeholder="Ketik ulang password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Data Dosen Section -->
            <div class="border-b border-gray-200 pb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-graduation-cap mr-2 text-green-600"></i>Data Dosen
                </h2>

                <!-- NIP -->
                <div class="mb-4">
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">
                        NIP (Nomor Induk Pegawai) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nip"
                        name="nip"
                        required
                        placeholder="Contoh: 197505152000031001"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Gunakan NIP resmi dari institusi</p>
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
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
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Opsional - gunakan format internasional</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button
                    type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>Simpan Dosen Baru
                </button>
                <button
                    type="reset"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center">
                    <i class="fas fa-redo mr-2"></i>Reset Form
                </button>
                <a
                    href="index.php?page=admin-dosen"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center text-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Catatan:</strong> Semua field yang ditandai dengan (*) wajib diisi. Data yang dimasukkan akan divalidasi dan disimpan ke database.
                </p>
            </div>
        </form>
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
    }

    input:invalid,
    textarea:invalid,
    select:invalid {
        border-color: #ef4444;
    }

    input:valid,
    textarea:valid,
    select:valid {
        border-color: #10b981;
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

    // Format username (lowercase, no spaces)
    document.getElementById('username').addEventListener('blur', function() {
        this.value = this.value.toLowerCase().replace(/\s+/g, '_');
    });

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirm').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak cocok!');
            return false;
        }

        // Check email format
        const email = document.getElementById('email').value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('Format email tidak valid!');
            return false;
        }
    });
</script>
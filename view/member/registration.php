<?php
/**
 * View Pendaftaran Member
 * 
 * File ini menangani tampilan form pendaftaran anggota baru lab.
 * 
 * @package View
 * @subpackage Member
 */

require_once __DIR__ . '/../../app/controllers/MemberController.php';

// Inisialisasi controller dan handle registrasi
$memberController = new MemberController();
$memberController->register();
?>

<!-- Container Utama Form Pendaftaran -->
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg my-10 border border-gray-100">
    <!-- Header Form -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Pendaftaran Anggota Lab IVSS</h2>
        <p class="text-gray-500 text-sm mt-2">Lengkapi data diri Anda untuk bergabung menjadi anggota laboratorium.</p>
    </div>
    
    <!-- Form Mulai -->
    <form action="" method="POST" class="space-y-6">
        
        <!-- Bagian: Informasi Personal -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 border-b border-gray-300 pb-2">Informasi Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Data: Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Nama Lengkap Anda">
                </div>
                <!-- Data: NIM -->
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM <span class="text-red-500">*</span></label>
                    <input type="text" name="nim" id="nim" required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Nomor Induk Mahasiswa">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <!-- Data: Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Kampus <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="email@student.polinema.ac.id">
                </div>
                <!-- Data: Telepon -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Contoh: 08123456789">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <!-- Data: Angkatan -->
                <div>
                    <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-1">Angkatan <span class="text-red-500">*</span></label>
                    <input type="text" name="angkatan" id="angkatan" required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Tahun Angkatan">
                </div>
                <!-- Data: Asal Kelas -->
                <div>
                    <label for="origin" class="block text-sm font-medium text-gray-700 mb-1">Kelas / Jurusan <span class="text-red-500">*</span></label>
                    <input type="text" name="origin" id="origin" required 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Contoh: TI 3A - JTI">
                </div>
            </div>
        </div>

        <!-- Bagian: Informasi Riset -->
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-sm font-semibold text-blue-800 mb-4 border-b border-blue-200 pb-2">Rencana Riset</h3>
            
            <!-- Data: Judul Riset -->
            <div class="mb-4">
                <label for="research_title" class="block text-sm font-medium text-gray-700 mb-1">Judul Rencana Riset <span class="text-red-500">*</span></label>
                <input type="text" name="research_title" id="research_title" required 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Judul topik penelitian yang diminati">
            </div>

            <!-- Data: Pembimbing -->
            <div class="mb-4">
                <label for="supervisor_id" class="block text-sm font-medium text-gray-700 mb-1">Calon Dosen Pembimbing <span class="text-red-500">*</span></label>
                <select name="supervisor_id" id="supervisor_id" required 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white">
                    <option value="">-- Pilih Dosen Pembimbing --</option>
                    <!-- TODO: Ambil data dosen dari database secara dinamis -->
                    <option value="3">Dr. Budi Santoso</option>
                    <option value="4">Dr. Andi Wijaya</option>
                    <option value="5">Dr. Siti Nurhaliza</option>
                </select>
            </div>

            <!-- Data: Motivasi -->
            <div>
                <label for="motivation" class="block text-sm font-medium text-gray-700 mb-1">Motivasi Bergabung <span class="text-red-500">*</span></label>
                <textarea name="motivation" id="motivation" rows="4" required 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Jelaskan alasan Anda ingin bergabung..."></textarea>
            </div>
        </div>

        <!-- Bagian: Akun -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Akun <span class="text-red-500">*</span></label>
            <input type="password" name="password" id="password" required 
                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            <p class="mt-1 text-xs text-gray-500">Gunakan kombinasi minimal 8 karakter untuk keamanan.</p>
        </div>

        <!-- Tombol Submit -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                Daftar Sekarang
            </button>
        </div>
    </form>
</div>

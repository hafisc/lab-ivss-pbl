<?php
require_once __DIR__ . '/../../app/controllers/MemberController.php';

// Handle form submission
$memberController = new MemberController();
$memberController->register();
?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md my-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Pendaftaran Anggota Lab IVSS</h2>
    
    <form action="" method="POST" class="space-y-6">
        <!-- Personal Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                <input type="text" name="nim" id="nim" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Kampus</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">No. WhatsApp</label>
                <input type="text" name="phone" id="phone" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                <input type="text" name="angkatan" id="angkatan" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label for="origin" class="block text-sm font-medium text-gray-700">Kelas / Jurusan</label>
                <input type="text" name="origin" id="origin" placeholder="Contoh: TI 3A - JTI" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <!-- Research Info -->
        <div>
            <label for="research_title" class="block text-sm font-medium text-gray-700">Judul Rencana Riset</label>
            <input type="text" name="research_title" id="research_title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <div>
            <label for="supervisor_id" class="block text-sm font-medium text-gray-700">Calon Dosen Pembimbing</label>
            <select name="supervisor_id" id="supervisor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih Dosen Pembimbing</option>
                <!-- In real app, fetch this from database -->
                <option value="3">Dr. Budi Santoso</option>
                <option value="4">Dr. Andi Wijaya</option>
                <option value="5">Dr. Siti Nurhaliza</option>
            </select>
        </div>

        <div>
            <label for="motivation" class="block text-sm font-medium text-gray-700">Motivasi Bergabung</label>
            <textarea name="motivation" id="motivation" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>

        <!-- Account Info -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password Akun</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <p class="mt-1 text-xs text-gray-500">Password ini akan digunakan untuk login jika diterima.</p>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Daftar Sekarang
            </button>
        </div>
    </form>
</div>

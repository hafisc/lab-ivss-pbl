<!-- System Settings -->
<div class="bg-white border border-slate-200 rounded-xl p-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-slate-800">Pengaturan Sistem</h3>
        <p class="text-sm text-slate-500 mt-1">Konfigurasi sistem Lab IVSS</p>
    </div>

    <form method="POST" action="index.php?page=admin-settings&action=update-system" class="space-y-6">
        
        <!-- Site Name -->
        <div>
            <label for="site_name" class="block text-sm font-medium text-slate-700 mb-2">Nama Website</label>
            <input type="text" id="site_name" name="site_name"
                   value="Lab IVSS - Politeknik Negeri Ujung Pandang"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Site Description -->
        <div>
            <label for="site_description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Website</label>
            <textarea id="site_description" name="site_description" rows="3"
                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">Laboratorium Intelligent Video Surveillance System</textarea>
        </div>

        <!-- Contact Email -->
        <div>
            <label for="contact_email" class="block text-sm font-medium text-slate-700 mb-2">Email Kontak</label>
            <input type="email" id="contact_email" name="contact_email"
                   value="ivss@poliupg.ac.id"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Contact Phone -->
        <div>
            <label for="contact_phone" class="block text-sm font-medium text-slate-700 mb-2">No. Telepon</label>
            <input type="tel" id="contact_phone" name="contact_phone"
                   value="0411-512345"
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
            <textarea id="address" name="address" rows="3"
                      class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">Jl. Perintis Kemerdekaan KM.10, Tamalanrea, Makassar</textarea>
        </div>

        <!-- Maintenance Mode -->
        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
            <div>
                <p class="text-sm font-medium text-slate-800">Mode Maintenance</p>
                <p class="text-xs text-slate-500 mt-1">Aktifkan untuk menutup akses sementara ke website</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="maintenance_mode" class="sr-only peer">
                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-red-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
            </label>
        </div>

        <!-- Allow Registration -->
        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
            <div>
                <p class="text-sm font-medium text-slate-800">Izinkan Pendaftaran Baru</p>
                <p class="text-xs text-slate-500 mt-1">Member baru dapat mendaftar melalui website</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="allow_registration" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors">
                Simpan Pengaturan
            </button>
            <button type="reset" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                Reset
            </button>
        </div>
    </form>
</div>

<!-- System Info -->
<div class="bg-white border border-slate-200 rounded-xl p-6 mt-6">
    <div class="mb-4">
        <h3 class="text-base font-semibold text-slate-800">Informasi Sistem</h3>
        <p class="text-sm text-slate-500 mt-1">Detail teknis sistem</p>
    </div>
    
    <div class="grid md:grid-cols-2 gap-4">
        <div class="p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-500 mb-1">PHP Version</p>
            <p class="text-sm font-medium text-slate-800"><?= phpversion() ?></p>
        </div>
        <div class="p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-500 mb-1">Server Software</p>
            <p class="text-sm font-medium text-slate-800"><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></p>
        </div>
        <div class="p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-500 mb-1">Database</p>
            <p class="text-sm font-medium text-slate-800">PostgreSQL</p>
        </div>
        <div class="p-3 bg-slate-50 rounded-lg">
            <p class="text-xs text-slate-500 mb-1">Upload Max Size</p>
            <p class="text-sm font-medium text-slate-800"><?= ini_get('upload_max_filesize') ?></p>
        </div>
    </div>
</div>

<!-- Backup & Restore -->
<div class="bg-white border border-slate-200 rounded-xl p-6 mt-6">
    <div class="mb-4">
        <h3 class="text-base font-semibold text-slate-800">Backup & Restore</h3>
        <p class="text-sm text-slate-500 mt-1">Kelola backup database</p>
    </div>
    
    <div class="flex gap-3">
        <button type="button" class="px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
            </svg>
            Backup Database
        </button>
        <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            Restore Database
        </button>
    </div>
    
    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
        <p class="text-xs text-yellow-800">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Backup terakhir: Belum pernah backup
        </p>
    </div>
</div>

<!-- Security Settings -->
<div class="bg-white border border-slate-200 rounded-xl p-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-slate-800">Keamanan Akun</h3>
        <p class="text-sm text-slate-500 mt-1">Ubah password dan pengaturan keamanan</p>
    </div>

    <form method="POST" action="index.php?page=admin-settings&action=change-password" class="space-y-6">
        
        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Password Saat Ini *</label>
            <input type="password" id="current_password" name="current_password" required
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Masukkan password saat ini">
        </div>

        <!-- New Password -->
        <div>
            <label for="new_password" class="block text-sm font-medium text-slate-700 mb-2">Password Baru *</label>
            <input type="password" id="new_password" name="new_password" required
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Masukkan password baru">
            <p class="text-xs text-slate-500 mt-1">Minimal 8 karakter, kombinasi huruf dan angka</p>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="confirm_password" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password *</label>
            <input type="password" id="confirm_password" name="confirm_password" required
                   class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Ketik ulang password baru">
        </div>

        <!-- Submit Button -->
        <div class="flex gap-3 pt-4 border-t">
            <button type="submit" class="px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors">
                Ubah Password
            </button>
        </div>
    </form>
</div>

<!-- Two-Factor Authentication (Optional) -->
<div class="bg-white border border-slate-200 rounded-xl p-6 mt-6">
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-base font-semibold text-slate-800">Two-Factor Authentication</h3>
            <p class="text-sm text-slate-500 mt-1">Tambahkan lapisan keamanan ekstra untuk akun Anda</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" class="sr-only peer" disabled>
            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-blue-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
        </label>
    </div>
    <p class="text-xs text-slate-500">Fitur ini akan segera tersedia</p>
</div>

<!-- Session Management -->
<div class="bg-white border border-slate-200 rounded-xl p-6 mt-6">
    <div class="mb-4">
        <h3 class="text-base font-semibold text-slate-800">Aktivitas Login</h3>
        <p class="text-sm text-slate-500 mt-1">Riwayat login terakhir Anda</p>
    </div>
    
    <div class="space-y-3">
        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">Sesi Saat Ini</p>
                    <p class="text-xs text-slate-500">Windows • Chrome • Makassar, Indonesia</p>
                </div>
            </div>
            <span class="text-xs text-green-600 font-medium">Active</span>
        </div>
    </div>
    
    <button class="mt-4 text-sm text-red-600 hover:text-red-700 font-medium">
        Logout Dari Semua Device
    </button>
</div>

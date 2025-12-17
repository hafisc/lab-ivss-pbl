<?php ob_start(); ?>

<!-- Back Button -->
<div class="mb-4">
    <a href="index.php?page=member-settings" class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-slate-900">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Profil
    </a>
</div>

<!-- Page Header -->
<div class="mb-4">
    <h2 class="text-lg font-bold text-slate-800">Ubah Password</h2>
    <p class="text-xs text-slate-500 mt-0.5">Perbarui password akun untuk keamanan</p>
</div>

<!-- Alert Messages -->
<?php if (isset($_SESSION['success'])): ?>
<div class="mb-3 bg-green-50 border-l-4 border-green-500 p-3 rounded-lg">
    <p class="text-xs text-green-700"><?= $_SESSION['success'] ?></p>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="mb-3 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
    <p class="text-xs text-red-700"><?= $_SESSION['error'] ?></p>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Change Password Form -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="index.php?page=member-settings-change-password-submit" method="POST" class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            
            <!-- Form Header -->
            <div class="px-4 py-3 border-b border-slate-200 bg-gradient-to-r from-purple-50 to-blue-50">
                <h3 class="font-semibold text-slate-800">Ganti Password</h3>
                <p class="text-xs text-slate-500 mt-0.5">Masukkan password lama dan password baru</p>
            </div>
            
            <!-- Form Fields -->
            <div class="p-4 space-y-4">
                
                <!-- Password Lama -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        Password Lama <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="old_password" 
                               id="oldPassword"
                               required
                               class="w-full px-3 py-2 pr-10 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword('oldPassword', 'oldPasswordIcon')" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600">
                            <svg id="oldPasswordIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Masukkan password lama Anda</p>
                </div>
                
                <!-- Password Baru -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="new_password" 
                               id="newPassword"
                               required
                               minlength="6"
                               class="w-full px-3 py-2 pr-10 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword('newPassword', 'newPasswordIcon')" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600">
                            <svg id="newPasswordIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Minimal 6 karakter</p>
                </div>
                
                <!-- Konfirmasi Password Baru -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="confirm_password" 
                               id="confirmPassword"
                               required
                               minlength="6"
                               class="w-full px-3 py-2 pr-10 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword('confirmPassword', 'confirmPasswordIcon')" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 text-slate-400 hover:text-slate-600">
                            <svg id="confirmPasswordIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">Ulangi password baru</p>
                </div>
                
            </div>
            
            <!-- Form Footer -->
            <div class="px-4 py-3 border-t border-slate-200 bg-slate-50 flex gap-2 justify-end">
                <a href="index.php?page=member-settings" 
                   class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Ubah Password
                </button>
            </div>
            
        </form>
    </div>
    
    <!-- Info Sidebar -->
    <div class="space-y-4">
        
        <!-- Security Tips -->
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-purple-900 mb-1">Tips Keamanan Password</h4>
                    <ul class="text-xs text-purple-800 space-y-1">
                        <li>• Minimal 6 karakter</li>
                        <li>• Kombinasi huruf & angka</li>
                        <li>• Hindari password yang mudah ditebak</li>
                        <li>• Jangan bagikan password</li>
                        <li>• Ganti password secara berkala</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Profile Info -->
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <h4 class="text-sm font-semibold text-slate-800 mb-3">Akun Anda</h4>
            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center flex-shrink-0">
                    <span class="text-lg font-bold text-white">
                        <?= strtoupper(substr($me['name'] ?? 'M', 0, 1)) ?>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-800 truncate"><?= htmlspecialchars($me['name'] ?? '-') ?></p>
                    <p class="text-xs text-slate-600 truncate"><?= htmlspecialchars($me['email'] ?? '-') ?></p>
                </div>
            </div>
        </div>
        
        <!-- Warning -->
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-amber-900 mb-1">Penting!</h4>
                    <p class="text-xs text-amber-800">Setelah password diubah, Anda akan tetap login di perangkat ini. Namun di perangkat lain akan logout otomatis.</p>
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<!-- JavaScript for Toggle Password -->
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}
</script>

<?php
$content = ob_get_clean();
$title = "Ubah Password";
include __DIR__ . "/../../layouts/member.php";
?>

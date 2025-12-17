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
    <h2 class="text-lg font-bold text-slate-800">Edit Profil</h2>
    <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi profil kamu</p>
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

<!-- Edit Form -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    <!-- Main Form -->
    <div class="lg:col-span-2">
        <form action="index.php?page=member-settings-update" method="POST" class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            
            <!-- Form Header -->
            <div class="px-4 py-3 border-b border-slate-200 bg-gradient-to-r from-blue-50 to-purple-50">
                <h3 class="font-semibold text-slate-800">Informasi Pribadi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Update data diri kamu</p>
            </div>
            
            <!-- Form Fields -->
            <div class="p-4 space-y-4">
                
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="<?= htmlspecialchars($me['name'] ?? '') ?>"
                           required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           value="<?= htmlspecialchars($me['email'] ?? '') ?>"
                           required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-slate-500 mt-1">Email digunakan untuk login</p>
                </div>
                
                <!-- NIM -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        NIM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nim" 
                           value="<?= htmlspecialchars($me['nim'] ?? '') ?>"
                           required
                           maxlength="20"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- No. Telepon -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        No. Telepon
                    </label>
                    <input type="tel" 
                           name="phone" 
                           value="<?= htmlspecialchars($me['phone'] ?? '') ?>"
                           maxlength="15"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Angkatan -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        Angkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="angkatan" 
                           value="<?= htmlspecialchars($me['angkatan'] ?? '') ?>"
                           required
                           maxlength="4"
                           placeholder="2024"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Asal Prodi/Kelas -->
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">
                        Asal Prodi/Kelas
                    </label>
                    <input type="text" 
                           name="origin" 
                           value="<?= htmlspecialchars($me['origin'] ?? '') ?>"
                           placeholder="TI-3C / D4 Teknik Informatika"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
            </div>
            
            <!-- Form Footer -->
            <div class="px-4 py-3 border-t border-slate-200 bg-slate-50 flex gap-2 justify-end">
                <a href="index.php?page=member-settings" 
                   class="px-4 py-2 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Simpan Perubahan
                </button>
            </div>
            
        </form>
    </div>
    
    <!-- Info Sidebar -->
    <div class="space-y-4">
        
        <!-- Tips Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-blue-900 mb-1">Tips Keamanan</h4>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• Gunakan email aktif yang valid</li>
                        <li>• Pastikan data yang diisi benar</li>
                        <li>• Update profil secara berkala</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Current Profile Card -->
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <h4 class="text-sm font-semibold text-slate-800 mb-3">Profil Saat Ini</h4>
            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                    <span class="text-lg font-bold text-white">
                        <?= strtoupper(substr($me['name'] ?? 'M', 0, 1)) ?>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-800 truncate"><?= htmlspecialchars($me['name'] ?? '-') ?></p>
                    <p class="text-xs text-slate-600 truncate"><?= htmlspecialchars($me['nim'] ?? '-') ?></p>
                    <p class="text-xs text-slate-500"><?= htmlspecialchars($me['angkatan'] ?? '-') ?></p>
                </div>
            </div>
        </div>
        
        <!-- Password Change Link -->
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="flex items-start gap-2 mb-3">
                <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-slate-800">Ganti Password?</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui password untuk keamanan akun</p>
                </div>
            </div>
            <a href="index.php?page=member-change-password" 
               class="block w-full px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium text-center rounded-lg transition-colors">
                Ubah Password
            </a>
        </div>
        
    </div>
    
</div>

<?php
$content = ob_get_clean();
$title = "Edit Profil";
include __DIR__ . "/../../layouts/member.php";
?>

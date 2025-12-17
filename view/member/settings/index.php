<?php ob_start(); ?>

<!-- Page Header -->
<div class="mb-4">
    <h2 class="text-lg font-bold text-slate-800">Profil Saya</h2>
    <p class="text-xs text-slate-500 mt-0.5">Informasi dan pengaturan akun kamu</p>
</div>

<!-- Alert Messages -->
<?php if (isset($_SESSION['success'])): ?>
<div class="mb-3 bg-green-50 border-l-4 border-green-500 p-3 rounded-lg">
    <p class="text-xs text-green-700"><?= $_SESSION['success'] ?></p>
</div>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    
    <!-- Profile Card -->
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-gradient-to-r from-blue-50 to-purple-50">
            <div class="flex items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0 border-4 border-white shadow-lg">
                    <span class="text-2xl font-bold text-white">
                        <?= strtoupper(substr($me['name'] ?? 'M', 0, 1)) ?>
                    </span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800"><?= htmlspecialchars($me['name'] ?? 'Member') ?></h3>
                    <p class="text-xs text-slate-600"><?= htmlspecialchars($me['email'] ?? '-') ?></p>
                    <div class="mt-1.5">
                        <?php
                        $statusLab = $me['status_lab'] ?? 'aktif';
                        $statusColor = $statusLab === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700';
                        ?>
                        <span class="inline-block px-2 py-0.5 <?= $statusColor ?> text-xs font-medium rounded-full">
                            Member <?= ucfirst($statusLab) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profile Details -->
        <div class="p-4">
            <h4 class="text-sm font-semibold text-slate-800 mb-3">Informasi Detail</h4>
            <div class="space-y-3">
                
                <!-- NIM -->
                <div class="flex items-start gap-2 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-slate-500">NIM</p>
                        <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($me['nim'] ?? '-') ?></p>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="flex items-start gap-2 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-slate-500">Email</p>
                        <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($me['email'] ?? '-') ?></p>
                    </div>
                </div>
                
                <!-- Angkatan -->
                <div class="flex items-start gap-2 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-slate-500">Angkatan</p>
                        <p class="text-sm font-medium text-slate-800"><?= htmlspecialchars($me['angkatan'] ?? '-') ?></p>
                    </div>
                </div>
                
                <!-- Status Lab -->
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-slate-500">Status Lab</p>
                        <p class="text-sm font-medium text-slate-800 capitalize"><?= htmlspecialchars($me['status_lab'] ?? 'aktif') ?></p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Actions Card -->
    <div class="space-y-4">
        
        <!-- Edit Profil -->
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800">Edit Profil</h4>
                    <p class="text-xs text-slate-500">Ubah data diri kamu</p>
                </div>
            </div>
            <a href="index.php?page=member-settings-edit" 
               class="block w-full px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium text-center rounded-lg transition-colors">
                Edit Profil
            </a>
        </div>
        
        <!-- Ubah Password -->
        <div class="bg-white border border-slate-200 rounded-xl p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800">Keamanan</h4>
                    <p class="text-xs text-slate-500">Ubah password akun</p>
                </div>
            </div>
            <a href="index.php?page=member-change-password" 
               class="block w-full px-4 py-2 bg-purple-700 hover:bg-purple-800 text-white text-sm font-medium text-center rounded-lg transition-colors">
                Ubah Password
            </a>
        </div>
        
       
       
        
    </div>
    
</div>

<?php
$content = ob_get_clean();
$title = "Profil Saya";
include __DIR__ . "/../../layouts/member.php";
?>

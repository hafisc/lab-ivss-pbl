<?php
/**
 * View Register
 * 
 * Halaman pendaftaran publik untuk calon member baru.
 * Berisi form lengkap data diri, riset, dan akun.
 * 
 * @package View
 * @subpackage Auth
 */

ob_start();
?>

<!-- Title & Description -->
<div class="text-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Daftar Anggota Baru</h2>
    <p class="text-sm text-slate-500 mt-2">Bergabunglah dengan komunitas riset Lab IVSS.</p>
</div>

<!-- Alert Pesan Error -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg animate-fade-in-down">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700"><?= $_SESSION['error'] ?></p>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- Form Registrasi -->
<form action="../../app/controllers/AuthController.php?action=register" method="POST" class="space-y-4">
    
    <!-- Group: Identitas -->
    <div class="space-y-3">
        <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider border-b border-gray-100 pb-1">Identitas Diri</h3>
        
        <!-- Nama Lengkap -->
        <div>
           <label for="name" class="block text-xs font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
           <input type="text" name="name" id="name" required
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
               placeholder="Nama Lengkap"
               value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>">
        </div>

        <div class="grid grid-cols-2 gap-3">
            <!-- NIM -->
            <div>
               <label for="nim" class="block text-xs font-medium text-slate-700 mb-1">NIM <span class="text-red-500">*</span></label>
               <input type="text" name="nim" id="nim" required
                   class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
                   placeholder="NIM"
                   value="<?= htmlspecialchars($_SESSION['old']['nim'] ?? '') ?>">
            </div>
            <!-- Angkatan -->
            <div>
               <label for="angkatan" class="block text-xs font-medium text-slate-700 mb-1">Angkatan <span class="text-red-500">*</span></label>
               <input type="number" name="angkatan" id="angkatan" required
                   class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
                   placeholder="Tahun"
                   value="<?= htmlspecialchars($_SESSION['old']['angkatan'] ?? '') ?>">
            </div>
        </div>
        
        <!-- Kontak -->
        <div class="grid grid-cols-2 gap-3">
            <!-- Email -->
            <div class="col-span-2 sm:col-span-1">
               <label for="email" class="block text-xs font-medium text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
               <input type="email" name="email" id="email" required
                   class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
                   placeholder="email@contoh.com"
                   value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>">
            </div>
            <!-- No HP -->
            <div class="col-span-2 sm:col-span-1">
               <label for="phone" class="block text-xs font-medium text-slate-700 mb-1">No. WhatsApp</label>
               <input type="tel" name="phone" id="phone"
                   class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
                   placeholder="08xxxxxxxx"
                   value="<?= htmlspecialchars($_SESSION['old']['phone'] ?? '') ?>">
            </div>
        </div>
        
        <!-- Asal Kelas -->
        <div>
           <label for="origin" class="block text-xs font-medium text-slate-700 mb-1">Asal Kelas / Jurusan</label>
           <input type="text" name="origin" id="origin"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
               placeholder="Contoh: TI 3A"
               value="<?= htmlspecialchars($_SESSION['old']['origin'] ?? '') ?>">
        </div>
    </div>
    
    <!-- Group: Minat Riset -->
    <div class="space-y-3 pt-2">
        <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider border-b border-gray-100 pb-1">Minat Riset</h3>
        
        <!-- Judul Riset -->
        <div>
           <label for="research_title" class="block text-xs font-medium text-slate-700 mb-1">Judul Rencana Riset</label>
           <input type="text" name="research_title" id="research_title"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
               placeholder="Topik yang ingin diteliti"
               value="<?= htmlspecialchars($_SESSION['old']['research_title'] ?? '') ?>">
        </div>

        <!-- Dosen Pembimbing (Select) -->
        <div>
           <label for="supervisor_id" class="block text-xs font-medium text-slate-700 mb-1">Calon Pembimbing (Opsional)</label>
           <select name="supervisor_id" id="supervisor_id" class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
               <option value="">-- Pilih Dosen --</option>
               <!-- TODO: Load from DB -->
               <option value="1">Dr. Pembimbing A</option>
               <option value="2">Dr. Pembimbing B</option>
           </select>
        </div>

        <!-- Motivasi -->
        <div>
           <label for="motivation" class="block text-xs font-medium text-slate-700 mb-1">Motivasi Bergabung</label>
           <textarea name="motivation" id="motivation" rows="3"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
               placeholder="Jelaskan motivasi Anda..."><?= htmlspecialchars($_SESSION['old']['motivation'] ?? '') ?></textarea>
        </div>
    </div>

    <!-- Group: Keamanan -->
    <div class="space-y-3 pt-2">
        <h3 class="text-sm font-semibold text-slate-700 uppercase tracking-wider border-b border-gray-100 pb-1">Keamanan Akun</h3>
        
        <!-- Password -->
        <div>
           <label for="password" class="block text-xs font-medium text-slate-700 mb-1">Password <span class="text-red-500">*</span></label>
           <div class="relative">
               <input type="password" name="password" id="password" required
                   class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
                   placeholder="Minimal 8 karakter">
               <button type="button" onclick="togglePassword('password', 'eye-password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                   <svg id="eye-password" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
               </button>
           </div>
        </div>

        <!-- Confirm Password -->
        <div>
           <label for="confirm_password" class="block text-xs font-medium text-slate-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
           <div class="relative">
               <input type="password" name="confirm_password" id="confirm_password" required
                   class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition-shadow"
                   placeholder="Ulangi password">
               <button type="button" onclick="togglePassword('confirm_password', 'eye-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                   <svg id="eye-confirm" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
               </button>
           </div>
        </div>
    </div>

    <!-- Tombol Daftar -->
    <div class="pt-2">
        <button type="submit" 
            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
            Daftar Sekarang
        </button>
    </div>
</form>

<!-- Link Login -->
<div class="mt-6 text-center">
    <p class="text-sm text-slate-600">
        Sudah punya akun? 
        <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500 hover:underline transition-colors">
            Masuk disini
        </a>
    </p>
</div>

<!-- Script Toggle Password -->
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    }
}
</script>

<?php
// Clear old session
if(isset($_SESSION['old'])) unset($_SESSION['old']);

// Mengakhiri buffer dan memuat layout auth
$content = ob_get_clean();
$title = "Daftar";
include __DIR__ . "/../layouts/auth.php";
?>

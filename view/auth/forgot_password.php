<?php
/**
 * View Lupa Password
 * 
 * Halaman form untuk mereset password jika user lupa.
 * Mengirimkan link reset password ke email yang terdaftar.
 * 
 * @package View
 * @subpackage Auth
 */

ob_start();
?>

<!-- Title & Description -->
<div class="text-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Lupa Password?</h2>
    <p class="text-sm text-slate-500 mt-2">
        Masukkan email yang terdaftar. Kami akan mengirimkan instruksi untuk reset password.
    </p>
</div>

<!-- Alert Pesan -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700"><?= $_SESSION['success'] ?></p>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
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

<!-- Form Reset Password -->
<form action="/auth/forgot-password" method="POST" class="space-y-5">
    
    <!-- Input Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Terdaftar</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
            </div>
            <input type="email" name="email" id="email" required 
                class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm placeholder-slate-400 transition-shadow"
                placeholder="nama@email.com">
        </div>
    </div>

    <!-- Tombol Submit -->
    <button type="submit" 
        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
        Kirim Link Reset
    </button>
</form>

<!-- Link Kembali ke Login -->
<div class="mt-6 text-center">
    <p class="text-sm text-slate-600">
        Ingat password Anda? 
        <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500 hover:underline transition-colors">
            Masuk disini
        </a>
    </p>
</div>

<?php
// Mengakhiri buffer dan memuat layout auth
$content = ob_get_clean();
$title = "Lupa Password";
include __DIR__ . "/../layouts/auth.php";
?>

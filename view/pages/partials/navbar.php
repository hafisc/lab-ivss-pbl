<!-- Topbar Mini -->
<div class="bg-blue-900 text-white text-xs py-2">
    <div class="container mx-auto px-4">
        <p class="text-center">
            <?= htmlspecialchars($settings['topbar_text'] ?? 'Laboratorium Intelligent Vision and Smart System (IVSS) – Jurusan Teknologi Informasi – Politeknik Negeri Malang') ?>
        </p>
    </div>
</div>

<!-- Navbar Utama -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo dan Nama Lab -->
            <div class="flex items-center space-x-3">
                <img src="<?= htmlspecialchars($settings['logo_url'] ?? 'assets/images/logo1.png') ?>" alt="IVSS Lab Logo" class="w-10 h-10 object-contain">
                <div>
                    <h1 class="text-xl font-bold text-blue-900"><?= htmlspecialchars($settings['institution_name'] ?? 'Politeknik Negeri Malang') ?></h1>
                    <p class="text-xs text-gray-600"><?= htmlspecialchars($settings['lab_name'] ?? 'Lab Intelligent Vision and Smart System') ?></p>
                </div>
            </div>
            
            <!-- Menu Desktop - Centered -->
            <div class="hidden md:flex items-center justify-center flex-1 space-x-6">
                <a href="#beranda" class="text-gray-700 hover:text-blue-900 font-medium transition">Beranda</a>
                <a href="#profil" class="text-gray-700 hover:text-blue-900 font-medium transition">Profil</a>
                <a href="#riset" class="text-gray-700 hover:text-blue-900 font-medium transition">Riset</a>
                <a href="#fasilitas" class="text-gray-700 hover:text-blue-900 font-medium transition">Fasilitas</a>
                <a href="#member" class="text-gray-700 hover:text-blue-900 font-medium transition">Member</a>
                <a href="#berita" class="text-gray-700 hover:text-blue-900 font-medium transition">Berita</a>
                <a href="#kontak" class="text-gray-700 hover:text-blue-900 font-medium transition">Kontak</a>
            </div>
            
            <!-- Tombol Login - Agak ke kiri -->
            <div class="hidden md:flex items-center pr-4">
                <a href="index.php?page=login" target="_blank" rel="noopener noreferrer" class="px-4 py-2 bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800 transition">
                    Login
                </a>
            </div>
            
            <!-- Tombol Mobile Menu -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Menu Mobile -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-4 py-3 space-y-2">
            <a href="#beranda" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Beranda</a>
            <a href="#profil" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Profil</a>
            <a href="#riset" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Riset</a>
            <a href="#fasilitas" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Fasilitas</a>
            <a href="#member" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Member</a>
            <a href="#berita" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Berita</a>
            <a href="#kontak" class="block py-2 text-gray-700 hover:text-blue-900 font-medium">Kontak</a>
                <div class="pt-3 space-y-2">
                <a href="index.php?page=login" target="_blank" rel="noopener noreferrer" class="block py-2 px-4 text-center bg-blue-900 text-white rounded-lg font-medium hover:bg-blue-800">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Script Toggle Mobile Menu -->
<script>
    // Toggle mobile menu
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
    
    // Close mobile menu saat link diklik
    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.add('hidden');
        });
    });
</script>
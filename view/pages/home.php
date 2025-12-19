<?php 

?>

<!-- Hero Section - Professional & Creative -->
<section class="relative bg-white overflow-hidden" id="home">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-50 rounded-full opacity-60"></div>
        <div class="absolute top-60 -left-20 w-60 h-60 bg-gray-100 rounded-full opacity-40"></div>
        <div class="absolute bottom-20 right-1/4 w-40 h-40 bg-blue-100 rounded-full opacity-30"></div>
    </div>

    <div class="container mx-auto px-4 relative">
        <div class="min-h-[90vh] flex flex-col justify-center py-20">
            <!-- Main Content -->
            <div class="text-center max-w-5xl mx-auto">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-900 bg-opacity-5 border border-blue-900 border-opacity-20 rounded-full mb-8">
                    <svg class="w-4 h-4 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-semibold text-blue-900">Laboratorium Jurusan Teknologi Informasi - Politeknik Negeri Malang</span>
                </div>
                <!-- Main Title -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-6 leading-tight">
                    <span class="block">Intelligent Vision &</span>
                    <span class="block text-blue-900">Smart System</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed font-light">
                    Pusat penelitian dan pengembangan teknologi <span class="font-semibold text-gray-900">Computer Vision</span>, <span class="font-semibold text-gray-900">Artificial Intelligence</span>, dan <span class="font-semibold text-gray-900">Internet of Things</span>
                </p>

                <!-- Scroll Indicator -->
                <div class="text-center mt-16">
                    <a href="#profil" class="inline-flex flex-col items-center gap-2 text-gray-400 hover:text-blue-900 transition-colors">
                        <span class="text-xs font-medium uppercase tracking-wider"></span>
                        <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
</section>


<!-- Profil Lab Section -->
<?php include __DIR__ . '/profil/index.php'; ?>

<!-- Visi & Misi Section -->
<?php include __DIR__ . '/visimisi/index.php'; ?>

<!-- Berita & Artikel Section (Pindah ke atas agar terlihat aktif) -->
<?php include __DIR__ . '/berita/index.php'; ?>

<!-- Galeri Kegiatan Section -->
<?php include __DIR__ . '/galeri/index.php'; ?>

<!-- Riset Unggulan Section (Added) -->
<?php include __DIR__ . '/riset/index.php'; ?>

<!-- Fasilitas Lab Section -->
<?php include __DIR__ . '/fasilitas/index.php'; ?>

<!-- Daftar Peralatan -->
<?php include __DIR__ . '/peralatan/index.php'; ?>

<!-- Anggota Tim Section (Humanize lab sebelum hasil riset) -->
<?php include __DIR__ . '/tim/index.php'; ?>

<!-- Sorotan Publikasi Section (Output/Hasil Kerja) -->
<?php include __DIR__ . '/publikasi/index.php'; ?>

<!-- Perkuliahan Terkait Section -->
<?php include __DIR__ . '/perkuliahan/index.php'; ?>

<!-- Home Page Scripts -->
<?php include __DIR__ . '/home_scripts.php'; ?>







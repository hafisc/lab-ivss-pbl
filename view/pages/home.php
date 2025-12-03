<?php /** home.php - Halaman utama Lab IVSS */ ?>

<!-- Hero Section - Professional & Creative -->
<section class="relative bg-white overflow-hidden">
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

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                    <a href="#profil" class="group px-8 py-4 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-800 transition-all duration-300 hover:shadow-xl hover:scale-105 inline-flex items-center gap-3">
                        <span>Jelajahi Lab</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="index.php?page=register" class="px-8 py-4 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:border-blue-900 hover:text-blue-900 transition-all duration-300 inline-flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Bergabung Sekarang</span>
                    </a>
                </div>

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
<section id="profil" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Profil Laboratorium</h2>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full"></div>
            </div>

            <!-- Content -->
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Image/Logo Card -->
                <div class="space-y-4">
                    <div class="relative group bg-white border-2 border-gray-200 rounded-2xl p-8 hover:border-blue-900 transition-all duration-300 hover:shadow-2xl">
                        <!-- Lab Icon Background -->
                        <div class="absolute top-6 right-6 opacity-5">
                            <svg class="w-32 h-32 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                        </div>

                        <!-- Logo -->
                        <div class="relative z-10 flex flex-col items-center justify-center space-y-6">
                            <img src="assets/images/Logo-lab-IVSS-300x118.png" alt="Lab IVSS Logo" class="w-full max-w-xs h-auto">

                            <!-- Lab Name -->
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-blue-900 mb-2">Lab IVSS</h3>
                                <p class="text-sm text-gray-600 font-medium">Intelligent Vision & Smart System</p>
                            </div>

                            <!-- Location -->
                            <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Gedung Jurusan Teknologi Informasi — Lantai 8 Barat</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text -->
                <div class="space-y-6">
                    <p class="text-gray-700 leading-relaxed text-justify">
                        <span class="text-3xl font-bold text-blue-900 float-left mr-3 leading-none">L</span>
                        aboratorium Intelligent Vision and Smart System (IVSS) merupakan pusat riset dan pengembangan di bidang Computer Vision, Artificial Intelligence, dan Smart System yang berada di bawah naungan Jurusan Teknologi Informasi, Politeknik Negeri Malang.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-justify">
                        Kami fokus pada penelitian dan pengembangan teknologi intelligent vision dan smart system yang inovatif, aplikatif, serta berdaya saing nasional dan internasional untuk mendukung kemajuan bidang teknologi informasi dan industri berbasis kecerdasan buatan.
                    </p>

                    <!-- Features -->
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl">
                            <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Riset Inovatif</div>
                                <div class="text-sm text-gray-600">Penelitian berkelas dunia</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl">
                            <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Fasilitas Modern</div>
                                <div class="text-sm text-gray-600">Peralatan canggih</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi & Misi Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Visi & Misi</h2>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Visi -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Visi</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        Menjadi laboratorium unggulan dalam pengembangan teknologi <span class="font-semibold text-blue-900">Intelligent Vision</span> dan <span class="font-semibold text-blue-900">Smart System</span> yang inovatif, aplikatif, serta berdaya saing nasional dan internasional untuk mendukung kemajuan bidang teknologi informasi dan industri berbasis kecerdasan buatan.
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Misi</h3>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 bg-blue-900 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 leading-relaxed">Melaksanakan penelitian dan inovasi di bidang Computer Vision, AI, dan Smart System</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 bg-blue-900 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 leading-relaxed">Menyediakan fasilitas riset dan pelatihan bagi dosen dan mahasiswa</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-5 h-5 bg-blue-900 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700 leading-relaxed">Mendorong kolaborasi akademik dan industri untuk solusi berkelanjutan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kegiatan & Proyek Section -->
<section id="kegiatan" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Kegiatan & Proyek</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Berbagai riset dan proyek yang sedang berjalan</p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="w-14 h-14 bg-blue-900 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Sistem Cerdas</h3>
                    <p class="text-gray-600 text-sm">Integrasi AI dengan sistem untuk pengambilan keputusan</p>
                </div>

                <div class="bg-purple-50 border border-purple-100 rounded-2xl p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="w-14 h-14 bg-purple-900 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Machine Learning</h3>
                    <p class="text-gray-600 text-sm">Pembelajaran mesin untuk klasifikasi dan clustering</p>
                </div>

                <div class="bg-green-50 border border-green-100 rounded-2xl p-6 hover:shadow-lg transition-shadow duration-300">
                    <div class="w-14 h-14 bg-green-900 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Vision Komputer</h3>
                    <p class="text-gray-600 text-sm">Penerapan teknik AI untuk pengolahan citra dan video</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas & Peralatan Section -->
<section id="fasilitas" class="py-20 bg-white">
    <!-- Fasilitas -->
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Fasilitas & Peralatan</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Peralatan dan infrastruktur riset yang modern</p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Komputer Desktop</h3>
                    <p class="text-gray-600 text-sm">Workstation high-end untuk pengolahan data dan riset</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Camera 260fps</h3>
                    <p class="text-gray-600 text-sm">Kamera berkecepatan tinggi untuk analisis visual</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Perangkat IoT</h3>
                    <p class="text-gray-600 text-sm">Sensor dan microcontroller untuk prototyping</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Server GPU</h3>
                    <p class="text-gray-600 text-sm">Server dengan GPU untuk training deep learning</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Camera DSLR</h3>
                    <p class="text-gray-600 text-sm">Kamera profesional untuk dataset berkualitas tinggi</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Ruang Penelitian</h3>
                    <p class="text-gray-600 text-sm">Ruang lab yang nyaman dan kondusif untuk riset</p>
                </div>

                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-blue-900 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Mushola</h3>
                    <p class="text-gray-600 text-sm">Ruang ibadah yang nyaman dan tenang untuk berdoa</p>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <!-- Daftar Peralatan Dinamis -->
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Daftar Peralatan</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Peralatan yang tersedia di Lab IVSS</p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <?php if (!empty($equipmentForLanding) && is_array($equipmentForLanding)): ?>
                    <?php foreach ($equipmentForLanding as $equip): ?>
                        <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="w-25 h-25 mx-auto mb-4 rounded-2xl overflow-hidden bg-blue-900 flex items-center justify-center">
                                <?php if (!empty($equip['image'])): ?>
                                    <img src="<?= htmlspecialchars($equip['image']) ?>"
                                         alt="<?= htmlspecialchars($equip['name']) ?>"
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <!-- fallback icon jika belum ada gambar -->
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                <?= htmlspecialchars($equip['name']) ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-1">
                                <?= htmlspecialchars($equip['category'] ?? '') ?>
                                <?php if (!empty($equip['brand'])): ?>
                                    • <?= htmlspecialchars($equip['brand']) ?>
                                <?php endif; ?>
                            </p>
                            <p class="text-xs text-gray-500 mb-1">
                                Jumlah: <?= (int)($equip['quantity'] ?? 0) ?>
                            </p>
                            <?php if (!empty($equip['condition'])): ?>
                                <p class="text-xs text-gray-500 mb-1">
                                    Kondisi: <?= htmlspecialchars($equip['condition']) ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($equip['location'])): ?>
                                <p class="text-xs text-gray-500">
                                    Lokasi: <?= htmlspecialchars($equip['location']) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-3 text-center text-gray-500">
                        Belum ada data peralatan yang ditambahkan.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<br><br><br>

<!-- Sorotan Publikasi Section -->
<section id="publikasi" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Sorotan Publikasi</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Penelitian dan karya ilmiah terbaru dari Lab IVSS</p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex justify-center items-center gap-3 mb-12">
                <button id="filterCited" class="filter-btn px-6 py-2.5 bg-blue-900 text-white rounded-full font-semibold text-sm hover:bg-blue-800 transition-all duration-300 shadow-md" data-filter="cited">
                    Paling Banyak Dikutip
                </button>
                <button id="filterLatest" class="filter-btn px-6 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-full font-semibold text-sm hover:border-blue-900 hover:text-blue-900 transition-all duration-300" data-filter="latest">
                    Terbaru
                </button>
                <button id="filterOldest" class="filter-btn px-6 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-full font-semibold text-sm hover:border-blue-900 hover:text-blue-900 transition-all duration-300" data-filter="oldest">
                    Terlama
                </button>
            </div>

            <!-- Publikasi Swiper -->
            <div class="relative">
                <div class="swiper publicationSwiper">
                    <div class="swiper-wrapper pb-12">
                        <?php
                        if ($publications && is_array($publications) && count($publications) > 0):
                            foreach ($publications as $pub):
                                // Truncate abstract untuk excerpt
                                $abstract = $pub['abstract'] ?? '';
                                $excerpt = strlen($abstract) > 150 ? substr($abstract, 0, 150) . '...' : $abstract;

                                // Determine publication venue (journal or conference)
                                $venue = !empty($pub['journal']) ? $pub['journal'] : ($pub['conference'] ?? 'Conference');
                        ?>
                            <div class="swiper-slide">
                                <div class="group relative bg-blue-50 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                                    <!-- Featured Badge (jika citation tinggi) -->
                                    <?php if (!empty($pub['citations']) && $pub['citations'] > 20): ?>
                                        <div class="absolute top-4 right-4 w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>

                                    <div class="mb-4">
                                        <span class="inline-block px-3 py-1 bg-blue-900 text-white text-xs font-semibold rounded-full">
                                            <?= htmlspecialchars($pub['year']) ?>
                                        </span>
                                        <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full ml-2">
                                            <?= isset($pub['type']) ? ucfirst(htmlspecialchars($pub['type'])) : 'Journal' ?>
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-900 mb-3 <?= (!empty($pub['citations']) && $pub['citations'] > 20) ? 'pr-12' : '' ?>">
                                        <?= htmlspecialchars($pub['title']) ?>
                                    </h3>

                                    <p class="text-xs text-gray-500 mb-2">
                                        <strong>Authors:</strong> <?= htmlspecialchars($pub['authors']) ?>
                                    </p>

                                    <p class="text-xs text-blue-800 font-medium mb-3">
                                        <?= htmlspecialchars($venue) ?>
                                    </p>

                                    <p class="text-gray-600 text-sm mb-4 flex-grow">
                                        <?= htmlspecialchars($excerpt) ?>
                                    </p>

                                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 mt-auto">
                                        <div class="flex items-center gap-2 text-sm text-gray-500">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 005.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                                            </svg>
                                            <span><?= (int)($pub['citations'] ?? 0) ?> Sitasi</span>
                                        </div>

                                        <?php if (!empty($pub['doi'])): ?>
                                            <a href="https://doi.org/<?= htmlspecialchars($pub['doi']) ?>" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-900 hover:text-blue-700 transition-colors">
                                                DOI
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end swiper-slide -->
                        <?php
                            endforeach;
                        else:
                        ?>
                            <div class="swiper-slide">
                                <div class="bg-blue-50 rounded-2xl p-8 text-center">
                                    <p class="text-gray-600">Belum ada publikasi tersedia.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center gap-3 px-8 py-4 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-800 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    Lihat Semua Publikasi
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Berita & Artikel Section -->
<section id="berita" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Berita & Artikel Terbaru</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Update terkini seputar kegiatan dan pencapaian Lab IVSS</p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <!-- News Swiper -->
            <div class="relative news-swiper-container">
                <div class="swiper newsSwiper">
                    <div class="swiper-wrapper pb-12">
                        <?php
                        if ($latestNews && is_array($latestNews) && count($latestNews) > 0):
                            foreach ($latestNews as $news):
                                // Truncate excerpt
                                $excerpt = !empty($news['excerpt']) ? $news['excerpt'] : substr(strip_tags($news['content']), 0, 120);
                                if (strlen($excerpt) > 120) {
                                    $excerpt = substr($excerpt, 0, 120) . '...';
                                }

                                // Format date
                                $publishDate = !empty($news['published_at'])
                                    ? date('d M Y', strtotime($news['published_at']))
                                    : date('d M Y', strtotime($news['created_at']));
                        ?>
                            <div class="swiper-slide">
                                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                                    <!-- Image -->
                                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600">
                                        <?php if (!empty($news['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($news['image_url']) ?>"
                                                 alt="<?= htmlspecialchars($news['title']) ?>"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Overlay Gradient -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6 flex flex-col flex-grow">
                                        <!-- Meta Info -->
                                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span><?= $publishDate ?></span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                <span><?= number_format($news['views'] ?? 0) ?> views</span>
                                            </div>
                                        </div>

                                        <!-- Title -->
                                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-900 transition-colors">
                                            <?= htmlspecialchars($news['title']) ?>
                                        </h3>

                                        <!-- Excerpt -->
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                                            <?= htmlspecialchars($excerpt) ?>
                                        </p>

                                        <!-- Read More Button -->
                                        <a href="index.php?page=news&slug=<?= htmlspecialchars($news['slug']) ?>"
                                           class="inline-flex items-center gap-2 text-blue-900 font-semibold text-sm hover:gap-3 transition-all mt-auto">
                                            Baca Selengkapnya
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <div class="swiper-slide">
                                <div class="bg-white rounded-2xl p-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-700 mb-2">Belum Ada Berita</h3>
                                    <p class="text-gray-500">Berita dan artikel akan segera ditambahkan.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="index.php?page=news"
                   class="inline-flex items-center gap-3 px-8 py-4 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-800 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    Lihat Semua Berita
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Pass PHP data to JavaScript -->
<script>
    const publicationsData = <?php echo json_encode($publications ?? []); ?>;
</script>

<!-- Initialize Swiper & Filter -->
<script>
    let publicationSwiper = null;
    let newsSwiper = null;

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Swipers
        initSwiper();
        initNewsSwiper();

        // Filter buttons functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                // Remove active class from all buttons
                filterButtons.forEach(b => {
                    b.classList.remove('bg-blue-900', 'text-white', 'shadow-md');
                    b.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
                });

                // Add active class to clicked button
                this.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
                this.classList.add('bg-blue-900', 'text-white', 'shadow-md');

                // Filter publications
                const filterType = this.getAttribute('data-filter');
                filterPublications(filterType);
            });
        });

        // Default tampilan: paling banyak dikutip
        filterPublications('cited');
    });

    function initSwiper() {
        publicationSwiper = new Swiper('.publicationSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.publicationSwiper .swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    }

    function initNewsSwiper() {
        newsSwiper = new Swiper('.newsSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.newsSwiper .swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    }

    function filterPublications(filterType) {
        let sortedData = [...publicationsData];

        // Sort based on filter type
        switch (filterType) {
            case 'cited':
                sortedData.sort((a, b) => (b.citations || 0) - (a.citations || 0));
                break;
            case 'latest':
                sortedData.sort((a, b) => (b.year || 0) - (a.year || 0));
                break;
            case 'oldest':
                sortedData.sort((a, b) => (a.year || 0) - (b.year || 0));
                break;
        }

        // Update swiper slides
        updateSwiperSlides(sortedData);
    }

    function updateSwiperSlides(data) {
        if (!publicationSwiper) return;

        // Remove all slides
        publicationSwiper.removeAllSlides();

        // Add new slides
        data.forEach(pub => {
            const abstract = pub.abstract || '';
            const excerpt = abstract.length > 150 ? abstract.substring(0, 150) + '...' : abstract;
            const venue = pub.journal || pub.conference || 'Conference';
            const citations = pub.citations || 0;

            const slideHTML = `
                <div class="swiper-slide">
                    <div class="group relative bg-blue-50 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                        ${citations > 20 ? `
                        <div class="absolute top-4 right-4 w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>` : ''}

                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 bg-blue-900 text-white text-xs font-semibold rounded-full">
                                ${pub.year || ''}
                            </span>
                            <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full ml-2">
                                ${pub.type ? (pub.type.charAt(0).toUpperCase() + pub.type.slice(1)) : ''}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3 ${citations > 20 ? 'pr-12' : ''}">
                            ${pub.title || ''}
                        </h3>

                        <p class="text-sm text-gray-600 mb-3 font-medium">
                            ${pub.authors || ''}
                        </p>

                        <p class="text-sm text-blue-900 mb-3 font-semibold">
                            ${venue}
                        </p>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-3 flex-grow">
                            ${excerpt}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 mt-auto">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-gray-700">
                                    ${citations} Citations
                                </span>
                            </div>
                            ${pub.doi ? `
                            <a href="https://doi.org/${pub.doi}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-900 hover:text-blue-700 transition-colors">
                                DOI
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>` : ''}
                        </div>
                    </div>
                </div>
            `;

            publicationSwiper.appendSlide(slideHTML);
        });

        // Update swiper
        publicationSwiper.update();
    }
</script>

<style>
    /* Custom Swiper Styling */
    .publicationSwiper {
        padding: 0 0 50px;
    }

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #1e3a8a;
        opacity: 0.3;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
        background: #1e3a8a;
    }
</style>

<!-- Anggota Tim Section -->
<section id="tim" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M12 10a5 5 0 110-10 5 5 0 010 10z"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Anggota Tim</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Dosen Peneliti dan Asisten Laboratorium Inti</p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

                <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full border-4 border-blue-900 shadow-lg">
                        <img src="https://via.placeholder.com/128/1e3a8a/ffffff?text=Dosen+1" alt="Foto Dosen 1" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-blue-900 mb-1">Dr. [Nama Dosen 1]</h3>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Kepala Laboratorium</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Fokus Riset: Computer Vision & AI</p>
                        <p class="font-medium">NIP: 198001012005011001</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full border-4 border-blue-900/50 shadow-lg">
                        <img src="https://via.placeholder.com/128/1e3a8a/ffffff?text=Dosen+2" alt="Foto Dosen 2" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Ir. [Nama Dosen 2], M.Kom</h3>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Dosen Peneliti</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Fokus Riset: Smart System & IoT</p>
                        <p class="font-medium">NIP: 198505052010012002</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full border-4 border-blue-900/20 shadow-lg">
                        <img src="https://via.placeholder.com/128/9ca3af/ffffff?text=Asisten+1" alt="Foto Asisten 1" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">[Nama Asisten 1], S.Tr.Kom</h3>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Asisten Lab Koordinator</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Fokus Riset: Deep Learning</p>
                        <p class="font-medium">Tahun: 2024</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full border-4 border-blue-900/20 shadow-lg">
                        <img src="https://via.placeholder.com/128/9ca3af/ffffff?text=Asisten+2" alt="Foto Asisten 2" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">[Nama Asisten 2]</h3>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Asisten Lab Riset</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Fokus Riset: Data Science</p>
                        <p class="font-medium">Tahun: 2024</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full border-4 border-blue-900/20 shadow-lg">
                        <img src="https://via.placeholder.com/128/9ca3af/ffffff?text=Asisten+2" alt="Foto Asisten 2" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">[Nama Asisten 2]</h3>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Asisten Lab Riset</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Fokus Riset: Data Science</p>
                        <p class="font-medium">Tahun: 2024</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full border-4 border-blue-900/20 shadow-lg">
                        <img src="https://via.placeholder.com/128/9ca3af/ffffff?text=Asisten+2" alt="Foto Asisten 2" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">[Nama Asisten 2]</h3>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Asisten Lab Riset</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Fokus Riset: Data Science</p>
                        <p class="font-medium">Tahun: 2024</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                    <div class="w-32 h-32 mx-auto mb-4 overflow-hidden rounded-full border-4 border-blue-900/20 shadow-lg">
                        <img src="https://via.placeholder.com/128/9ca3af/ffffff?text=Asisten+2" alt="Foto Asisten 2" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">[Nama Asisten 2]</h3>
                    <p class="text-sm font-semibold text-gray-700 mb-3">Asisten Lab Riset</p>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Fokus Riset: Data Science</p>
                        <p class="font-medium">Tahun: 2024</p>
                    </div>
                </div>

                

            </div>
        </div>
    </div>
</section>

<!-- Perkuliahan Terkait Section -->
<?php
$dataFile = __DIR__ . '/../../app/data/perkuliahan.json';
$perkuliahan = null;
if (file_exists($dataFile)) {
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $perkuliahan = $decoded;
}
?>
<section id="perkuliahan" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    <?= htmlspecialchars($perkuliahan['heading'] ?? 'Perkuliahan Terkait') ?>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    <?= htmlspecialchars($perkuliahan['subtitle'] ?? 'Mata kuliah yang berkaitan dengan Lab IVSS') ?>
                </p>
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <?php
                $items = $perkuliahan['items'] ?? [
                    ['title' => 'Kecerdasan Artifisial (AI)', 'description' => 'Teknologi yang fokus pada pembelajaran tugas-tugas berbasis manusia seperti pengenalan pola'],
                    ['title' => 'Machine Learning', 'description' => 'Cabang dari kecerdasan artifisial yang memungkinkan mesin belajar dari data'],
                    ['title' => 'Pengolahan Citra dan Visi Komputer', 'description' => 'Menganalisis gambar atau video untuk ekstraksi pola, deteksi objek, segmentasi, dan lainnya'],
                    ['title' => 'Sistem Cerdas (Intelligent System)', 'description' => 'Pengembangan sistem yang dapat melakukan keputusan otomatis, penanganan informasi dalam konteks aplikasi nyata']
                ];

                foreach ($items as $it):
                ?>
                    <div class="flex items-start gap-4 bg-blue-50 rounded-2xl p-6 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars($it['title']) ?></h3>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($it['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

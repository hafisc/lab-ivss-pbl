<!-- Bagian Berita & Artikel -->
<!-- Menampilkan berita terbaru seputar aktivitas laboratorium -->
<section id="berita" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Seksi -->
            <div class="text-center mb-16">
                <!-- Ikon Berita -->
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <!-- Judul Seksi -->
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Berita & Artikel Terbaru</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Update terkini seputar kegiatan dan pencapaian Lab IVSS</p>
                <!-- Elemen Garis Dekoratif -->
                <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <!-- Kontainer Slider Berita -->
            <div class="relative news-swiper-container">
                <div class="swiper newsSwiper">
                    <div class="swiper-wrapper pb-12">
                        <?php
                        // Memastikan variabel $latestNews ada dan berisi array
                        if (isset($latestNews) && is_array($latestNews) && count($latestNews) > 0):
                            foreach ($latestNews as $news):
                                // Memotong konten untuk kutipan singkat (excerpt)
                                $excerpt = !empty($news['excerpt']) ? $news['excerpt'] : substr(strip_tags($news['content']), 0, 120);
                                if (strlen($excerpt) > 120) {
                                    $excerpt = substr($excerpt, 0, 120) . '...';
                                }

                                // Format tanggal publikasi
                                $publishDate = !empty($news['published_at'])
                                    ? date('d M Y', strtotime($news['published_at']))
                                    : date('d M Y', strtotime($news['created_at']));
                        ?>
                            <!-- Item Slide Berita -->
                            <div class="swiper-slide">
                                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                                    <!-- Gambar Thumbnail -->
                                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600">
                                        <?php if (!empty($news['image_url'])): ?>
                                            <img src="<?= htmlspecialchars($news['image_url']) ?>"
                                                 alt="<?= htmlspecialchars($news['title']) ?>"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <?php else: ?>
                                            <!-- Ikon Placeholder Jika Gambar Kosong -->
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Overlay Gradien untuk memperjelas teks di atas gambar (jika ada) -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    </div>

                                    <!-- Konten Berita -->
                                    <div class="p-6 flex flex-col flex-grow">
                                        <!-- Meta Informasi: Tanggal & Views -->
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

                                        <!-- Judul Artikel -->
                                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-900 transition-colors">
                                            <?= htmlspecialchars($news['title']) ?>
                                        </h3>

                                        <!-- Ringkasan Artikel -->
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                                            <?= htmlspecialchars($excerpt) ?>
                                        </p>

                                        <!-- Tombol Aksi (Baca Selengkapnya / Download) -->
                                        <?php if (!empty($news['file_path'])): ?>
                                        <a href="<?= htmlspecialchars($news['file_path']) ?>" target="_blank" download
                                           class="inline-flex items-center gap-2 text-green-700 font-semibold text-sm hover:gap-3 transition-all mt-auto">
                                            Download Selengkapnya
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                        </a>
                                        <?php else: ?>
                                        <a href="index.php?page=news&slug=<?= htmlspecialchars($news['slug']) ?>"
                                           class="inline-flex items-center gap-2 text-blue-900 font-semibold text-sm hover:gap-3 transition-all mt-auto">
                                            Baca Selengkapnya
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <!-- Tampilan Fallback Jika Tidak Ada Berita -->
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

                    <!-- Paginasi Slider -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- Tombol Navigasi ke Halaman Arsip Berita -->
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

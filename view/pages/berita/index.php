<!-- Halaman Daftar Berita -->
<!-- Menampilkan daftar seluruh berita dan artikel yang telah dipublikasikan -->
<div class="pt-24 pb-16 min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <!-- Header Halaman -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Berita & Artikel</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Update terkini seputar kegiatan dan pencapaian Lab IVSS</p>
            <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
        </div>

        <!-- Grid Berita -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($latestNews)): ?>
                <?php foreach ($latestNews as $news): ?>
                    <!-- Kartu Berita -->
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                        
                        <!-- Gambar Berita -->
                        <div class="relative h-48 overflow-hidden bg-gray-200">
                            <?php if (!empty($news['image_url'])): ?>
                                <img src="<?= htmlspecialchars($news['image_url']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <!-- Placeholder Image -->
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Tanggal Publikasi (Badge) -->
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-blue-900 shadow-sm">
                                <?= date('d M Y', strtotime($news['published_at'])) ?>
                            </div>
                        </div>

                        <!-- Konten Berita -->
                        <div class="p-6 flex flex-col flex-grow">
                            <!-- Judul -->
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-900 transition-colors">
                                <a href="index.php?page=news&slug=<?= htmlspecialchars($news['slug']) ?>">
                                    <?= htmlspecialchars($news['title']) ?>
                                </a>
                            </h3>
                            
                            <!-- Kutipan / Excerpt -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                <?= !empty($news['excerpt']) ? htmlspecialchars($news['excerpt']) : substr(strip_tags($news['content']), 0, 100) . '...' ?>
                            </p>
                            
                            <!-- Footer Kartu -->
                            <div class="mt-auto flex items-center justify-between">
                                <!-- Views -->
                                <span class="text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <?= number_format($news['views'] ?? 0) ?> views
                                </span>
                                
                                <!-- Link Baca Selengkapnya -->
                                <a href="index.php?page=news&slug=<?= htmlspecialchars($news['slug']) ?>" class="text-blue-900 font-semibold text-sm hover:underline">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Tampilan Kosong -->
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-500 text-lg">Belum ada berita yang diterbitkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

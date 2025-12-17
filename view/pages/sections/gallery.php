<!-- Bagian Galeri Kegiatan -->
<!-- Menampilkan galeri foto kegiatan dalam bentuk slider carousel -->
<section id="gallery" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            
            <!-- Header Seksi -->
            <div class="text-center mb-16">
                 <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                 </div>
                 <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Galeri Kegiatan</h2>
                 <p class="text-xl text-gray-600 max-w-2xl mx-auto">Dokumentasi aktivitas di Lab IVSS</p>
                 <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
            </div>

            <!-- Kontainer Swiper Slider -->
            <div class="relative gallery-swiper-container">
                 <div class="swiper gallerySwiper">
                      <div class="swiper-wrapper pb-12">
                           <!-- Loop Item Galeri -->
                           <?php if (!empty($galleryItems)): ?>
                               <?php foreach ($galleryItems as $item): ?>
                                   <div class="swiper-slide">
                                       <!-- Kartu Item Galeri -->
                                       <div class="rounded-2xl overflow-hidden shadow-lg h-80 relative group cursor-pointer gallery-item"
                                            data-image="<?= htmlspecialchars($item['image_path']) ?>"
                                            data-title="<?= htmlspecialchars($item['title'] ?? '') ?>"
                                            data-description="<?= htmlspecialchars($item['description'] ?? '') ?>">
                                            
                                           <!-- Gambar Latar -->
                                           <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                           
                                           <!-- Overlay Gradien & Teks -->
                                           <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6 opacity-90 group-hover:opacity-100 transition-opacity">
                                               <h3 class="text-white font-bold text-xl mb-1"><?= htmlspecialchars($item['title'] ?? '') ?></h3>
                                               <?php if (!empty($item['description'])): ?>
                                               <p class="text-gray-200 text-sm line-clamp-2"><?= htmlspecialchars($item['description']) ?></p>
                                               <?php endif; ?>
                                           </div>
                                       </div>
                                   </div>
                               <?php endforeach; ?>
                           <?php else: ?>
                               <!-- Tampilan Kosong jika tidak ada data -->
                               <div class="swiper-slide">
                                   <div class="h-80 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400">
                                       Belum ada foto kegiatan.
                                   </div>
                               </div>
                           <?php endif; ?>
                      </div>
                      
                      <!-- Paginasi Slide -->
                      <div class="swiper-pagination"></div>
                 </div>
            </div>
        </div>
    </div>
</section>

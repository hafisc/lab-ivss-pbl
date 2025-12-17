<!-- Bagian Fasilitas Lab -->
<!-- Menampilkan daftar fasilitas laboratorium dalam bentuk slider -->
<div class="container mx-auto px-4" id="fasilitas">
    <div class="max-w-7xl mx-auto">
        
        <!-- Header Seksi -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Fasilitas Lab</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Fasilitas yang tersedia di Lab IVSS</p>
            <div class="h-1 w-24 bg-blue-900 mx-auto rounded-full mt-4"></div>
        </div>

        <!-- Kontainer Swiper Fasilitas -->
        <div class="relative fasilitas-swiper-container">
            <div class="swiper fasilitasSwiper">
                <div class="swiper-wrapper pb-12">
                    
                    <!-- Loop Data Fasilitas -->
                    <?php if (!empty($facilities)): ?>
                        <?php foreach ($facilities as $facility): ?>
                            <div class="swiper-slide">
                                <div class="flex flex-col h-full rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-2xl transition-all duration-300">
                                    
                                    <!-- Bagian Atas: Gambar Background & Ikon -->
                                    <div class="relative h-60 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                         <?php if (!empty($facility['image'])): ?>
                                            <img src="<?= htmlspecialchars($facility['image']) ?>" alt="<?= htmlspecialchars($facility['name']) ?>" class="absolute inset-0 w-full h-full object-cover"/>
                                         <?php else: ?>
                                            <!-- Placeholder Image -->
                                            <img src="assets/images/ralfs-blumbergs--EXF9shcTO0-unsplash.jpg" alt="Facility" class="absolute inset-0 w-full h-full object-cover opacity-50"/>
                                         <?php endif; ?>
                                      
                                      <!-- Ikon Tengah -->
                                      <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center relative z-10">
                                        <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                      </div>
                                    </div>

                                    <!-- Bagian Bawah: Konten Teks -->
                                    <div class="p-6 flex flex-col flex-grow">
                                      <h3 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars($facility['name']) ?></h3>
                                      <p class="text-sm text-gray-600 mb-4">
                                        <?= htmlspecialchars($facility['description']) ?>
                                      </p>
                                      
                                      <span class="mt-auto inline-flex items-center text-sm font-semibold text-blue-900">
                                        Lihat Detail
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                      </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Tampilan Fallback jika data kosong -->
                        <div class="swiper-slide">
                            <div class="flex flex-col h-full rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-2xl transition-all duration-300">
                                <div class="relative h-60 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                     <img src="assets/images/ralfs-blumbergs--EXF9shcTO0-unsplash.jpg" alt="Camera DSLR" class="absolute inset-0 w-full h-full object-cover"/>
                                  <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                  </div>
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                  <h3 class="text-lg font-bold text-gray-900 mb-2">Fasilitas Lab</h3>
                                  <p class="text-sm text-gray-600 mb-4">
                                    Berbagai fasilitas modern tersedia untuk mendukung riset.
                                  </p>
                                </div>
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

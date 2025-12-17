<!-- Bagian Daftar Peralatan -->
<!-- Menampilkan daftar peralatan yang tersedia di Lab -->
<div class="container mx-auto px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Seksi -->
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

        <!-- Kontainer Swiper Peralatan -->
        <div class="relative equipment-swiper-container">
            <div class="swiper equipmentSwiper">
                <div class="swiper-wrapper pb-12">
                    <!-- Iterasi Data Peralatan -->
                    <?php if (!empty($equipmentForLanding) && is_array($equipmentForLanding)): ?>
                        <?php foreach ($equipmentForLanding as $equip): ?>
                            <div class="swiper-slide">
                                <div class="bg-blue-50 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 h-full flex flex-col items-center justify-start">
                                    
                                    <!-- Gambar Peralatan -->
                                    <div class="w-24 h-24 mx-auto mb-4 rounded-2xl overflow-hidden bg-blue-900 flex items-center justify-center">
                                        <?php if (!empty($equip['image'])): ?>
                                            <img src="<?= htmlspecialchars($equip['image']) ?>" alt="<?= htmlspecialchars($equip['name']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <!-- Ikon Placeholder -->
                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Informasi Peralatan -->
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">
                                        <?= htmlspecialchars($equip['name']) ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <?= htmlspecialchars($equip['category'] ?? '') ?>
                                        <?php if (!empty($equip['brand'])): ?>
                                            • <?= htmlspecialchars($equip['brand']) ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-xs text-gray-500 mb-1">
                                        Qty: <?= (int)($equip['quantity'] ?? 0) ?>
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
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Pesan Jika Data Kosong -->
                        <div class="swiper-slide">
                            <div class="bg-blue-50 rounded-2xl p-8 text-center text-gray-500">
                                Belum ada data peralatan yang ditambahkan.
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

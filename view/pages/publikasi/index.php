<?php
// Pastikan variabel $publications tersedia.
?>
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
                                <!-- Featured Badge (jika featured dan citation tinggi) -->
                                <?php if($pub['citations'] > 20): ?>
                                <div class="absolute top-4 right-4 w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <?php endif; ?>
                                
                                <div class="mb-4">
                                    <span class="inline-block px-3 py-1 bg-blue-900 text-white text-xs font-semibold rounded-full"><?= $pub['year'] ?></span>
                                    <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full ml-2"><?= ucfirst($pub['type']) ?></span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-3 <?= $pub['citations'] > 20 ? 'pr-12' : '' ?>"><?= htmlspecialchars($pub['title']) ?></h3>
                                
                                <p class="text-xs text-gray-500 mb-2">
                                    <strong>Authors:</strong> <?= htmlspecialchars($pub['authors']) ?>
                                </p>
                                
                                <p class="text-xs text-blue-800 font-medium mb-3"><?= htmlspecialchars($venue) ?></p>
                                
                                <p class="text-gray-600 text-sm mb-4 flex-grow"><?= htmlspecialchars($excerpt) ?></p>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 005.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                                    </div>
                                    
                                    <?php if(!empty($pub['doi'])): ?>
                                    <a href="https://doi.org/<?= htmlspecialchars($pub['doi']) ?>" target="_blank" class="inline-flex items-center gap-2 text-blue-900 font-semibold hover:gap-3 transition-all text-sm">
                                        DOI
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <?php endif; ?>

                                    <?php if(!empty($pub['file_path'])): ?>
                                    <a href="<?= htmlspecialchars($pub['file_path']) ?>" target="_blank" class="inline-flex items-center gap-2 text-green-700 font-semibold hover:gap-3 transition-all text-sm ml-4">
                                        PDF
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </a>
                                    <?php endif; ?>

                                    <?php if(!empty($pub['url'])): ?>
                                    <a href="<?= htmlspecialchars($pub['url']) ?>" target="_blank" class="inline-flex items-center gap-2 text-blue-700 font-semibold hover:gap-3 transition-all text-sm ml-4">
                                        Read
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
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

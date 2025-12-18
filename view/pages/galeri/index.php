<?php
// Pastikan variabel $galleryItems tersedia, jika tidak, fetch dari model (opsional, jika file ini di-include dari controller/home, variabel ini sudah ada)
// Jika menjadi halaman mandiri, perlu logic fetch data.
?>
<!-- Galeri Kegiatan Section -->
<section id="gallery" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
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

            <!-- Swiper -->
            <div class="relative gallery-swiper-container">
                 <div class="swiper gallerySwiper">
                      <div class="swiper-wrapper pb-12">
                           <?php if (!empty($galleryItems)): ?>
                               <?php foreach ($galleryItems as $item): ?>
                                   <div class="swiper-slide">
                                       <div class="rounded-2xl overflow-hidden shadow-lg h-80 relative group cursor-pointer gallery-item"
                                            data-image="<?= htmlspecialchars($item['image_path']) ?>"
                                            data-title="<?= htmlspecialchars($item['title'] ?? '') ?>"
                                            data-description="<?= htmlspecialchars($item['description'] ?? '') ?>">
                                           <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
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
                               <div class="swiper-slide">
                                   <div class="h-80 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400">
                                       Belum ada foto kegiatan.
                                   </div>
                               </div>
                           <?php endif; ?>
                      </div>
                      <div class="swiper-pagination"></div>
                 </div>
            </div>
        </div>
    </div>
</section>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/95 transition-opacity backdrop-blur-sm" onclick="closeGalleryModal()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">
                
                <!-- Close Button -->
                <button type="button" class="absolute top-0 right-0 z-20 m-4 p-2 rounded-full bg-black/50 text-white hover:bg-white hover:text-black transition-all duration-300 focus:outline-none" onclick="closeGalleryModal()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <div class="flex flex-col items-center justify-center p-2">
                    <img id="modalImage" src="" alt="Gallery Image" class="max-h-[85vh] w-auto max-w-full object-contain rounded-lg shadow-2xl mb-6">
                    
                    <div class="text-center max-w-2xl px-4 animate-fade-in-up">
                        <h3 id="modalTitle" class="text-2xl font-bold text-white mb-2 tracking-wide"></h3>
                        <p id="modalDescription" class="text-gray-300 text-base leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Variable Gallery Count from PHP
    const galleryCount = <?php echo !empty($galleryItems) ? count($galleryItems) : 0; ?>;
    let gallerySwiper = null;

    document.addEventListener('DOMContentLoaded', function() {
        initGallerySwiper();
    });

    function initGallerySwiper() {
        const enableLoop = galleryCount > 3;
        gallerySwiper = new Swiper('.gallerySwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: enableLoop,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.gallerySwiper .swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: { slidesPerView: 1, spaceBetween: 20 },
                768: { slidesPerView: 2, spaceBetween: 30 },
                1024: { slidesPerView: 3, spaceBetween: 30 },
            },
        });
    }

    function openGalleryModal(image, title, description) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDescription');
        
        modalImg.src = image;
        modalTitle.textContent = title;
        modalDesc.textContent = description;
        
        modal.classList.remove('hidden');
        // Add simple fade in effect
        modal.classList.add('animate-fade-in');
        
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeGalleryModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
        
        // Clear src after closing to ensure next load is fresh
        setTimeout(() => {
            document.getElementById('modalImage').src = '';
        }, 200);
    }
    
    // Event Delegation for Gallery Items (handles Swiper loop clones)
    document.addEventListener('click', function(e) {
        const item = e.target.closest('.gallery-item');
        if (item) {
            const img = item.getAttribute('data-image');
            const title = item.getAttribute('data-title');
            const desc = item.getAttribute('data-description');
            openGalleryModal(img, title, desc);
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGalleryModal();
        }
    });
</script>

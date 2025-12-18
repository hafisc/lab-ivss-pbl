<?php
// Pastikan variabel $facilities tersedia.
?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">
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

            <!-- Swiper Fasilitas -->
            <div class="relative fasilitas-swiper-container">
                <div class="swiper fasilitasSwiper">
                    <div class="swiper-wrapper pb-12">
                        <?php if (!empty($facilities)): ?>
                            <?php foreach ($facilities as $facility): ?>
                            <div class="swiper-slide">
                                <div class="flex flex-col h-full rounded-2xl overflow-hidden bg-white shadow-md hover:shadow-2xl transition-all duration-300">
                                    <!-- Bagian atas: background gradien + ikon -->
                                    <div class="relative h-60 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                        <?php if (!empty($facility['image'])): ?>
                                            <img src="<?= htmlspecialchars($facility['image']) ?>" alt="<?= htmlspecialchars($facility['name']) ?>" class="absolute inset-0 w-full h-full object-cover"/>
                                        <?php else: ?>
                                            <img src="assets/images/ralfs-blumbergs--EXF9shcTO0-unsplash.jpg" alt="Facility" class="absolute inset-0 w-full h-full object-cover opacity-50"/>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Bagian bawah: konten -->
                                    <div class="p-6 flex flex-col flex-grow">
                                        <h3 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars($facility['name']) ?></h3>
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                            <?= htmlspecialchars($facility['description']) ?>
                                        </p>
                                        <a href="index.php?page=facility&id=<?= $facility['id'] ?>" 
                                           class="mt-auto inline-flex items-center text-sm font-semibold text-blue-900 cursor-pointer hover:text-blue-600 transition-colors">
                                            Lihat Detail
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="swiper-slide">
                                <div class="flex flex-col h-full rounded-2xl overflow-hidden bg-white shadow-md p-6 items-center justify-center text-center">
                                    <p class="text-gray-500">Belum ada fasilitas tersedia.</p>
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

<!-- Facility Modal -->
<div id="facilityModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-2xl max-w-2xl w-full overflow-hidden shadow-2xl transform transition-all animate-fade-in">
            
            <button onclick="closeModal()" class="absolute top-4 right-4 z-20 bg-black/50 hover:bg-black text-white rounded-full p-2 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="w-full bg-gray-100 flex justify-center items-center">
                <img id="modalImage" src="" alt="" 
                     class="w-full h-auto max-h-[70vh] object-contain block mx-auto">
            </div>

            <div class="p-6">
                <h2 id="modalTitle" class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 border-b pb-2"></h2>
                <div class="max-h-40 overflow-y-auto"> 
                    <p id="modalDescription" class="text-gray-600 leading-relaxed whitespace-pre-wrap text-sm sm:text-base"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Fungsi untuk membuka modal dan mengisi datanya
     */
    function openModal(name, description, image) {
        const modal = document.getElementById('facilityModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDescription');
        const modalImg = document.getElementById('modalImage');

        // Mengisi konten secara dinamis
        modalTitle.textContent = name;
        modalDesc.textContent = description; // textContent menjaga keamanan dari script jahat
        modalImg.src = image || 'assets/images/ralfs-blumbergs--EXF9shcTO0-unsplash.jpg';
        modalImg.alt = name;

        // Menampilkan modal
        modal.classList.remove('hidden');
        
        // Mematikan scroll pada latar belakang (body)
        document.body.style.overflow = 'hidden';
    }

    /**
     * Fungsi untuk menutup modal
     */
    function closeModal() {
        const modal = document.getElementById('facilityModal');
        modal.classList.add('hidden');
        
        // Mengembalikan fungsi scroll pada body
        document.body.style.overflow = 'auto';
    }

    // Menutup modal jika user menekan tombol 'Esc' di keyboard
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });
</script>

<style>
    /* Animasi sederhana agar modal muncul lebih halus */
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

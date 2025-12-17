<!-- Modal Preview Gambar -->
<!-- Modal ini digunakan untuk menampilkan gambar galeri dalam ukuran besar -->
<div id="imageModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Latar Belakang Gelap dengan Efek Blur (Backdrop) -->
    <!-- Klik pada area ini akan menutup modal -->
    <div class="fixed inset-0 bg-black/95 transition-opacity backdrop-blur-sm" onclick="closeGalleryModal()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">
                
                <!-- Tombol Tutup (Close Button) -->
                <button type="button" class="absolute top-0 right-0 z-20 m-4 p-2 rounded-full bg-black/50 text-white hover:bg-white hover:text-black transition-all duration-300 focus:outline-none" onclick="closeGalleryModal()">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Konten Modal (Gambar & Deskripsi) -->
                <div class="flex flex-col items-center justify-center p-2">
                    <!-- Wadah Gambar -->
                    <img id="modalImage" src="" alt="Gallery Image" class="max-h-[85vh] w-auto max-w-full object-contain rounded-lg shadow-2xl mb-6">
                    
                    <!-- Informasi Gambar -->
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
    /**
     * Membuka Modal Galeri
     * 
     * @param {string} image - URL gambar
     * @param {string} title - Judul gambar
     * @param {string} description - Deskripsi gambar
     */
    function openGalleryModal(image, title, description) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDescription');
        
        modalImg.src = image;
        modalTitle.textContent = title;
        modalDesc.textContent = description;
        
        modal.classList.remove('hidden');
        // Tambahkan efek animasi fade in sederhana
        modal.classList.add('animate-fade-in');
        
        document.body.style.overflow = 'hidden'; // Mencegah scrolling pada body saat modal terbuka
    }

    /**
     * Menutup Modal Galeri
     */
    function closeGalleryModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Mengembalikan kemampuan scrolling body
        
        // Membersihkan sumber gambar setelah penundaan kecil agar visual lebih halus
        setTimeout(() => {
            document.getElementById('modalImage').src = '';
        }, 200);
    }
    
    // Event Delegation untuk Item Galeri (Menangani elemen hasil kloning Swiper loop)
    // Menggunakan event delegation lebih efisien daripada menambahkan listener ke setiap item
    document.addEventListener('click', function(e) {
        const item = e.target.closest('.gallery-item');
        if (item) {
            const img = item.getAttribute('data-image');
            const title = item.getAttribute('data-title');
            const desc = item.getAttribute('data-description');
            openGalleryModal(img, title, desc);
        }
    });

    // Menutup modal dengan tombol Keyboard (Escape)
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGalleryModal();
        }
    });
</script>

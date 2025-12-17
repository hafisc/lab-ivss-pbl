<?php 
/**
 * Halaman Utama (Home)
 * 
 * File ini merupakan halaman pendaratan (landing page) utama untuk pengunjung umum.
 * Struktur halaman terdiri dari berbagai seksi yang dimuat secara modular.
 */

// Menghubungkan konfigurasi database
require_once __DIR__ . '/../../app/config/Database.php'; 

// Mendapatkan koneksi PostgreSQL menggunakan pola Singleton
$pgConnection = Database::getInstance()->getPgConnection(); 

// Inisialisasi data profil laboratorium
$profileData = [];

// Data default jika tidak ada data di database (Fallback)
$defaultData = [
    'nama_lab' => 'Lab Default',
    'lokasi_ruangan' => 'Lokasi Belum Diatur',
    'deskripsi_singkat' => 'Deskripsi Lab Belum Diisi. Silakan perbarui melalui halaman Admin.',
    'riset_fitur_judul' => 'Riset Inovatif',
    'riset_fitur_desk' => 'Penelitian berkelas dunia',
    'fasilitas_fitur_judul' => 'Fasilitas Modern',
    'fasilitas_fitur_desk' => 'Peralatan canggih',
];

// Mengambil data profil dari database jika koneksi tersedia
if ($pgConnection) {
    $query = 'SELECT * FROM "profile_lab" WHERE id = $1'; 
    $result = pg_query_params($pgConnection, $query, [1]);
    
    if ($result) {
        $dataFromDb = pg_fetch_assoc($result);
        if ($dataFromDb) {
            $profileData = $dataFromDb;
        }
        pg_free_result($result);
    }
} else {
    // Mencatat error jika koneksi gagal
    error_log("Gagal mendapatkan koneksi PostgreSQL saat loading home.php");
}

// Menggabungkan data default dengan data dari database (prioritas data database)
$profileData = array_replace_recursive($defaultData, $profileData);
?>

<!-- ==========================================
     MULAI BAGIAN UTAMA (SECTIONS)
     ========================================== -->

<!-- 1. Bagian Hero (Tampilan Awal) -->
<?php include __DIR__ . '/sections/hero.php'; ?>

<!-- 2. Bagian Profil Laboratorium -->
<?php include __DIR__ . '/sections/profile.php'; ?>

<!-- 3. Bagian Visi & Misi -->
<?php include __DIR__ . '/sections/visimisi.php'; ?>

<!-- 4. Bagian Galeri Kegiatan -->
<?php include __DIR__ . '/sections/gallery.php'; ?>

<!-- 5. Bagian Fasilitas -->
<?php include __DIR__ . '/sections/facilities.php'; ?>

<!-- Pemisah -->
<br><br><br>

<!-- 6. Bagian Peralatan -->
<?php include __DIR__ . '/sections/equipment.php'; ?>

<!-- Pemisah -->
<br><br><br>

<!-- 7. Bagian Publikasi Riset -->
<?php include __DIR__ . '/sections/publications.php'; ?>

<!-- 8. Bagian Berita & Artikel -->
<?php include __DIR__ . '/sections/news.php'; ?>

<!-- ==========================================
     AKHIR BAGIAN UTAMA
     ========================================== -->

<!-- Memuat Pustaka Swiper JS untuk Slider/Carousel -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Mengirim data PHP ke variabel global JavaScript -->
<script>
    // Data publikasi untuk keperluan filtering di sisi klien
    const publicationsData = <?php echo json_encode($publications ?? []); ?>;
</script>

<!-- Skrip Inisialisasi Slider dan Interaktivitas -->
<script>
// Variabel global untuk instance Swiper
let publicationSwiper = null;
let newsSwiper = null;
let fasilitasSwiper = null;
let equipmentSwiper = null;
let gallerySwiper = null;

/**
 * Event Listener saat DOM telah siap dimuat
 */
document.addEventListener('DOMContentLoaded', function() {
  // Inisialisasi semua slider
  initSwiper();
  initNewsSwiper();
  initFasilitasSwiper();
  initEquipmentSwiper();
  initGallerySwiper();
  
  // Menambahkan logika untuk tombol filter publikasi
  const filterButtons = document.querySelectorAll('.filter-btn');
  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      // Hapus kelas aktif dari semua tombol
      filterButtons.forEach(b => {
        b.classList.remove('bg-blue-900', 'text-white', 'shadow-md');
        b.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
      });
      
      // Tambahkan kelas aktif ke tombol yang diklik
      this.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
      this.classList.add('bg-blue-900', 'text-white', 'shadow-md');
      
      // Jalankan fungsi filter berdasarkan tipe data button
      const filterType = this.getAttribute('data-filter');
      filterPublications(filterType);
    });
  });
});

/**
 * Inisialisasi Swiper untuk Publikasi
 */
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
        // Responsif Breakpoints
        breakpoints: {
            640: { slidesPerView: 1, spaceBetween: 20 },
            768: { slidesPerView: 2, spaceBetween: 30 },
            1024: { slidesPerView: 3, spaceBetween: 30 },
        },
    });
}

/**
 * Inisialisasi Swiper untuk Berita
 */
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
            640: { slidesPerView: 1, spaceBetween: 20 },
            768: { slidesPerView: 2, spaceBetween: 30 },
            1024: { slidesPerView: 3, spaceBetween: 30 },
        },
    });
}

/**
 * Inisialisasi Swiper untuk Galeri
 */
function initGallerySwiper() {
    gallerySwiper = new Swiper('.gallerySwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
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

/**
 * Inisialisasi Swiper untuk Fasilitas
 */
function initFasilitasSwiper() {
    fasilitasSwiper = new Swiper('.fasilitasSwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.fasilitasSwiper .swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        breakpoints: {
            640: { slidesPerView: 1, spaceBetween: 20 },
            768: { slidesPerView: 2, spaceBetween: 30 },
            1024:{ slidesPerView: 3, spaceBetween: 30 },
        },
    });
}

/**
 * Inisialisasi Swiper untuk Peralatan
 */
function initEquipmentSwiper() {
  equipmentSwiper = new Swiper('.equipmentSwiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: { delay: 5000, disableOnInteraction: false },
    pagination: {
      el: '.equipmentSwiper .swiper-pagination',
      clickable: true,
      dynamicBullets: true,
    },
    breakpoints: {
      640:  { slidesPerView: 1, spaceBetween: 20 },
      768:  { slidesPerView: 2, spaceBetween: 30 },
      1024: { slidesPerView: 3, spaceBetween: 30 },
    },
  });
}

/**
 * Fungsi untuk memfilter publikasi
 * @param {string} filterType - Tipe filter ('cited', 'latest', 'oldest')
 */
function filterPublications(filterType) {
    let sortedData = [...publicationsData];

    // Logika sorting berdasarkan tipe filter
    switch (filterType) {
        case 'cited': // Paling banyak dikutip
            sortedData.sort((a, b) => (b.citations || 0) - (a.citations || 0));
            break;
        case 'latest': // Terbaru (tahun menurun)
            sortedData.sort((a, b) => (b.year || 0) - (a.year || 0));
            break;
        case 'oldest': // Terlama (tahun menaik)
            sortedData.sort((a, b) => (a.year || 0) - (b.year || 0));
            break;
    }

    // Perbarui slide swiper dengan data yang sudah diurutkan
    updateSwiperSlides(sortedData);
}

/**
 * Fungsi pembantu untuk membangun ulang slide publikasi
 * @param {Array} data - Array data publikasi
 */
function updateSwiperSlides(data) {
    if (!publicationSwiper) return;
    
    // Hapus semua slide yang ada
    publicationSwiper.removeAllSlides();
    
    // Tambahkan slide baru
    data.forEach(pub => {
        // Potong abstrak jika terlalu panjang
        const excerpt = pub.abstract.length > 150 ? pub.abstract.substring(0, 150) + '...' : pub.abstract;
        const venue = pub.journal || pub.conference || 'Conference';
        
        // Template HTML untuk slide publikasi
        const slideHTML = `
            <div class="swiper-slide">
                <div class="group relative bg-blue-50 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                    ${pub.citations > 20 ? `
                    <div class="absolute top-4 right-4 w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    ` : ''}
                    
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-blue-900 text-white text-xs font-semibold rounded-full">${pub.year}</span>
                        <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full ml-2">${pub.type.charAt(0).toUpperCase() + pub.type.slice(1)}</span> 
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 ${pub.citations > 20 ? 'pr-12' : ''}">${pub.title}</h3>
                    
                    <p class="text-sm text-gray-600 mb-3 font-medium">${pub.authors}</p>
                    
                    <p class="text-sm text-blue-900 mb-3 font-semibold">${venue}</p>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-3 flex-grow">${excerpt}</p>
                    
                                       
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 mt-auto">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">${pub.citations} Citations</span>
                        </div>
                        ${pub.doi ? `
                        <a href="https://doi.org/${pub.doi}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-900 hover:text-blue-700 transition-colors">
                            DOI
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
        
        publicationSwiper.appendSlide(slideHTML);
    });
    
    // Perbarui instance swiper untuk menerapkan perubahan
    publicationSwiper.update();
}
</script>

<style>
    /* Styling khusus untuk Swiper */
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

<!-- 9. Bagian Anggota Tim -->
<?php include __DIR__ . '/sections/team.php'; ?>

<?php
// Memuat data perkuliahan dari file JSON lokal
$dataFile = __DIR__ . '/../../app/data/perkuliahan.json';
$perkuliahan = null;
if (file_exists($dataFile)) {
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $perkuliahan = $decoded;
}
?>

<!-- 10. Bagian Perkuliahan Terkait -->
<?php include __DIR__ . '/sections/courses.php'; ?>

<!-- 11. Modal Global (Pop-up Gambar dsb) -->
<?php include __DIR__ . '/sections/modals.php'; ?>

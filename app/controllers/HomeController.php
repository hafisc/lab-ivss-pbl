<?php
/**
 * HomeController.php
 * Controller untuk halaman utama / landing page Lab IVSS
 * Menampilkan informasi profil lab, dosen, riset, dan fasilitas
 */

class HomeController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Menampilkan halaman utama (home/landing page)
     */
    public function index() {
        // Load system settings (Navbar/Footer dynamic)
        require_once __DIR__ . '/../models/SystemSettings.php';
        $settingsModel = new SystemSettings($this->db);
        $settings = $settingsModel->getAll();

        // Load publication model
        require_once __DIR__ . '/../models/publication.php';
        $publicationModel = new Publication($this->db);
        
        // Get featured publications untuk home page (max 6)
        $publications = $publicationModel->getFeatured(6);
        
        // Load news model
        require_once __DIR__ . '/../models/news.php';
        $newsModel = new News($this->db);
        
        // Get latest news untuk home page (max 6)
        $latestNews = $newsModel->getLatest(6);
        
        // Load team members model (Profil dinamis)
        require_once __DIR__ . '/../models/TeamMember.php';
        $teamModel = new TeamMember($this->db);
        
        // Get active team members
        $teamMembers = $teamModel->getActive();
        // Fallback jika kosong (untuk development)
        if (empty($teamMembers)) {
            $teamMembers = [
                ['name' => 'Ir. Andre', 'position' => 'Kepala Laboratorium', 'photo' => ''],
                ['name' => 'Dr. Ari', 'position' => 'Dosen Pembina', 'photo' => ''],
                ['name' => 'Bu Mungki', 'position' => 'Dosen Pembina', 'photo' => ''],
                ['name' => 'Bu Eli', 'position' => 'Dosen Pembina', 'photo' => ''],
                ['name' => 'Bu Heni', 'position' => 'Dosen Pembina', 'photo' => ''],
                ['name' => 'Bu Vivi', 'position' => 'Dosen Pembina', 'photo' => '']
            ];
        }
        $dosen_inti = $teamMembers;

        // Load facilities model (Fasilitas dinamis)
        require_once __DIR__ . '/../models/Facility.php';
        $facilityModel = new Facility($this->db);
        $facilities = $facilityModel->getAll();
        
        // Fallback jika kosong
        if (empty($facilities)) {
             $fasilitas = [
                'Deep Camera', 'High FPS Camera', 'Sony Alpha 6700', 'Lampu Data Primer',
                'Peralatan Objek Kecil', 'Musholla', 'Loker Penyimpanan', 'Ruang Pelatihan Internal'
            ];
        } else {
            $fasilitas = array_map(function($f) { return $f['name']; }, $facilities);
            // Jika view butuh deskripsi/gambar, kita bisa kirim $facilities full object
            $fasilitas_full = $facilities; 
        }

        // Data riset utama (bisa dibuat dinamis juga nanti jika ada tabelnya, sementara hardcode atau ambil dari research model)
        // Load research model
        require_once __DIR__ . '/../models/research.php';
        $researchModel = new Research($this->db);
        // Ambil riset active (misal 4 terbaru)
        $riset_list = $researchModel->getActive(4);
        
        if (!empty($riset_list)) {
             $riset_utama = array_map(function($r) {
                return [
                    'judul' => $r['title'],
                    'deskripsi' => substr($r['description'], 0, 100) . '...'
                ];
            }, $riset_list);
        } else {
            // Fallback hardcoded
            $riset_utama = [
                ['judul' => 'Sistem Absensi Wajah Lab', 'deskripsi' => 'Pengembangan sistem absensi otomatis menggunakan teknologi pengenalan wajah'],
                ['judul' => 'Kontrol Monitoring Ruangan', 'deskripsi' => 'Sistem monitoring dan kontrol orang yang berada di dalam ruangan'],
                ['judul' => 'Micro-expression Camera', 'deskripsi' => 'Penelitian ekspresi mikro menggunakan Sony Alpha 6700'],
                ['judul' => 'Monitoring Peralatan Lab', 'deskripsi' => 'Sistem monitoring dan tracking penggunaan peralatan laboratorium']
            ];
        }
        
        // Riset lainnya (hardcoded for now as requested focus is on facilities/profile/navbar)
        $riset_lainnya = [
            ['judul' => 'AI & Machine Learning', 'deskripsi' => 'Riset umum di bidang kecerdasan buatan'],
            ['judul' => 'Klasifikasi Citra Digital', 'deskripsi' => 'Pengembangan algoritma klasifikasi'],
            ['judul' => 'Proyek Mahasiswa', 'deskripsi' => 'Berbagai proyek penelitian mahasiswa']
        ];

        // Load equipment model (tetap ada untuk landing page jika dibutuhkan)
        require_once __DIR__ . '/../models/equipment.php';
        $equipmentModel = new Equipment($this->db);
        $equipmentForLanding = $equipmentModel->getForLanding("30");

        // Load Gallery model (Baru)
        require_once __DIR__ . '/../models/Gallery.php';
        $galleryModel = new Gallery($this->db);
        $galleryItems = $galleryModel->getAll();

        // Muat view dengan layout pages
        require_once __DIR__ . '/../../view/layouts/pages.php';
    }
}

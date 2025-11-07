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
        // Data dosen inti - hardcode dulu untuk landing page
        $dosen_inti = [
            [
                'nama' => 'Ir. Andre',
                'role' => 'Kepala Laboratorium',
                'bidang' => 'Computer Vision & AI'
            ],
            [
                'nama' => 'Dr. Ari',
                'role' => 'Dosen Pembina',
                'bidang' => 'Deep Learning & Image Processing'
            ],
            [
                'nama' => 'Bu Mungki',
                'role' => 'Dosen Pembina',
                'bidang' => 'Intelligent Systems'
            ],
            [
                'nama' => 'Bu Eli',
                'role' => 'Dosen Pembina',
                'bidang' => 'Pattern Recognition'
            ],
            [
                'nama' => 'Bu Heni',
                'role' => 'Dosen Pembina',
                'bidang' => 'Computer Vision'
            ],
            [
                'nama' => 'Bu Vivi',
                'role' => 'Dosen Pembina',
                'bidang' => 'AI & Machine Learning'
            ],
            [
                'nama' => 'Dosen Pembina Lainnya',
                'role' => 'Dosen Pembina',
                'bidang' => 'Berbagai Bidang Riset'
            ]
        ];

        // Data riset utama
        $riset_utama = [
            [
                'judul' => 'Sistem Absensi Wajah Lab',
                'deskripsi' => 'Pengembangan sistem absensi otomatis menggunakan teknologi pengenalan wajah dengan akurasi tinggi'
            ],
            [
                'judul' => 'Kontrol Monitoring Ruangan',
                'deskripsi' => 'Sistem monitoring dan kontrol orang yang berada di dalam ruangan secara real-time'
            ],
            [
                'judul' => 'Micro-expression Camera',
                'deskripsi' => 'Penelitian ekspresi mikro menggunakan Sony Alpha 6700 dengan frame rate tinggi'
            ],
            [
                'judul' => 'Monitoring Peralatan Lab',
                'deskripsi' => 'Sistem monitoring dan tracking penggunaan peralatan laboratorium'
            ]
        ];

        // Data riset lainnya
        $riset_lainnya = [
            [
                'judul' => 'AI & Machine Learning',
                'deskripsi' => 'Riset umum di bidang kecerdasan buatan dan pembelajaran mesin'
            ],
            [
                'judul' => 'Klasifikasi Citra Digital',
                'deskripsi' => 'Pengembangan algoritma klasifikasi untuk berbagai jenis citra'
            ],
            [
                'judul' => 'Proyek Mahasiswa',
                'deskripsi' => 'Berbagai proyek penelitian dan pengembangan oleh mahasiswa bimbingan'
            ]
        ];

        // Data fasilitas
        $fasilitas = [
            'Deep Camera',
            'High FPS Camera',
            'Sony Alpha 6700',
            'Lampu Data Primer',
            'Peralatan Objek Kecil',
            'Musholla',
            'Loker Penyimpanan',
            'Ruang Pelatihan Internal'
        ];

        // Muat view dengan layout pages
        require_once __DIR__ . '/../../view/layouts/pages.php';
    }
}

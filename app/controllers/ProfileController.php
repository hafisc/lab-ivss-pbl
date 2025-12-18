<?php
// File: app/Controllers/ProfileController.php

// PENTING: Pastikan file database.php mendefinisikan dan mengembalikan objek PDO (misal: $pg)
require_once __DIR__ . '/../config/database.php';


class ProfileController
{
    // Properti ini sekarang akan menyimpan resource koneksi PostgreSQL
    private $pgConnection;
    private $tableName = 'profile_lab';

    // Menerima resource koneksi PostgreSQL dari Database::getPgConnection()
    public function __construct($pgConnectionResource)
    {
        $this->pgConnection = $pgConnectionResource;
        // Tidak ada setAttribute untuk pg_*
    }

    public function getProfileData()
    {
        if (!$this->pgConnection) return null;

        error_log("DEBUG: Table Name is '{$this->tableName}'");

        // Menggunakan pg_query_params untuk keamanan
        $query = "SELECT * FROM \"{$this->tableName}\" WHERE id = $1";

        try {
            $result = pg_query_params($this->pgConnection, $query, [1]);

            if ($result === false) {
                // Jika query gagal (misal salah sintaks/nama tabel), PG error akan dilempar
                throw new Exception(pg_last_error($this->pgConnection));
            }

            // Mengambil baris pertama
            $data = pg_fetch_assoc($result);
            pg_free_result($result);

            if (empty($data)) {
                error_log("getProfileData: Query berhasil, tetapi ID=1 tidak ditemukan atau tabel kosong.");
            }

            return $data;
        } catch (Exception $e) {
            echo "<h1>DATABASE ERROR DITEMUKAN:</h1>";
            echo "<p>Detail Error: " . htmlspecialchars($e->getMessage()) . "</p>";

            error_log("Database Error in getProfileData: " . $e->getMessage());
            $_SESSION['error'] = 'Gagal memuat data profil dari database (PG Error).';
            return null;
        }
    }

    /**
     * Halaman Admin View (READ) - Dipanggil oleh Router (misal: index.php?page=admin-profile-settings&action=index)
     * @return string Konten HTML
     */
    public function index()
    {
        // --- 1. Authorization check ---
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location: index.php?page=admin-login');
            exit;
        }

        // --- 2. Load Data ---
        $profileData = $this->getProfileData() ?? [];

        // Atur nilai default
        $profileData = array_replace_recursive([
            'nama_lab' => 'Belum Diatur',
            'singkatan' => '',
            'deskripsi_singkat' => 'Belum Diatur',
            'lokasi_ruangan' => 'Belum Diatur',
            'riset_fitur_judul' => 'Riset Inovatif',
            'riset_fitur_desk' => 'Penelitian berkelas dunia',
            'fasilitas_fitur_judul' => 'Fasilitas Modern',
            'fasilitas_fitur_desk' => 'Peralatan canggih',
        ], $profileData);

        // --- 3. Render view ---
        ob_start();
        // Pastikan path ke view/admin/profile/view.php benar
        require __DIR__ . '/../../view/admin/profile/view.php';
        return ob_get_clean(); // Mengembalikan konten HTML
    }

    /**
     * Halaman Admin Edit dan Proses POST (UPDATE) - Dipanggil oleh Router
     * @return string|void Konten HTML form atau redirect jika POST
     */
    public function edit()
    {
        // --- 1. Authorization check ---
        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location: index.php?page=admin-login');
            exit;
        }

        // --- 2. Handle POST Request (Update Logic) ---
        // Jika permintaan adalah POST, panggil method update() dan keluar.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->update();
        }

        // --- 3. Tampilan Formulir (GET Request) ---
        // Ambil data dari database (atau array kosong jika gagal)
        $profileData = $this->getProfileData() ?? [];

        // Set nilai default (penting untuk mencegah Undefined Index/Variable Warning di view)
        $profileData = array_replace_recursive([
            'nama_lab' => '',
            'singkatan' => '',
            'deskripsi_singkat' => '',
            'lokasi_ruangan' => '',
            'riset_fitur_judul' => 'Riset Inovatif',
            'riset_fitur_desk' => 'Penelitian berkelas dunia',
            'fasilitas_fitur_judul' => 'Fasilitas Modern',
            'fasilitas_fitur_desk' => 'Peralatan canggih'
        ], $profileData);

        // Render edit form
        ob_start();
        require __DIR__ . '/../../view/admin/profile/edit.php';
        return ob_get_clean();
    }

    /**
     * Logic Update Database
     * @return void Redirect
     */
    public function update()
    {
        if (!$this->pgConnection) {
            $_SESSION['error'] = 'Gagal menyimpan: Koneksi database tidak tersedia.';
            header('Location: index.php?page=admin-profile-settings');
            exit;
        }

        $imagePath = null;
        
        // Handle File Upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            
            if (in_array($fileType, $allowedTypes)) {
                // Determine upload directory
                $uploadDir = __DIR__ . '/../../public/uploads/profile/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = 'logo_' . time() . '.' . $extension;
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imagePath = 'uploads/profile/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Gagal mengupload file gambar.';
                }
            } else {
                $_SESSION['error'] = 'Format file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP.';
            }
        }

        // Prepare Query
        // If image uploaded, update image column too. Otherwise keep old one.
        if ($imagePath) {
             $sql = "UPDATE {$this->tableName} SET
                nama_lab = $1, singkatan = $2, deskripsi_singkat = $3, 
                lokasi_ruangan = $4,
                riset_fitur_judul = $5, riset_fitur_desk = $6,
                fasilitas_fitur_judul = $7, fasilitas_fitur_desk = $8,
                image = $9,
                last_updated = CURRENT_TIMESTAMP
                WHERE id = $10";
                
             $params = [
                $_POST['nama_lab'] ?? '',
                $_POST['singkatan'] ?? '',
                $_POST['deskripsi_singkat'] ?? '',
                $_POST['lokasi_ruangan'] ?? '',
                $_POST['riset_fitur_judul'] ?? '',
                $_POST['riset_fitur_desk'] ?? '',
                $_POST['fasilitas_fitur_judul'] ?? '',
                $_POST['fasilitas_fitur_desk'] ?? '',
                $imagePath,
                1 // ID
            ];
        } else {
            // No new image, don't update image column
             $sql = "UPDATE {$this->tableName} SET
                nama_lab = $1, singkatan = $2, deskripsi_singkat = $3, 
                lokasi_ruangan = $4,
                riset_fitur_judul = $5, riset_fitur_desk = $6,
                fasilitas_fitur_judul = $7, fasilitas_fitur_desk = $8,
                last_updated = CURRENT_TIMESTAMP
                WHERE id = $9";
                
             $params = [
                $_POST['nama_lab'] ?? '',
                $_POST['singkatan'] ?? '',
                $_POST['deskripsi_singkat'] ?? '',
                $_POST['lokasi_ruangan'] ?? '',
                $_POST['riset_fitur_judul'] ?? '',
                $_POST['riset_fitur_desk'] ?? '',
                $_POST['fasilitas_fitur_judul'] ?? '',
                $_POST['fasilitas_fitur_desk'] ?? '',
                1 // ID
            ];
        }

        try {
            $result = pg_query_params($this->pgConnection, $sql, $params);

            if ($result === false) {
                throw new Exception(pg_last_error($this->pgConnection));
            }

            if (!isset($_SESSION['error'])) {
                $_SESSION['success'] = 'Profil Laboratorium berhasil diperbarui!';
            }
        } catch (Exception $e) {
            error_log("Update DB Error: " . $e->getMessage());
            $_SESSION['error'] = "Gagal memperbarui database: " . $e->getMessage();
        }

        header('Location: index.php?page=admin-profile-settings');
        exit;
    }

    // File: app/Controllers/ProfileController.php

    public function publicView(){ 
        $profileData = $this->getProfileData() ?? []; 

        $profileData = array_replace_recursive([
            // Pastikan semua key yang digunakan di home.php ada di sini:
            'nama_lab' => 'IVSS Lab Default',
            'singkatan' => 'IVSS',
            'deskripsi_singkat' => 'Pusat riset Computer Vision dan AI.',
            'lokasi_ruangan' => 'Lokasi Belum Diatur',
            'riset_fitur_judul' => 'Riset Inovatif',
            'riset_fitur_desk' => 'Penelitian berkelas dunia',
            'fasilitas_fitur_judul' => 'Fasilitas Modern',
            'fasilitas_fitur_desk' => 'Peralatan canggih',
        ], $profileData);

        // 3. Render View
        ob_start();

        $viewPath = __DIR__ . '/../../view/pages/home.php';
        
        if (!file_exists($viewPath)) {
            // Jika file tidak ditemukan, ini adalah Fatal Error di router/view
            echo "<h1>FATAL ERROR: File View Tidak Ditemukan</h1>";
            echo "<p>Path yang Dicari: " . htmlspecialchars($viewPath) . "</p>";
            exit;
        }
        
        require $viewPath;
        
        return ob_get_clean();
    }
}

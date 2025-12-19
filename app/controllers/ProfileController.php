<?php
// File: app/Controllers/ProfileController.php

// PENTING: Pastikan file database.php mendefinisikan dan mengembalikan objek PDO (misal: $pg)
require_once __DIR__ . '/../config/database.php';

class ProfileController
{
    private $pgConnection;
    private $tableName = 'profil';

    public function __construct($pgConnectionResource)
    {
        $this->pgConnection = $pgConnectionResource;
    }

    public function getProfileData()
    {
        if (!$this->pgConnection) return null;
        
        // Menggunakan double quotes untuk nama tabel agar aman di PostgreSQL
        $query = "SELECT * FROM \"{$this->tableName}\" WHERE id = $1";

        try {
            $result = pg_query_params($this->pgConnection, $query, [1]);
            if ($result === false) throw new Exception(pg_last_error($this->pgConnection));
            
            $data = pg_fetch_assoc($result);
            pg_free_result($result);
            return $data;
        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage());
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
            $_SESSION['error'] = 'Koneksi database tidak tersedia.';
            header('Location: index.php?page=admin-profile-settings');
            exit;
        }

        // 1. Ambil data lama untuk mempertahankan gambar jika tidak ada upload baru
        $oldData = $this->getProfileData();
        $imageName = $oldData['image'] ?? 'default.png';

        // 2. Proses Upload Gambar jika ada file baru
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Sesuaikan path ke folder upload Anda
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newFileName = 'profile_' . time() . '.' . $fileExtension;
            $targetPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imageName = $newFileName; // Update variabel nama gambar
            }
        }

        // 3. Perbaikan SQL (Hapus duplikasi last_updated dan perbaiki koma)
        $sql = "UPDATE \"{$this->tableName}\" SET
            nama_lab = $1, 
            singkatan = $2, 
            deskripsi_singkat = $3, 
            lokasi_ruangan = $4,
            riset_fitur_judul = $5, 
            riset_fitur_desk = $6,
            fasilitas_fitur_judul = $7, 
            fasilitas_fitur_desk = $8,
            image = $9,
            last_updated = CURRENT_TIMESTAMP
            WHERE id = $10";

        // 4. Perbaikan Parameter (Gunakan variabel $imageName, bukan $_POST['image'])
        $params = [
            $_POST['nama_lab'] ?? '',
            $_POST['singkatan'] ?? '',
            $_POST['deskripsi_singkat'] ?? '',
            $_POST['lokasi_ruangan'] ?? '',
            $_POST['riset_fitur_judul'] ?? '',
            $_POST['riset_fitur_desk'] ?? '',
            $_POST['fasilitas_fitur_judul'] ?? '',
            $_POST['fasilitas_fitur_desk'] ?? '',
            $imageName, // Gunakan variabel hasil proses upload di atas
            1           // ID yang diupdate
        ];

        try {
            $result = pg_query_params($this->pgConnection, $sql, $params);
            if ($result === false) throw new Exception(pg_last_error($this->pgConnection));
            $_SESSION['success'] = 'Profil Laboratorium berhasil diperbarui!';
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

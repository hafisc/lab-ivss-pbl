<?php
// Pastikan kode di atas ini adalah class AdminController { ... 
// dan di bawah ini adalah method-method di dalamnya.

public function profil() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Pastikan model Profil sudah tersedia. 
    // Praktik terbaik adalah di-instantiate di __construct, tapi ini adalah fallback.
    if (!$this->profilModel) {
        // Asumsi: AdminController berada di 'controller/admin'
        require_once __DIR__ . '/../models/Profil.php'; 
        $this->profilModel = new Profil($this->db);
    }
    
    // Untuk Profil, action default harus 'edit'
    $action = $_GET['action'] ?? 'edit'; 
    
    switch ($action) {
        case 'edit':
            // Gunakan ensureRecordExists() untuk memuat atau membuat data default
            $profilItem = $this->profilModel->ensureRecordExists();
            
            if ($profilItem) {
                // $data akan digunakan di view/admin/profil/edit.php
                $data = $profilItem; 
                $title = "Edit Profil Laboratorium";
                // Asumsi: View ada di '../../view/admin/profil/edit.php'
                include __DIR__ . '/../../view/admin/profil/edit.php'; 
            } else {
                $_SESSION['error'] = 'Gagal memuat atau membuat data Profil Laboratorium.';
                header('Location: index.php?page=admin-dashboard');
                exit;
            }
            break;
            
        case 'update':
            $this->updateProfil(); // Panggil method perbaikan
            break;
            
        case 'delete':
            // Aksi DELETE tidak logis untuk single-record profil
            $_SESSION['error'] = 'Aksi penghapusan (delete) tidak diizinkan untuk Profil Laboratorium.';
            header('Location: index.php?page=admin-profil'); 
            exit;
            
        default:
            // Aksi default diarahkan ke edit
            header('Location: index.php?page=admin-profil&action=edit');
            exit;
    }
}

private function updateProfil() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php?page=admin-profil');
        exit;
    }
    
    $id = 1; 
    
    // Gunakan trim() untuk sanitasi input
    $nama = trim($_POST['nama'] ?? ''); 
    $deskripsi = trim($_POST['deskripsi'] ?? ''); 
    
    // 1. VALIDASI WAJIB DIISI
    if (empty($nama) || empty($deskripsi)) {
        $_SESSION['error'] = 'Nama dan Deskripsi Laboratorium wajib diisi.';
        header('Location: index.php?page=admin-profil');
        exit;
    }

    // Pastikan model Profil sudah tersedia
    if (!$this->profilModel) {
        require_once __DIR__ . '/../models/Profil.php';
        $this->profilModel = new Profil($this->db);
    }

    // 2. GET DATA LAMA untuk penanganan gambar
    $existing = $this->profilModel->get(); 
    
    if (!$existing) {
        $_SESSION['error'] = 'Data Profil tidak ditemukan saat mencoba update.';
        header('Location: index.php?page=admin-profil');
        exit;
    }
    
    // Inisialisasi $image dengan path gambar lama/default
    $image = $existing['image'] ?? 'uploads/default.jpg'; 
    $new_image_uploaded = null; 
    
    // 3. HANDLE UPLOAD GAMBAR BARU
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Asumsi: $this->uploadImage() tersedia di class AdminController
        $new_image_uploaded = $this->uploadImage($_FILES['image'], 'profil'); 
        
        if (!$new_image_uploaded) {
            // Asumsi: helper uploadImage sudah mengisi $_SESSION['error']
            header('Location: index.php?page=admin-profil');
            exit;
        }
    }
    
    // 4. TENTUKAN PATH GAMBAR FINAL ($image)
    if ($new_image_uploaded) {
        // Ada upload baru, gunakan yang baru dan hapus yang lama
        if ($existing['image'] && $existing['image'] !== 'uploads/default.jpg') {
             $this->deleteOldImage($existing['image']);
        }
        $image = $new_image_uploaded;
    } 
    // Catatan: Opsi 'remove_image' dihilangkan sesuai permintaan, 
    // jadi jika tidak ada upload baru, $image tetap menggunakan path lama.

    
    // 5. PANGGIL MODEL DENGAN PARAMETER SKALAR (Tanpa Array)
    // Asumsi: Model::update($id, $name, $deskripsi, $image) sudah diimplementasikan
    if ($this->profilModel->update($id, $nama, $deskripsi, $image)) {
        $_SESSION['success'] = 'Profil Laboratorium berhasil diupdate!';
        header('Location: index.php?page=admin-profil');
    } else {
        // Jika gagal, hapus gambar baru yang mungkin sudah terupload (Rollback)
        if ($new_image_uploaded) {
            $this->deleteOldImage($new_image_uploaded);
        }
        // Asumsi: $this->db adalah koneksi database PostgreSQL
        $_SESSION['error'] = 'Gagal mengupdate Profil Laboratorium: ' . pg_last_error($this->db);
        header('Location: index.php?page=admin-profil');
    }
    exit;
}

private function deleteOldImage($path) {
    // Cek jika path valid dan bukan default
    if ($path && $path !== 'uploads/default.jpg') {
        // Ubah path relatif database ('uploads/profil/xxx.jpg') menjadi path absolut
        // Asumsi AdminController berada di 'controller/admin/'
        $full_path = __DIR__ . '/../../public/' . $path; 
        
        if (file_exists($full_path)) {
            // Hapus file
            @unlink($full_path); 
            return true;
        }
    }
    return false;
}

// ... (Diikuti oleh method-method lain, dan diakhiri dengan kurung kurawal penutup kelas)
// }
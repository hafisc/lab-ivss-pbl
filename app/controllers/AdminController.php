<?php

class AdminController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function dashboard()
    {
        // Ambil statistik berdasarkan role
        $userRole = $_SESSION['user']['role'] ?? 'member';

        if ($userRole === 'admin') {
            // Admin: System Overview
            $totalUsers = $this->getTotalUsers();
            $totalMemberAktif = $this->getTotalMemberAktif();
            $totalEquipment = $this->getTotalEquipment();
        } else {
            // Dosen & Ketua Lab: Member & Research focused
            $totalMemberAktif = $this->getTotalMemberAktif();
            $totalAlumni = $this->getTotalAlumni();
            $totalRiset = $this->getTotalRiset();
            $totalNews = $this->getTotalNews();
        }

        // Ambil pendaftaran pending (5 terbaru)
        $pendingRegistrations = $this->getPendingRegistrations(5);

        // Ambil berita terbaru (5 terbaru)
        $latestNews = $this->getLatestNews(5);

        // Kirim data ke view
        include __DIR__ . '/../../view/admin/dashboard.php';
    }

    public function registrations()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Handle actions
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $action = $_GET['action'];
            $id = intval($_GET['id']);

            if ($action === 'view') {
                // Tampilkan detail pendaftar
                $registration = $this->getRegistrationDetail($id);
                if ($registration) {
                    include __DIR__ . '/../../view/admin/members/show.php';
                } else {
                    $_SESSION['error'] = 'Pendaftar tidak ditemukan!';
                    header('Location: index.php?page=admin-registrations');
                    exit;
                }
                return;
            } elseif ($action === 'approve') {
                $this->approveRegistration($id);
            } elseif ($action === 'reject') {
                $this->rejectRegistration($id);
            }

            header('Location: index.php?page=admin-registrations');
            exit;
        }

        // Ambil semua pendaftaran pending
        $registrations = $this->getPendingRegistrations();

        // Kirim data ke view
        include __DIR__ . '/../../view/admin/members/approve.php';
    }

    // Method pembantu
    private function getTotalUsers()
    {
        $query = "SELECT COUNT(*) as total FROM users WHERE status = 'active'";
        $result = @pg_query($this->db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['total'] ?? 0;
        }
        return 0;
    }

    private function getTotalMemberAktif()
    {
        $query = "SELECT COUNT(*) as total FROM users u 
                  JOIN roles r ON u.role_id = r.id 
                  WHERE (r.role_name = 'member' OR r.role_name = 'mahasiswa') AND u.status = 'active'";
        $result = @pg_query($this->db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['total'] ?? 0;
        }
        return 0;
    }

    private function getTotalEquipment()
    {
        $query = "SELECT COUNT(*) as total FROM equipment";
        $result = @pg_query($this->db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['total'] ?? 0;
        }
        return 0;
    }

    private function getTotalAlumni()
    {
        $query = "SELECT COUNT(*) as total FROM users u 
                  JOIN roles r ON u.role_id = r.id 
                  WHERE (r.role_name = 'member' OR r.role_name = 'mahasiswa') AND u.status = 'inactive'";
        $result = pg_query($this->db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['total'] ?? 0;
        }
        return 0;
    }

    private function getTotalRiset()
    {
        require_once __DIR__ . '/../models/research.php';
        $researchModel = new Research($this->db);
        $stats = $researchModel->getStats();
        return $stats['active_research'] ?? 0;
    }

    private function getTotalNews()
    {
        // Asumsi tabel news sudah ada
        $query = "SELECT COUNT(*) as total FROM news WHERE status = 'published'";
        $result = @pg_query($this->db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['total'] ?? 0;
        }
        return 0;
    }

    private function getPendingRegistrations($limit = null)
    {
        // Query berdasarkan role user
        $userRole = $_SESSION['user']['role'] ?? 'member';
        $userId = $_SESSION['user']['id'] ?? 0;

        if ($userRole === 'dosen') {
            // Dosen: hanya lihat pendaftar yang memilih dirinya sebagai supervisor DAN masih pending_supervisor
            $query = "SELECT mr.*, u.username as supervisor_name 
                      FROM member_registrations mr 
                      LEFT JOIN users u ON mr.supervisor_id = u.id 
                      WHERE mr.status = 'pending_supervisor' AND mr.supervisor_id = $1 
                      ORDER BY mr.created_at DESC";
            $params = [$userId];
        } elseif ($userRole === 'ketua_lab') {
            // Ketua Lab: hanya lihat yang sudah diapprove dosen (pending_lab_head)
            $query = "SELECT mr.*, u.username as supervisor_name 
                      FROM member_registrations mr 
                      LEFT JOIN users u ON mr.supervisor_id = u.id 
                      WHERE mr.status = 'pending_lab_head' 
                      ORDER BY mr.created_at DESC";
            $params = [];
        } else {
            // Admin: lihat semua yang pending (supervisor atau lab_head)
            $query = "SELECT mr.*, u.username as supervisor_name 
                      FROM member_registrations mr 
                      LEFT JOIN users u ON mr.supervisor_id = u.id 
                      WHERE mr.status IN ('pending_supervisor', 'pending_lab_head') 
                      ORDER BY mr.created_at DESC";
            $params = [];
        }

        if ($limit) {
            $query .= " LIMIT " . intval($limit);
        }

        $result = empty($params) ? @pg_query($this->db, $query) : @pg_query_params($this->db, $query, $params);
        $registrations = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $registrations[] = $row;
            }
        }

        return $registrations;
    }

    private function getRegistrationDetail($id)
    {
        // Ambil detail pendaftar dengan info dosen pengampu
        $query = "SELECT mr.*, 
                         u.name as supervisor_name,
                         u.email as supervisor_email
                  FROM member_registrations mr 
                  LEFT JOIN users u ON mr.supervisor_id = u.id 
                  WHERE mr.id = $1";

        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }

        return null;
    }

    private function getLatestNews($limit = 5)
    {
        $query = "SELECT * FROM news WHERE status = 'published' ORDER BY created_at DESC LIMIT " . intval($limit);
        $result = @pg_query($this->db, $query);
        $news = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $news[] = $row;
            }
        }

        return $news;
    }

    private function approveRegistration($id)
    {
        session_start();

        $userRole = $_SESSION['user']['role'] ?? 'member';

        require_once __DIR__ . '/../models/member.php';
        $memberModel = new Member($this->db);

        // Use the model methods which call stored procedures
        if ($userRole === 'dosen') {
            // Dosen approval
            $result = $memberModel->approveBySupervisor($id);
            if ($result) {
                $_SESSION['success'] = 'Pendaftar berhasil di-approve! Sekarang menunggu approval Ketua Lab.';
            } else {
                $_SESSION['error'] = 'Gagal approve pendaftar! Pastikan status valid.';
            }
        } elseif ($userRole === 'ketua_lab') {
            // Ketua Lab approval
            $result = $memberModel->approveByLabHead($id);
            if ($result) {
                $_SESSION['success'] = 'Pendaftar berhasil di-approve! Akun member telah dibuat dan aktif.';
            } else {
                $_SESSION['error'] = 'Gagal approve pendaftar! Pastikan status valid.';
            }
        } else {
            $_SESSION['error'] = 'Anda tidak memiliki akses untuk approve pendaftar.';
        }
    }

    private function rejectRegistration($id)
    {
        session_start();

        $userRole = $_SESSION['user']['role'] ?? 'member';

        require_once __DIR__ . '/../models/member.php';
        $memberModel = new Member($this->db);

        // Notes can be passed via POST if available, here we use default
        $notes = $_POST['notes'] ?? 'Rejected by ' . $userRole;

        if ($userRole === 'dosen') {
            $result = $memberModel->rejectBySupervisor($id, $notes);
            if ($result) {
                $_SESSION['success'] = 'Pendaftar berhasil ditolak.';
            } else {
                $_SESSION['error'] = 'Gagal menolak pendaftar!';
            }
        } elseif ($userRole === 'ketua_lab') {
            $result = $memberModel->rejectByLabHead($id, $notes);
            if ($result) {
                $_SESSION['success'] = 'Pendaftar berhasil ditolak.';
            } else {
                $_SESSION['error'] = 'Gagal menolak pendaftar!';
            }
        } else {
            $_SESSION['error'] = 'Anda tidak memiliki akses untuk reject pendaftar.';
        }
    }
    //managemen profil
    public function profil() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Inisialisasi Model Profil (fallback jika belum di __construct)
        if (!$this->profilModel) {
            // Asumsi: AdminController berada di 'controller/admin'
            require_once __DIR__ . '/../models/Profil.php'; 
            $this->profilModel = new Profil($this->db);
        }
        
        $action = $_GET['action'] ?? 'edit'; 
        
        switch ($action) {
            case 'edit':
                // Gunakan ensureRecordExists() untuk memuat atau membuat data default
                $profilItem = $this->profilModel->ensureRecordExists();
                
                if ($profilItem) {
                    $data = $profilItem; // Data dikirim ke View
                    $title = "Edit Profil Laboratorium";
                    // Memuat View (Asumsi View ada di '../../view/admin/profil/edit.php')
                    include __DIR__ . '/../../view/admin/profil/edit.php'; 
                } else {
                    $_SESSION['error'] = 'Gagal memuat atau membuat data Profil Laboratorium.';
                    header('Location: index.php?page=admin-dashboard');
                    exit;
                }
                break;
                
            case 'update':
                $this->updateProfil();
                break;
                
            case 'delete':
                $_SESSION['error'] = 'Aksi penghapusan (delete) tidak diizinkan untuk Profil Laboratorium.';
                header('Location: index.php?page=admin-profil'); 
                exit;
                
            default:
                header('Location: index.php?page=admin-profil&action=edit');
                exit;
        }
    }

    /**
     * Menangani pemrosesan formulir POST untuk update profil.
     */
    private function updateProfil() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-profil');
            exit;
        }
        
        $id = 1; 
        
        // 1. Sanitasi Input
        $nama = trim($_POST['nama'] ?? ''); 
        $deskripsi = trim($_POST['deskripsi'] ?? ''); 
        
        // 1.1. VALIDASI WAJIB DIISI
        if (empty($nama) || empty($deskripsi)) {
            $_SESSION['error'] = 'Nama dan Deskripsi Laboratorium wajib diisi.';
            header('Location: index.php?page=admin-profil');
            exit;
        }

        // 1.2. Pastikan model Profil sudah tersedia
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
        
        $image = $existing['image'] ?? 'uploads/default.jpg'; 
        $new_image_uploaded = null; 
        
        // 3. HANDLE UPLOAD GAMBAR BARU
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Asumsi: $this->uploadImage() tersedia di Controller
            $new_image_uploaded = $this->uploadImage($_FILES['image'], 'profil'); 
            
            if (!$new_image_uploaded) {
                // Jika uploadImage gagal, ia diasumsikan sudah mengatur $_SESSION['error']
                header('Location: index.php?page=admin-profil');
                exit;
            }
        }
        
        // 4. TENTUKAN PATH GAMBAR FINAL ($image)
        if ($new_image_uploaded) {
            // Ada upload baru, gunakan yang baru dan hapus gambar lama
            if ($existing['image'] && $existing['image'] !== 'uploads/default.jpg') {
                 $this->deleteOldImage($existing['image']);
            }
            $image = $new_image_uploaded;
        } 
        // Jika tidak ada upload baru, $image tetap menggunakan path lama ($existing['image'])

        
        // 5. PANGGIL MODEL DENGAN PARAMETER SKALAR (Sesuai permintaan Anda)
        if ($this->profilModel->update($id, $nama, $deskripsi, $image)) {
            $_SESSION['success'] = 'Profil Laboratorium berhasil diupdate!';
            header('Location: index.php?page=admin-profil');
        } else {
            // Rollback: Jika gagal di database, hapus gambar baru yang sudah terupload
            if ($new_image_uploaded) {
                $this->deleteOldImage($new_image_uploaded);
            }
            $_SESSION['error'] = 'Gagal mengupdate Profil Laboratorium: ' . pg_last_error($this->db);
            header('Location: index.php?page=admin-profil');
        }
        exit;
    }

    /**
     * Helper untuk menghapus file gambar lama dari server.
     */
    private function deleteOldImage($path) {
        // Cek jika path valid dan bukan default
        if ($path && $path !== 'uploads/default.jpg') {
            // Ubah path relatif database menjadi path absolut file system
            $full_path = __DIR__ . '/../../public/' . $path; 
            
            if (file_exists($full_path)) {
                // Hapus file
                @unlink($full_path); 
                return true;
            }
        }
        return false;
    }
    //managemen visimisi
  public function visimisi()
    {
        // Cek status sesi dan mulai jika belum
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load VisiMisiController dan delegasikan aksi 'edit'
        require_once __DIR__ . '/../controllers/VisiMisiController.php';
        $visimisiController = new VisiMisiController($this->db);

        $action = $_GET['action'] ?? 'edit'; // Default ke 'edit' karena hanya ada 1 record

        switch ($action) {
            case 'edit':
                // Panggil method edit dari VisiMisiController
                $visimisiController->edit();
                break;
            case 'update':
                // Panggil method update dari VisiMisiController
                $visimisiController->update();
                break;
            default:
                // Default kembali ke edit
                $visimisiController->edit();
                break;
        }
    }
    // Manajemen Berita
    public function news()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_GET['action'] ?? 'index';

        // Tangani berbagai aksi
        switch ($action) {
            case 'create':
                include __DIR__ . '/../../view/admin/berita/create.php';
                break;

            case 'store':
                $this->storeNews();
                break;

            case 'edit':
                $id = intval($_GET['id'] ?? 0);
                $newsItem = $this->getNewsById($id);
                if ($newsItem) {
                    include __DIR__ . '/../../view/admin/berita/edit.php';
                } else {
                    $_SESSION['error'] = 'Berita tidak ditemukan';
                    header('Location: index.php?page=admin-news');
                    exit;
                }
                break;

            case 'update':
                $this->updateNews();
                break;

            case 'delete':
                $this->deleteNews();
                break;

            default:
                // Index - daftar semua berita
                $filter = $_GET['filter'] ?? 'all';
                $allNews = $this->getAllNews();

                if ($filter === 'published') {
                    $newsList = array_filter($allNews, fn($n) => $n['status'] === 'published');
                } elseif ($filter === 'draft') {
                    $newsList = array_filter($allNews, fn($n) => $n['status'] === 'draft');
                } else {
                    $newsList = $allNews;
                }

                include __DIR__ . '/../../view/admin/berita/index.php';
                break;
        }
    }

    private function getAllNews()
    {
        $query = "SELECT * FROM news ORDER BY created_at DESC";
        $result = @pg_query($this->db, $query);
        $news = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                // Format image URL
                if (!empty($row['image'])) {
                    $row['image_url'] = $row['image'];
                } else {
                    $row['image_url'] = null;
                }
                $news[] = $row;
            }
        }

        return $news;
    }

    private function getNewsById($id)
    {
        $query = "SELECT * FROM news WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            // Format image URL
            if (!empty($row['image'])) {
                $row['image_url'] = $row['image'];
            } else {
                $row['image_url'] = null;
            }
            return $row;
        }

        return null;
    }

    private function storeNews()
    {
        $title = $_POST['title'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? '';
        $tags = $_POST['tags'] ?? '';
        $status = $_POST['status'] ?? 'draft';

        // Generate slug
        $slug = $this->generateSlug($title);

        // Handle image upload
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $this->uploadImage($_FILES['image'], 'news');
        }

        // Handle file upload
        $file_path = null;
        if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === UPLOAD_ERR_OK) {
            $file_path = $this->uploadFile($_FILES['file_path'], 'news_files');
        }

        // Set author_id and published_at
        $author_id = $_SESSION['user_id'] ?? 1;
        $published_at = ($status === 'published') ? 'NOW()' : null;

        $query = "INSERT INTO news (title, slug, excerpt, content, image, file_path, category, tags, author_id, status, published_at, created_at) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, " . ($published_at ? $published_at : 'NULL') . ", NOW()) RETURNING id";
        $result = @pg_query_params($this->db, $query, [$title, $slug, $excerpt, $content, $image, $file_path, $category, $tags, $author_id, $status]);

        if ($result) {
            $_SESSION['success'] = 'Berita berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan berita: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-news');
        exit;
    }

    private function updateNews()
    {
        $id = intval($_GET['id'] ?? 0);
        $title = $_POST['title'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? '';
        $tags = $_POST['tags'] ?? '';
        $status = $_POST['status'] ?? 'draft';

        // Generate slug
        $slug = $this->generateSlug($title);

        // Get existing news
        $existing = $this->getNewsById($id);
        $image = $existing['image'] ?? null;

        // Check if user wants to remove current image
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            $image = null;
            // Delete old image file if exists
            if ($existing && $existing['image'] && file_exists(__DIR__ . '/../../public/' . $existing['image'])) {
                @unlink(__DIR__ . '/../../public/' . $existing['image']);
            }
        }

        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Delete old image if exists
            if ($existing && $existing['image'] && file_exists(__DIR__ . '/../../public/' . $existing['image'])) {
                @unlink(__DIR__ . '/../../public/' . $existing['image']);
            }
            $image = $this->uploadImage($_FILES['image'], 'news');
        }

        // Handle file upload
        $file_path = $existing['file_path'] ?? null;
        
         // Check if user wants to remove current file
        if (isset($_POST['remove_file']) && $_POST['remove_file'] == '1') {
            $file_path = null;
            if ($existing && $existing['file_path'] && file_exists(__DIR__ . '/../../public/' . $existing['file_path'])) {
                @unlink(__DIR__ . '/../../public/' . $existing['file_path']);
            }
        }

        if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === UPLOAD_ERR_OK) {
             // Delete old file if exists
            if ($existing && $existing['file_path'] && file_exists(__DIR__ . '/../../public/' . $existing['file_path'])) {
                @unlink(__DIR__ . '/../../public/' . $existing['file_path']);
            }
            $file_path = $this->uploadFile($_FILES['file_path'], 'news_files');
        }

        // Set published_at only when changing from draft to published
        $published_at_clause = '';
        if ($status === 'published' && $existing['status'] === 'draft') {
            $published_at_clause = ', published_at = NOW()';
        }

        $query = "UPDATE news SET title = $1, slug = $2, excerpt = $3, content = $4, image = $5, file_path = $6, category = $7, 
                  tags = $8, status = $9, updated_at = NOW()" . $published_at_clause . " WHERE id = $10";
        $result = @pg_query_params($this->db, $query, [$title, $slug, $excerpt, $content, $image, $file_path, $category, $tags, $status, $id]);

        if ($result) {
            $_SESSION['success'] = 'Berita berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate berita: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-news');
        exit;
    }

    private function deleteNews()
    {
        $id = intval($_GET['id'] ?? 0);

        $query = "DELETE FROM news WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result) {
            $_SESSION['success'] = 'Berita berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus berita!';
        }

        header('Location: index.php?page=admin-news');
        exit;
    }

    // Manajemen Riset
    public function research()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../models/research.php';
        $researchModel = new Research($this->db);

        $action = $_GET['action'] ?? 'index';

        // Tangani berbagai aksi
        switch ($action) {
            case 'create':
                include __DIR__ . '/../../view/admin/research/create.php';
                break;

            case 'store':
                $this->storeResearch($researchModel);
                break;

            case 'edit':
                $id = intval($_GET['id'] ?? 0);
                $researchItem = $researchModel->getById($id);
                if ($researchItem) {
                    include __DIR__ . '/../../view/admin/research/edit.php';
                } else {
                    $_SESSION['error'] = 'Riset tidak ditemukan';
                    header('Location: index.php?page=admin-research');
                    exit;
                }
                break;

            case 'update':
                $this->updateResearch($researchModel);
                break;

            case 'delete':
                $this->deleteResearch($researchModel);
                break;

            default:
                // Index - daftar semua riset
                $filter = $_GET['filter'] ?? 'all';
                $allResearch = $researchModel->getAll();

                if ($filter === 'active') {
                    $researchList = array_filter($allResearch, function ($r) {
                        return $r['status'] === 'active';
                    });
                } elseif ($filter === 'completed') {
                    $researchList = array_filter($allResearch, function ($r) {
                        return $r['status'] === 'completed';
                    });
                } else {
                    $researchList = $allResearch;
                }

                include __DIR__ . '/../../view/admin/research/index.php';
                break;
        }
    }

    private function storeResearch($model)
    {
        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? '',
            'status' => $_POST['status'] ?? 'active',
            'start_date' => !empty($_POST['start_date']) ? $_POST['start_date'] : null,
            'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
            'funding' => !empty($_POST['funding']) ? $_POST['funding'] : null,
            'team_members' => !empty($_POST['team_members']) ? $_POST['team_members'] : null,
            'publications' => !empty($_POST['publications']) ? $_POST['publications'] : null,
            'leader_id' => $_SESSION['user']['id'] ?? null
        ];

        $data['image'] = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $data['image'] = $this->uploadImage($_FILES['image'], 'research');
        }

        // Add URL (Link Penelitian)
        $data['url'] = $_POST['url'] ?? null;

        if ($model->create($data)) {
            $_SESSION['success'] = 'Riset berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan riset: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-research');
        exit;
    }

    private function updateResearch($model)
    {
        $id = intval($_GET['id'] ?? 0);
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error'] = 'Riset tidak ditemukan';
            header('Location: index.php?page=admin-research');
            exit;
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? '',
            'status' => $_POST['status'] ?? 'active',
            'start_date' => !empty($_POST['start_date']) ? $_POST['start_date'] : null,
            'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
            'funding' => !empty($_POST['funding']) ? $_POST['funding'] : null,
            'team_members' => !empty($_POST['team_members']) ? $_POST['team_members'] : null,
            'publications' => !empty($_POST['publications']) ? $_POST['publications'] : null,
            'url' => !empty($_POST['url']) ? $_POST['url'] : null
        ];

        $data['image'] = $existing['image'];

        // Check if user wants to remove current image
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            $data['image'] = null;
            if ($existing['image'] && file_exists(__DIR__ . '/../../public/' . $existing['image'])) {
                @unlink(__DIR__ . '/../../public/' . $existing['image']);
            }
        }

        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if ($existing['image'] && file_exists(__DIR__ . '/../../public/' . $existing['image'])) {
                @unlink(__DIR__ . '/../../public/' . $existing['image']);
            }
            $data['image'] = $this->uploadImage($_FILES['image'], 'research');
        }

        if ($model->update($id, $data)) {
            $_SESSION['success'] = 'Riset berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate riset.';
        }

        header('Location: index.php?page=admin-research');
        exit;
    }

    private function deleteResearch($model)
    {
        $id = intval($_GET['id'] ?? 0);
        $existing = $model->getById($id);

        if ($model->delete($id)) {
            if ($existing && $existing['image'] && file_exists(__DIR__ . '/../../public/' . $existing['image'])) {
                @unlink(__DIR__ . '/../../public/' . $existing['image']);
            }
            $_SESSION['success'] = 'Riset berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus riset!';
        }

        header('Location: index.php?page=admin-research');
        exit;
    }

    // Manajemen Member
    public function members()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_GET['action'] ?? 'index';
        $id = intval($_GET['id'] ?? 0);

        if ($action === 'set-alumni' && $id > 0) {
            $this->updateMemberStatus($id, 'inactive');
        } elseif ($action === 'set-active' && $id > 0) {
            $this->updateMemberStatus($id, 'active');
        } elseif ($action === 'delete' && $id > 0) {
            $this->deleteMember($id);
        } elseif ($action === 'create') {
            header('Location: index.php?page=admin-members');
            exit;
        }

        // Get filter
        $filter = $_GET['filter'] ?? 'all';

        // Fetch members
        $query = "SELECT u.id, COALESCE(m.nama, u.username) as name, u.email, u.status, u.created_at, m.nim
                  FROM users u 
                  JOIN roles r ON u.role_id = r.id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id 
                  WHERE r.role_name = 'mahasiswa' 
                  ORDER BY u.created_at DESC";
        
        $result = pg_query($this->db, $query);
        $allMembers = [];
        if ($result) {
            $allMembers = pg_fetch_all($result) ?: [];
        }

        // Filter list
        if ($filter === 'active') {
            $membersList = array_filter($allMembers, fn($m) => $m['status'] === 'active');
        } elseif ($filter === 'inactive') {
            $membersList = array_filter($allMembers, fn($m) => $m['status'] === 'inactive');
        } else {
            $membersList = $allMembers;
        }

        include __DIR__ . '/../../view/admin/members/index.php';
    }

    private function updateMemberStatus($id, $status)
    {
        $query = "UPDATE users SET status = $1 WHERE id = $2";
        $result = @pg_query_params($this->db, $query, [$status, $id]);

        if ($result) {
            $_SESSION['success'] = 'Status member berhasil diperbarui!';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui status member: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-members');
        exit;
    }

    private function deleteMember($id)
    {
        pg_query($this->db, "BEGIN");
        try {
            $res1 = pg_query_params($this->db, "DELETE FROM mahasiswa WHERE user_id = $1", [$id]);
            $res2 = pg_query_params($this->db, "DELETE FROM users WHERE id = $1", [$id]);
            
            if ($res1 && $res2) {
                pg_query($this->db, "COMMIT");
                $_SESSION['success'] = 'Member berhasil dihapus selamanya!';
            } else {
                throw new Exception("Gagal menghapus data");
            }
        } catch (Exception $e) {
            pg_query($this->db, "ROLLBACK");
            $_SESSION['error'] = 'Gagal menghapus member: ' . $e->getMessage();
        }

        header('Location: index.php?page=admin-members');
        exit;
    }

    public function publications()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userRole = $_SESSION['user']['role'] ?? 'member';

        $action = $_GET['action'] ?? 'index';

        switch ($action) {
            case 'create':
                include __DIR__ . '/../../view/admin/publications/create.php';
                break;

            case 'store':
                $this->storePublication();
                break;

            case 'edit':
                $id = intval($_GET['id'] ?? 0);
                $query = "SELECT * FROM publications WHERE id = $1";
                $result = @pg_query_params($this->db, $query, [$id]);
                if ($result && pg_num_rows($result) > 0) {
                    $publication = pg_fetch_assoc($result);
                    include __DIR__ . '/../../view/admin/publications/edit.php';
                } else {
                    $_SESSION['error'] = 'Publikasi tidak ditemukan';
                    header('Location: index.php?page=admin-publications');
                    exit;
                }
                break;

            case 'update':
                $this->updatePublication();
                break;

            case 'delete':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    @pg_query_params($this->db, "DELETE FROM publications WHERE id = $1", [$id]);
                    $_SESSION['success'] = 'Publikasi berhasil dihapus';
                }
                header('Location: index.php?page=admin-publications');
                exit;
                break;

            default:
                $query = "SELECT * FROM publications ORDER BY created_at DESC";
                $result = @pg_query($this->db, $query);
                $publications = $result ? (pg_fetch_all($result) ?: []) : [];
                include __DIR__ . '/../../view/admin/publications/index.php';
                break;
        }
    }

    private function storePublication()
    {
        $title = $_POST['title'] ?? '';
        $authors = $_POST['authors'] ?? '';
        $year = intval($_POST['year'] ?? date('Y'));
        $type = $_POST['type'] ?? 'journal';
        $publisher = $_POST['publisher'] ?? '';
        $doi = $_POST['doi'] ?? '';
        $url = $_POST['url'] ?? '';

        // Opsional fields
        $volume = $_POST['volume'] ?? '';
        $issue = $_POST['issue'] ?? '';
        $pages = $_POST['pages'] ?? '';
        $indexed = $_POST['indexed'] ?? '';
        $citation_count = intval($_POST['citation_count'] ?? 0);
        $abstract = $_POST['abstract'] ?? '';

        // Handle PDF/Document upload
        $file_path = null;
        if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === UPLOAD_ERR_OK) {
            $file_path = $this->uploadFile($_FILES['file_path'], 'publications');
        }

        // Tentukan kolom mana yang diisi berdasarkan tipe
        $journal = ($type === 'journal' || $type === 'book' || $type === 'other') ? $publisher : null;
        $conference = ($type === 'conference' || $type === 'prosiding') ? $publisher : null;

        $query = "INSERT INTO publications (title, authors, year, type, journal, conference, doi, url, file_path, volume, issue, pages, indexed, citation_count, abstract, created_at, updated_at) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, NOW(), NOW())";
                  
        $params = [
            $title, $authors, $year, $type, $journal, $conference, 
            $doi, $url, $file_path, $volume, $issue, $pages, $indexed, $citation_count, $abstract
        ];

        $result = @pg_query_params($this->db, $query, $params);

        if ($result) {
            $_SESSION['success'] = 'Publikasi berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan publikasi: ' . pg_last_error($this->db);
        }
        
        header('Location: index.php?page=admin-publications');
        exit;
        header('Location: index.php?page=admin-publications');
        exit;
    }

    private function updatePublication()
    {
        $id = intval($_GET['id'] ?? 0);
        $title = $_POST['title'] ?? '';
        $authors = $_POST['authors'] ?? '';
        $year = intval($_POST['year'] ?? date('Y'));
        $type = $_POST['type'] ?? 'journal';
        $publisher = $_POST['publisher'] ?? '';
        $doi = $_POST['doi'] ?? '';
        $url = $_POST['url'] ?? '';

        // Opsional fields
        $volume = $_POST['volume'] ?? '';
        $issue = $_POST['issue'] ?? '';
        $pages = $_POST['pages'] ?? '';
        $indexed = $_POST['indexed'] ?? '';
        $abstract = $_POST['abstract'] ?? '';

        // Handle PDF/Document upload
        $file_path = null;
        if (isset($_POST['remove_file']) && $_POST['remove_file'] == '1') {
             // Logic to remove old file if needed
             $file_path = null; 
             // Ideally we should unlink old file but let's keep it simple or fetch old path to unlink
        }
        
        // If has new file
        if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === UPLOAD_ERR_OK) {
            $file_path = $this->uploadFile($_FILES['file_path'], 'publications');
        }

        // Tentukan kolom mana yang diisi berdasarkan tipe
        $journal = ($type === 'journal' || $type === 'book' || $type === 'other') ? $publisher : null;
        $conference = ($type === 'conference' || $type === 'prosiding') ? $publisher : null;

        // Build Query
        $sql = "UPDATE publications SET title=$1, authors=$2, year=$3, type=$4, journal=$5, conference=$6, 
                doi=$7, url=$8, volume=$9, issue=$10, pages=$11, indexed=$12, abstract=$13, updated_at=NOW()";
        
        $params = [
            $title, $authors, $year, $type, $journal, $conference, 
            $doi, $url, $volume, $issue, $pages, $indexed, $abstract
        ];
        
        $paramIndex = 14;

        if ($file_path !== null || (isset($_POST['remove_file']) && $_POST['remove_file'] == '1')) {
            $sql .= ", file_path=$" . $paramIndex;
            $params[] = $file_path;
            $paramIndex++;
        }

        $sql .= " WHERE id=$" . $paramIndex;
        $params[] = $id;

        $result = @pg_query_params($this->db, $sql, $params);

        if ($result) {
            $_SESSION['success'] = 'Publikasi berhasil diperbarui!';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui publikasi: ' . pg_last_error($this->db);
        }
        
        header('Location: index.php?page=admin-publications');
        exit;
    }

    public function students()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userRole = $_SESSION['user']['role'] ?? 'member';
        $userId = $_SESSION['user']['id'] ?? 0;
        
        $students = [];
        
        if ($userRole === 'dosen') {
             $dosenRes = @pg_query_params($this->db, "SELECT id FROM dosen WHERE user_id = $1", [$userId]);
             if ($dosenRes && pg_num_rows($dosenRes) > 0) {
                 $dosenId = pg_fetch_result($dosenRes, 0, 0);
                 $query = "SELECT m.*, u.email, u.status, u.username, 
                           COALESCE(m.nama, u.username) as display_name
                           FROM mahasiswa m 
                           JOIN users u ON m.user_id = u.id 
                           WHERE m.supervisor_id = $1 
                           ORDER BY m.angkatan DESC";
                 $result = @pg_query_params($this->db, $query, [$dosenId]);
                 if ($result) $students = pg_fetch_all($result) ?: [];
             }
        } else {
             $query = "SELECT m.*, u.email, u.status, u.username, d.nama as dosen_nama,
                       COALESCE(m.nama, u.username) as display_name
                       FROM mahasiswa m 
                       JOIN users u ON m.user_id = u.id 
                       LEFT JOIN dosen d ON m.supervisor_id = d.id
                       ORDER BY m.angkatan DESC";
             $result = @pg_query($this->db, $query);
             if ($result) $students = pg_fetch_all($result) ?: [];
        }
        include __DIR__ . '/../../view/admin/students/index.php';
    }

    // Manajemen Peralatan
    public function equipment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_GET['action'] ?? 'index';

        // Tangani berbagai aksi
        switch ($action) {
            case 'create':
                include __DIR__ . '/../../view/admin/equipment/create.php';
                break;

            case 'store':
                $this->storeEquipment();
                break;

            case 'edit':
                $id = intval($_GET['id'] ?? 0);
                $equipmentItem = $this->getEquipmentById($id);
                if ($equipmentItem) {
                    include __DIR__ . '/../../view/admin/equipment/edit.php';
                } else {
                    $_SESSION['error'] = 'Peralatan tidak ditemukan';
                    header('Location: index.php?page=admin-equip');
                    exit;
                }
                break;

            case 'update':
                $this->updateEquipment();
                break;

            case 'delete':
                $this->deleteEquipment();
                break;

            default:
                // Index - daftar semua peralatan
                $filter = $_GET['filter'] ?? 'all';
                $allEquipment = $this->getAllEquipment();

                if ($filter !== 'all') {
                    $equipmentList = array_filter($allEquipment, fn($e) => $e['category'] === $filter);
                } else {
                    $equipmentList = $allEquipment;
                }

                include __DIR__ . '/../../view/admin/equipment/index.php';
                break;
        }
    }

    private function getAllEquipment()
    {
        $query = "SELECT * FROM equipment ORDER BY name ASC";
        $result = @pg_query($this->db, $query);
        $equipment = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $equipment[] = $row;
            }
        }

        return $equipment;
    }

    private function getEquipmentById($id)
    {
        $query = "SELECT * FROM equipment WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }

        return null;
    }

    private function storeEquipment()
    {
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $quantity = intval($_POST['quantity'] ?? 1);
        $condition = $_POST['condition'] ?? 'baik';

        // Convert empty string to null for optional fields
        $brand = !empty($_POST['brand']) ? $_POST['brand'] : null;
        $purchase_year = !empty($_POST['purchase_year']) ? intval($_POST['purchase_year']) : null;
        $location = !empty($_POST['location']) ? $_POST['location'] : null;
        $specifications = !empty($_POST['specifications']) ? $_POST['specifications'] : null;
        $notes = !empty($_POST['notes']) ? $_POST['notes'] : null;

        $query = "INSERT INTO equipment (name, category, brand, quantity, condition, 
                  purchase_year, location, specifications, notes, created_at) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, NOW()) RETURNING id";
        $result = @pg_query_params($this->db, $query, [
            $name,
            $category,
            $brand,
            $quantity,
            $condition,
            $purchase_year,
            $location,
            $specifications,
            $notes
        ]);

        if ($result) {
            $_SESSION['success'] = 'Peralatan berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan peralatan: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-equip');
        exit;
    }

    private function updateEquipment()
    {
        $id = intval($_GET['id'] ?? 0);
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $quantity = intval($_POST['quantity'] ?? 1);
        $condition = $_POST['condition'] ?? 'baik';

        // Convert empty string to null for optional fields
        $brand = !empty($_POST['brand']) ? $_POST['brand'] : null;
        $purchase_year = !empty($_POST['purchase_year']) ? intval($_POST['purchase_year']) : null;
        $location = !empty($_POST['location']) ? $_POST['location'] : null;
        $specifications = !empty($_POST['specifications']) ? $_POST['specifications'] : null;
        $notes = !empty($_POST['notes']) ? $_POST['notes'] : null;

        $query = "UPDATE equipment SET name = $1, category = $2, brand = $3, quantity = $4, 
                  condition = $5, purchase_year = $6, location = $7, specifications = $8, 
                  notes = $9, updated_at = NOW() WHERE id = $10";
        $result = @pg_query_params($this->db, $query, [
            $name,
            $category,
            $brand,
            $quantity,
            $condition,
            $purchase_year,
            $location,
            $specifications,
            $notes,
            $id
        ]);

        if ($result) {
            $_SESSION['success'] = 'Peralatan berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate peralatan!';
        }

        header('Location: index.php?page=admin-equip');
        exit;
    }

    private function deleteEquipment()
    {
        $id = intval($_GET['id'] ?? 0);

        $query = "DELETE FROM equipment WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result) {
            $_SESSION['success'] = 'Peralatan berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus peralatan!';
        }

        header('Location: index.php?page=admin-equip');
        exit;
    }



    // Manajemen Pengaturan
    public function settings()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_GET['action'] ?? '';

        // Handle actions
        if ($action === 'update-profile') {
            $this->updateProfile();
        } elseif ($action === 'change-password') {
            $this->changePassword();
        }


        // Ambil data user saat ini
        $userId = $_SESSION['user_id'] ?? 0;
        $currentUser = $this->getUserById($userId);



        include __DIR__ . '/../../view/admin/settings/index.php';
    }

    private function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }

        return null;
    }

    private function updateProfile()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $nim = $_POST['nim'] ?? '';
        $bio = $_POST['bio'] ?? '';

        // Tangani upload foto
        $photoPath = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/uploads/profiles/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExtension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = 'profile_' . $userId . '_' . time() . '.' . $fileExtension;
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                    $photoPath = 'assets/uploads/profiles/' . $fileName;
                }
            }
        }

        // Query update
        if ($photoPath) {
            $query = "UPDATE users SET username = $1, email = $2, bio = $3, photo = $4, updated_at = NOW() WHERE id = $5";
            $result = @pg_query_params($this->db, $query, [$name, $email, $bio, $photoPath, $userId]);
        } else {
            $query = "UPDATE users SET username = $1, email = $2, bio = $3, updated_at = NOW() WHERE id = $4";
            $result = @pg_query_params($this->db, $query, [$name, $email, $bio, $userId]);
        }

        if ($result) {
            $_SESSION['success'] = 'Profil berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate profil: ' . pg_last_error($this->db);
        }

        header('Location: ?page=admin-settings&tab=profile');
        exit;
    }

    private function changePassword()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Verifikasi password baru cocok
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Password baru tidak cocok!';
            header('Location: index.php?page=admin-settings&tab=security');
            exit;
        }

        // Ambil user saat ini
        $user = $this->getUserById($userId);

        // Verifikasi password saat ini
        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error'] = 'Password saat ini salah!';
            header('Location: index.php?page=admin-settings&tab=security');
            exit;
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = $1, updated_at = NOW() WHERE id = $2";
        $result = @pg_query_params($this->db, $query, [$hashedPassword, $userId]);

        if ($result) {
            $_SESSION['success'] = 'Password berhasil diubah!';
        } else {
            $_SESSION['error'] = 'Gagal mengubah password!';
        }

        header('Location: index.php?page=admin-settings&tab=security');
        exit;
    }



    // Helper Methods
    private function generateSlug($title)
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    private function uploadImage($file, $folder = 'uploads')
    {
        $upload_dir = __DIR__ . '/../../public/uploads/' . $folder . '/';

        // Buat direktori jika belum ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($file['type'], $allowed_types)) {
            return null;
        }

        if ($file['size'] > $max_size) {
            return null;
        }

        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
        $file_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return 'uploads/' . $folder . '/' . $new_filename;
        }

        return null;
    }

    private function uploadFile($file, $folder = 'documents')
    {
        $upload_dir = __DIR__ . '/../../public/uploads/' . $folder . '/';

        // Buat direktori jika belum ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = [
            'application/pdf', 
            'application/msword', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/zip',
            'application/x-rar-compressed'
        ];
        $max_size = 10 * 1024 * 1024; // 10MB

        if (!in_array($file['type'], $allowed_types)) {
            // Fallback check by extension if mime type fails or differs
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_exts = ['pdf', 'doc', 'docx', 'zip', 'rar'];
            if (!in_array($ext, $allowed_exts)) {
                return null;
            }
        }

        if ($file['size'] > $max_size) {
            return null;
        }

        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '_' . time() . '.' . $file_ext;
        $file_path = $upload_dir . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            return 'uploads/' . $folder . '/' . $new_filename;
        }

        return null;
    }
}

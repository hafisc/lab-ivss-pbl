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
        // Pastikan session aktif
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Jika belum login atau bukan role admin/dosen/ketua_lab, arahkan ke halaman login
        $userRole = $_SESSION['user']['role'] ?? null;
        if (!$userRole || !in_array($userRole, ['admin', 'dosen', 'ketua_lab'])) {
            // Simpan pesan dan redirect ke login
            $_SESSION['error'] = 'Akses admin hanya untuk pengguna tertentu. Silakan login sebagai admin/dosen/ketua lab.';
            header('Location: index.php?page=login');
            exit;
        }

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
        $query = "SELECT COUNT(*) as total FROM users WHERE role = 'member' AND status = 'active'";
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
        $query = "SELECT COUNT(*) as total FROM users WHERE role = 'member' AND status = 'inactive'";
        $result = pg_query($this->db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['total'] ?? 0;
        }
        return 0;
    }

    private function getTotalRiset()
    {
        // Asumsi tabel research/riset sudah ada
        $query = "SELECT COUNT(*) as total FROM research WHERE status = 'active'";
        $result = @pg_query($this->db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['total'] ?? 0;
        }
        return 0;
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
                u.username as supervisor_name,
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
        $userId = $_SESSION['user']['id'] ?? 0;

        // Ambil data pendaftaran
        $query = "SELECT * FROM member_registrations WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result && pg_num_rows($result) > 0) {
            $registration = pg_fetch_assoc($result);
            $currentStatus = $registration['status'];

            // Validasi berdasarkan role
            if ($userRole === 'dosen') {
                // Dosen hanya bisa approve yang pending_supervisor
                if ($currentStatus !== 'pending_supervisor') {
                    $_SESSION['error'] = 'Pendaftar ini tidak dalam status menunggu approval dosen!';
                    return;
                }

                // Validasi dosen hanya bisa approve pendaftar yang pilih dirinya
                if ($registration['supervisor_id'] != $userId) {
                    $_SESSION['error'] = 'Anda tidak bisa approve pendaftar yang tidak memilih Anda sebagai pembimbing!';
                    return;
                }

                // Update ke pending_lab_head
                $updateQuery = "UPDATE member_registrations 
                               SET status = 'pending_lab_head', 
                                   supervisor_approved_at = CURRENT_TIMESTAMP 
                               WHERE id = $1";
                $result = @pg_query_params($this->db, $updateQuery, [$id]);

                if ($result) {
                    $_SESSION['success'] = 'Pendaftar berhasil di-approve! Sekarang menunggu approval Ketua Lab.';
                } else {
                    $_SESSION['error'] = 'Gagal approve pendaftar!';
                }
            } elseif ($userRole === 'ketua_lab') {
                // Ketua Lab approve dari pending_lab_head ke approved + create user
                if ($currentStatus !== 'pending_lab_head') {
                    $_SESSION['error'] = 'Pendaftar ini belum di-approve dosen atau sudah diproses!';
                    return;
                }

                // Gunakan password yang sudah disimpan saat registrasi
                $password = $registration['password'] ?? password_hash('member123', PASSWORD_BCRYPT);

                // Buat akun user
                $insertQuery = "INSERT INTO users (name, email, password, role, status, nim, phone, angkatan) 
                               VALUES ($1, $2, $3, 'member', 'active', $4, $5, $6)";
                $insertResult = @pg_query_params($this->db, $insertQuery, [
                    $registration['name'],
                    $registration['email'],
                    $password,
                    $registration['nim'] ?? null,
                    $registration['phone'] ?? null,
                    $registration['angkatan'] ?? null
                ]);

                if ($insertResult) {
                    // Update status pendaftaran
                    $updateQuery = "UPDATE member_registrations 
                                   SET status = 'approved', 
                                       lab_head_approved_at = CURRENT_TIMESTAMP 
                                   WHERE id = $1";
                    @pg_query_params($this->db, $updateQuery, [$id]);

                    $_SESSION['success'] = 'Pendaftar berhasil di-approve! Akun member telah dibuat dan aktif.';

                    // TODO: Kirim email notifikasi ke mahasiswa bahwa akun sudah aktif

                } else {
                    $_SESSION['error'] = 'Gagal membuat akun user: ' . pg_last_error($this->db);
                }
            } else {
                // Admin TIDAK bisa approve - hanya Dosen dan Ketua Lab
                $_SESSION['error'] = 'Admin tidak memiliki akses untuk approve pendaftar. Silakan hubungi Dosen atau Ketua Lab.';
                return;
            }
        } else {
            $_SESSION['error'] = 'Pendaftar tidak ditemukan!';
        }
    }

    private function rejectRegistration($id)
    {
        session_start();

        $userRole = $_SESSION['user']['role'] ?? 'member';
        $userId = $_SESSION['user']['id'] ?? 0;

        // Ambil data pendaftaran
        $query = "SELECT * FROM member_registrations WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result && pg_num_rows($result) > 0) {
            $registration = pg_fetch_assoc($result);
            $currentStatus = $registration['status'];

            // Tentukan status rejection berdasarkan role
            if ($userRole === 'dosen') {
                if ($currentStatus !== 'pending_supervisor') {
                    $_SESSION['error'] = 'Anda tidak bisa menolak pendaftar di tahap ini!';
                    return;
                }
                $newStatus = 'rejected_supervisor';
                $message = 'Pendaftar berhasil ditolak. Email notifikasi akan dikirim.';
            } elseif ($userRole === 'ketua_lab') {
                if ($currentStatus !== 'pending_lab_head') {
                    $_SESSION['error'] = 'Pendaftar belum di tahap approval Ketua Lab!';
                    return;
                }
                $newStatus = 'rejected_lab_head';
                $message = 'Pendaftar berhasil ditolak. Email notifikasi akan dikirim.';
            } else {
                // Admin TIDAK bisa reject - hanya Dosen dan Ketua Lab
                $_SESSION['error'] = 'Admin tidak memiliki akses untuk reject pendaftar. Silakan hubungi Dosen atau Ketua Lab.';
                return;
            }

            // Update status ke rejected
            $updateQuery = "UPDATE member_registrations SET status = $1 WHERE id = $2";
            $result = @pg_query_params($this->db, $updateQuery, [$newStatus, $id]);

            if ($result) {
                $_SESSION['success'] = $message;
                // TODO: Kirim email notifikasi rejection
            } else {
                $_SESSION['error'] = 'Gagal menolak pendaftar!';
            }
        } else {
            $_SESSION['error'] = 'Pendaftar tidak ditemukan!';
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

        // Set author_id and published_at
        $author_id = $_SESSION['user_id'] ?? 1;
        $published_at = ($status === 'published') ? 'NOW()' : null;

        $query = "INSERT INTO news (title, slug, excerpt, content, image, category, tags, author_id, status, published_at, created_at) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, " . ($published_at ? $published_at : 'NULL') . ", NOW()) RETURNING id";
        $result = @pg_query_params($this->db, $query, [$title, $slug, $excerpt, $content, $image, $category, $tags, $author_id, $status]);

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

        // Set published_at only when changing from draft to published
        $published_at_clause = '';
        if ($status === 'published' && $existing['status'] === 'draft') {
            $published_at_clause = ', published_at = NOW()';
        }

        $query = "UPDATE news SET title = $1, slug = $2, excerpt = $3, content = $4, image = $5, category = $6, 
                  tags = $7, status = $8, updated_at = NOW()" . $published_at_clause . " WHERE id = $9";
        $result = @pg_query_params($this->db, $query, [$title, $slug, $excerpt, $content, $image, $category, $tags, $status, $id]);

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

        $action = $_GET['action'] ?? 'index';

        // Tangani berbagai aksi
        switch ($action) {
            case 'create':
                include __DIR__ . '/../../view/admin/research/create.php';
                break;

            case 'store':
                $this->storeResearch();
                break;

            case 'edit':
                $id = intval($_GET['id'] ?? 0);
                $researchItem = $this->getResearchById($id);
                if ($researchItem) {
                    include __DIR__ . '/../../view/admin/research/edit.php';
                } else {
                    $_SESSION['error'] = 'Riset tidak ditemukan';
                    header('Location: index.php?page=admin-research');
                    exit;
                }
                break;

            case 'update':
                $this->updateResearch();
                break;

            case 'delete':
                $this->deleteResearch();
                break;

            default:
                // Index - daftar semua riset
                $filter = $_GET['filter'] ?? 'all';
                $allResearch = $this->getAllResearch();

                if ($filter === 'active') {
                    $researchList = array_filter($allResearch, fn($r) => $r['status'] === 'active');
                } elseif ($filter === 'completed') {
                    $researchList = array_filter($allResearch, fn($r) => $r['status'] === 'completed');
                } else {
                    $researchList = $allResearch;
                }

                include __DIR__ . '/../../view/admin/research/index.php';
                break;
        }
    }

    private function getAllResearch()
    {
        $query = "SELECT * FROM research ORDER BY created_at DESC";
        $result = @pg_query($this->db, $query);
        $research = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                // Format image URL
                if (!empty($row['image'])) {
                    $row['image_url'] = $row['image'];
                } else {
                    $row['image_url'] = null;
                }
                $research[] = $row;
            }
        }

        return $research;
    }

    private function getResearchById($id)
    {
        $query = "SELECT * FROM research WHERE id = $1";
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

    private function storeResearch()
    {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $status = $_POST['status'] ?? 'active';

        // Convert empty string to null for date fields
        $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

        // Convert empty string to null for optional text fields
        $funding = !empty($_POST['funding']) ? $_POST['funding'] : null;
        $team_members = !empty($_POST['team_members']) ? $_POST['team_members'] : null;
        $publications = !empty($_POST['publications']) ? $_POST['publications'] : null;

        // Handle image upload
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $this->uploadImage($_FILES['image'], 'research');
        }

        // Set leader_id dari session
        $leader_id = $_SESSION['user_id'] ?? null;

        $query = "INSERT INTO research (title, description, category, image, leader_id, status, start_date, end_date, 
                  funding, team_members, publications, created_at) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, NOW()) RETURNING id";
        $result = @pg_query_params($this->db, $query, [
            $title,
            $description,
            $category,
            $image,
            $leader_id,
            $status,
            $start_date,
            $end_date,
            $funding,
            $team_members,
            $publications
        ]);

        if ($result) {
            $_SESSION['success'] = 'Riset berhasil ditambahkan!';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan riset: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-research');
        exit;
    }

    private function updateResearch()
    {
        $id = intval($_GET['id'] ?? 0);
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $status = $_POST['status'] ?? 'active';

        // Convert empty string to null for date fields
        $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

        // Convert empty string to null for optional text fields
        $funding = !empty($_POST['funding']) ? $_POST['funding'] : null;
        $team_members = !empty($_POST['team_members']) ? $_POST['team_members'] : null;
        $publications = !empty($_POST['publications']) ? $_POST['publications'] : null;

        // Get existing research
        $existing = $this->getResearchById($id);
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
            $image = $this->uploadImage($_FILES['image'], 'research');
        }

        $query = "UPDATE research SET title = $1, description = $2, category = $3, image = $4, status = $5, 
                  start_date = $6, end_date = $7, funding = $8, team_members = $9, 
                  publications = $10, updated_at = NOW() WHERE id = $11";
        $result = @pg_query_params($this->db, $query, [
            $title,
            $description,
            $category,
            $image,
            $status,
            $start_date,
            $end_date,
            $funding,
            $team_members,
            $publications,
            $id
        ]);

        if ($result) {
            $_SESSION['success'] = 'Riset berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate riset: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-research');
        exit;
    }

    private function deleteResearch()
    {
        $id = intval($_GET['id'] ?? 0);

        // Get existing research to delete image
        $existing = $this->getResearchById($id);

        $query = "DELETE FROM research WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$id]);

        if ($result) {
            // Delete image file if exists
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
        // Tangani aksi CRUD sederhana untuk member
        $action = $_GET['action'] ?? null;

        if ($action === 'create') {
            // Show create form
            $member = ['name' => '', 'email' => '', 'nim' => '', 'status' => 'active'];
            include __DIR__ . '/../../view/admin/members/form.php';
            return;
        }

        if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Insert new member into users table
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $nim = $_POST['nim'] ?? null;
            $status = $_POST['status'] ?? 'active';
            $password = $_POST['password'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Nama, email, dan password wajib diisi.';
                header('Location: index.php?page=admin-members&action=create');
                exit;
            }

            // Hash password (simple) - use password_hash if available
            if (function_exists('password_hash')) {
                $pw = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $pw = md5($password);
            }

            $query = "INSERT INTO users (name, email, nim, status, role, password, created_at) VALUES ($1,$2,$3,$4,$5,$6,NOW())";
            $res = @pg_query_params($this->db, $query, [$name, $email, $nim, $status, 'member', $pw]);

            if ($res) {
                $_SESSION['success'] = 'Member berhasil ditambahkan.';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan member: ' . pg_last_error($this->db);
            }

            header('Location: index.php?page=admin-members');
            exit;
        }

        if ($action === 'edit' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $member = $this->getMemberById($id);
            if (!$member) {
                $_SESSION['error'] = 'Member tidak ditemukan.';
                header('Location: index.php?page=admin-members');
                exit;
            }
            include __DIR__ . '/../../view/admin/members/form.php';
            return;
        }

        if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $nim = $_POST['nim'] ?? null;
            $status = $_POST['status'] ?? 'active';

            if (empty($name) || empty($email)) {
                $_SESSION['error'] = 'Nama dan email wajib diisi.';
                header('Location: index.php?page=admin-members&action=edit&id=' . $id);
                exit;
            }

            $query = "UPDATE users SET name = $1, email = $2, nim = $3, status = $4, updated_at = NOW() WHERE id = $5 AND role = 'member'";
            $res = @pg_query_params($this->db, $query, [$name, $email, $nim, $status, $id]);

            if ($res) {
                $_SESSION['success'] = 'Member berhasil diupdate.';
            } else {
                $_SESSION['error'] = 'Gagal mengupdate member: ' . pg_last_error($this->db);
            }

            header('Location: index.php?page=admin-members');
            exit;
        }

        if ($action === 'view' && isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $member = $this->getMemberById($id);
            if (!$member) {
                $_SESSION['error'] = 'Member tidak ditemukan.';
                header('Location: index.php?page=admin-members');
                exit;
            }
            include __DIR__ . '/../../view/admin/members/view.php';
            return;
        }

        // existing small actions: set-alumni, set-active, delete
        if (isset($_GET['action']) && isset($_GET['id'])) {
            $actionSmall = $_GET['action'];
            $idSmall = intval($_GET['id']);

            if ($actionSmall === 'set-alumni') {
                $this->setMemberStatus($idSmall, 'inactive');
                $_SESSION['success'] = 'Member berhasil dijadikan alumni!';
                header('Location: index.php?page=admin-members');
                exit;
            } elseif ($actionSmall === 'set-active') {
                $this->setMemberStatus($idSmall, 'active');
                $_SESSION['success'] = 'Member berhasil diaktifkan kembali!';
                header('Location: index.php?page=admin-members');
                exit;
            } elseif ($actionSmall === 'delete') {
                $this->deleteMember($idSmall);
                $_SESSION['success'] = 'Member berhasil dihapus!';
                header('Location: index.php?page=admin-members');
                exit;
            }
        }

        // Default: Index - daftar semua member
        $filter = $_GET['filter'] ?? 'all';
        $allMembers = $this->getAllMembers();

        if ($filter === 'active') {
            $membersList = array_filter($allMembers, fn($m) => $m['status'] === 'active');
        } elseif ($filter === 'inactive') {
            $membersList = array_filter($allMembers, fn($m) => $m['status'] === 'inactive');
        } else {
            $membersList = $allMembers;
        }

        include __DIR__ . '/../../view/admin/members/index.php';
    }

    private function getAllMembers()
    {
        $query = "SELECT * FROM users WHERE role = 'member' ORDER BY created_at DESC";
        $result = @pg_query($this->db, $query);
        $members = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $members[] = $row;
            }
        }

        return $members;
    }

    private function getMemberById($id)
    {
        $query = "SELECT * FROM users WHERE id = $1 AND role = 'member' LIMIT 1";
        $res = @pg_query_params($this->db, $query, [$id]);
        if ($res && pg_num_rows($res) > 0) {
            return pg_fetch_assoc($res);
        }
        return null;
    }

    private function setMemberStatus($id, $status)
    {
        $query = "UPDATE users SET status = $1 WHERE id = $2 AND role = 'member'";
        @pg_query_params($this->db, $query, [$status, $id]);
    }

    private function deleteMember($id)
    {
        $query = "DELETE FROM users WHERE id = $1 AND role = 'member'";
        @pg_query_params($this->db, $query, [$id]);
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
        } elseif ($action === 'update-system') {
            $this->updateSystemSettings();
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
            $query = "UPDATE users SET name = $1, email = $2, phone = $3, nim = $4, bio = $5, photo = $6, updated_at = NOW() WHERE id = $7";
            $result = @pg_query_params($this->db, $query, [$name, $email, $phone, $nim, $bio, $photoPath, $userId]);
        } else {
            $query = "UPDATE users SET name = $1, email = $2, phone = $3, nim = $4, bio = $5, updated_at = NOW() WHERE id = $6";
            $result = @pg_query_params($this->db, $query, [$name, $email, $phone, $nim, $bio, $userId]);
        }

        if ($result) {
            $_SESSION['success'] = 'Profil berhasil diupdate!';
        } else {
            $_SESSION['error'] = 'Gagal mengupdate profil: ' . pg_last_error($this->db);
        }

        header('Location: index.php?page=admin-settings&tab=profile');
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

    private function updateSystemSettings()
    {
        // TODO: Implementasi update pengaturan sistem
        $_SESSION['success'] = 'Pengaturan sistem berhasil diupdate!';
        header('Location: index.php?page=admin-settings&tab=system');
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
}

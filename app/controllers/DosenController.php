<?php

/**
 * DosenController - Controller untuk menampilkan data dosen
 * Menggunakan DosenModel untuk mengakses data dari database
 */

require_once __DIR__ . '/../models/DosenModel.php';

class DosenController
{
    private $db;
    private $dosenModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->dosenModel = new DosenModel($db);
    }

    /**
     * Tampilkan daftar semua dosen
     */
    public function index()
    {
        // Ambil parameter pencarian dari GET
        $search = trim($_GET['search'] ?? '');
        $status = $_GET['status'] ?? 'active';

        $dosen = [];

        if (!empty($search)) {
            // Jika ada pencarian, gunakan search function
            $dosen = $this->dosenModel->searchDosen($search);
        } elseif ($status && $status !== 'all') {
            // Jika ada filter status
            $dosen = $this->dosenModel->getDosenByStatus($status);
        } else {
            // Tampilkan semua dosen
            $dosen = $this->dosenModel->getDaftarDosenLengkap();
        }

        // Render content dengan layout admin
        $title = 'Daftar Dosen Pengampu';
        ob_start();
        include __DIR__ . '/../../view/admin/dosen/index.php';
        $content = ob_get_clean();

        // Include admin layout
        include __DIR__ . '/../../view/layouts/admin.php';
    }

    /**
     * Tampilkan form tambah dosen
     */
    public function create()
    {
        $title = 'Tambah Dosen Baru';
        ob_start();
        include __DIR__ . '/../../view/admin/dosen/create.php';
        $content = ob_get_clean();

        include __DIR__ . '/../../view/layouts/admin.php';
    }

    /**
     * Simpan data dosen baru
     */
    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        // Ambil data dari form
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $nip = trim($_POST['nip'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $origin = trim($_POST['origin'] ?? '');
        $no_hp = trim($_POST['no_hp'] ?? '');
        $status = $_POST['status'] ?? 'active';

        // Validasi input
        if (empty($username) || empty($email) || empty($password) || empty($nip) || empty($nama) || empty($origin)) {
            $_SESSION['error'] = 'Semua field wajib diisi!';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password minimal 8 karakter!';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        if ($password !== $password_confirm) {
            $_SESSION['error'] = 'Password dan konfirmasi password tidak cocok!';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Format email tidak valid!';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        // Cek apakah username sudah digunakan
        $checkQuery = "SELECT id FROM users WHERE username = $1 LIMIT 1";
        $checkResult = @pg_query_params($this->db, $checkQuery, [$username]);
        if ($checkResult && pg_num_rows($checkResult) > 0) {
            $_SESSION['error'] = 'Username sudah digunakan! Gunakan username lain.';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        // Cek apakah email sudah digunakan
        $checkQuery = "SELECT id FROM users WHERE email = $1 LIMIT 1";
        $checkResult = @pg_query_params($this->db, $checkQuery, [$email]);
        if ($checkResult && pg_num_rows($checkResult) > 0) {
            $_SESSION['error'] = 'Email sudah terdaftar! Gunakan email lain.';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        // Cek apakah NIP sudah digunakan
        $checkQuery = "SELECT id FROM dosen WHERE nip = $1 LIMIT 1";
        $checkResult = @pg_query_params($this->db, $checkQuery, [$nip]);
        if ($checkResult && pg_num_rows($checkResult) > 0) {
            $_SESSION['error'] = 'NIP sudah terdaftar! Gunakan NIP lain.';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Get role_id untuk dosen (role_id = 3)
        $roleQuery = "SELECT id FROM roles WHERE role_name = 'dosen' LIMIT 1";
        $roleResult = @pg_query($this->db, $roleQuery);

        if (!$roleResult || pg_num_rows($roleResult) === 0) {
            $_SESSION['error'] = 'Gagal menemukan role dosen di database!';
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        $roleRow = pg_fetch_assoc($roleResult);
        $roleId = $roleRow['id'];

        // Insert user baru
        $insertUserQuery = "INSERT INTO users (username, email, password, role_id, status, created_at, updated_at) 
                           VALUES ($1, $2, $3, $4, $5, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) 
                           RETURNING id";
        $insertUserResult = @pg_query_params($this->db, $insertUserQuery, [
            $username,
            $email,
            $hashedPassword,
            $roleId,
            $status
        ]);

        if (!$insertUserResult) {
            $_SESSION['error'] = 'Gagal membuat user akun dosen: ' . pg_last_error($this->db);
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        $userRow = pg_fetch_assoc($insertUserResult);
        $userId = $userRow['id'];

        // Insert data dosen
        $insertDosenQuery = "INSERT INTO dosen (user_id, nip, nama, origin, no_hp, created_at, updated_at) 
                            VALUES ($1, $2, $3, $4, $5, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) 
                            RETURNING id";
        $insertDosenResult = @pg_query_params($this->db, $insertDosenQuery, [
            $userId,
            $nip,
            $nama,
            $origin,
            $no_hp ?: null
        ]);

        if (!$insertDosenResult) {
            $_SESSION['error'] = 'Gagal menyimpan data dosen: ' . pg_last_error($this->db);
            // Hapus user yang baru dibuat karena dosen gagal disimpan
            @pg_query_params($this->db, "DELETE FROM users WHERE id = $1", [$userId]);
            header('Location: index.php?page=admin-dosen-create');
            exit;
        }

        $_SESSION['success'] = 'Dosen baru berhasil ditambahkan! Username: ' . htmlspecialchars($username);
        header('Location: index.php?page=admin-dosen');
        exit;
    }

    /**
     * Tampilkan detail dosen
     */
    public function show()
    {
        $dosenId = intval($_GET['id'] ?? 0);

        if ($dosenId <= 0) {
            $_SESSION['error'] = 'ID dosen tidak valid!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        $dosen = $this->dosenModel->getDosenById($dosenId);

        if (!$dosen) {
            $_SESSION['error'] = 'Dosen tidak ditemukan!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        // Ambil performance dosen
        $performance = $this->dosenModel->getDosenPerformance();
        $dosenPerformance = null;
        foreach ($performance as $perf) {
            if ($perf['dosen_id'] == $dosenId) {
                $dosenPerformance = $perf;
                break;
            }
        }

        // Render dengan layout
        $title = 'Detail Dosen: ' . htmlspecialchars($dosen['nama']);
        ob_start();
        include __DIR__ . '/../../view/admin/dosen/show.php';
        $content = ob_get_clean();

        include __DIR__ . '/../../view/layouts/admin.php';
    }

    /**
     * AJAX: Dapatkan daftar dosen dalam format JSON
     * Digunakan untuk dropdown atau autocomplete
     */
    public function getJson()
    {
        header('Content-Type: application/json');

        $search = trim($_GET['q'] ?? '');
        $dosen = [];

        if (!empty($search)) {
            $dosen = $this->dosenModel->searchDosen($search);
        } else {
            $dosen = $this->dosenModel->getDaftarDosenFromView();
        }

        // Format untuk dropdown/autocomplete
        $result = array_map(function ($item) {
            return [
                'id' => $item['user_id'],
                'text' => $item['nama'] . ' (' . $item['nip'] . ')'
            ];
        }, $dosen);

        echo json_encode($result);
        exit;
    }

    /**
     * AJAX: Dapatkan detail dosen
     */
    public function getDetail()
    {
        header('Content-Type: application/json');

        $dosenId = intval($_GET['id'] ?? 0);

        if ($dosenId <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'ID tidak valid']);
            exit;
        }

        $dosen = $this->dosenModel->getDosenById($dosenId);

        if (!$dosen) {
            http_response_code(404);
            echo json_encode(['error' => 'Dosen tidak ditemukan']);
            exit;
        }

        echo json_encode($dosen);
        exit;
    }

    /**
     * AJAX: Dapatkan jumlah mahasiswa
     */
    public function getMahasiswaCount()
    {
        header('Content-Type: application/json');

        $dosenId = intval($_GET['id'] ?? 0);

        if ($dosenId <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'ID tidak valid']);
            exit;
        }

        $count = $this->dosenModel->getJumlahMahasiswa($dosenId);

        echo json_encode(['count' => $count]);
        exit;
    }

    /**
     * Tampilkan form edit dosen
     */
    public function edit()
    {
        $dosenId = intval($_GET['id'] ?? 0);

        if ($dosenId <= 0) {
            $_SESSION['error'] = 'ID dosen tidak valid!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        // Ambil data dosen
        $dosen = $this->dosenModel->getDosenById($dosenId);

        if (!$dosen) {
            $_SESSION['error'] = 'Data dosen tidak ditemukan!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        // Render view with layout
        $title = 'Edit Dosen';
        ob_start();
        include __DIR__ . '/../../view/admin/dosen/edit.php';
        $content = ob_get_clean();
        include __DIR__ . '/../../view/layouts/admin.php';
    }

    /**
     * Update data dosen
     * POST handler untuk form edit
     */
    public function update()
    {
        // Pastikan method POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        $dosenId = intval($_GET['id'] ?? 0);

        if ($dosenId <= 0) {
            $_SESSION['error'] = 'ID dosen tidak valid!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        // Validasi input
        $nama = trim($_POST['nama'] ?? '');
        $origin = trim($_POST['origin'] ?? '');
        $no_hp = trim($_POST['no_hp'] ?? '');
        $status = trim($_POST['status'] ?? 'active');
        $password = trim($_POST['password'] ?? '');
        $password_confirm = trim($_POST['password_confirm'] ?? '');

        $errors = [];

        // Validasi field required
        if (empty($nama)) {
            $errors[] = 'Nama harus diisi!';
        }

        if (empty($origin)) {
            $errors[] = 'Asal institusi harus diisi!';
        }

        // Validasi status
        if (!in_array($status, ['active', 'inactive', 'cuti'])) {
            $errors[] = 'Status tidak valid!';
        }

        // Validasi password jika diisi
        if (!empty($password)) {
            if (strlen($password) < 8) {
                $errors[] = 'Password minimal 8 karakter!';
            }

            if ($password !== $password_confirm) {
                $errors[] = 'Password dan konfirmasi password tidak cocok!';
            }
        }

        // Jika ada error
        if (!empty($errors)) {
            $_SESSION['error'] = implode(' | ', $errors);
            header('Location: index.php?page=admin-dosen-edit&id=' . $dosenId);
            exit;
        }

        // Ambil data dosen saat ini
        $dosenLama = $this->dosenModel->getDosenById($dosenId);

        if (!$dosenLama) {
            $_SESSION['error'] = 'Data dosen tidak ditemukan!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        $userId = $dosenLama['user_id'] ?? null;

        if (!$userId) {
            $_SESSION['error'] = 'User ID tidak ditemukan!';
            header('Location: index.php?page=admin-dosen-edit&id=' . $dosenId);
            exit;
        }

        // Start transaction (simulasi dengan error handling)
        try {
            // Update data dosen
            $updateDosenQuery = "
                UPDATE dosen
                SET 
                    nama = $1,
                    origin = $2,
                    no_hp = $3,
                    status = $4,
                    updated_at = NOW()
                WHERE dosen_id = $5
                RETURNING dosen_id
            ";

            $updateDosenResult = pg_query_params(
                $this->db,
                $updateDosenQuery,
                [
                    $nama,
                    $origin,
                    $no_hp,
                    $status,
                    $dosenId
                ]
            );

            if (!$updateDosenResult) {
                throw new Exception('Gagal update dosen: ' . pg_last_error($this->db));
            }

            // Update password jika diisi
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $updateUserQuery = "
                    UPDATE users
                    SET 
                        password = $1,
                        updated_at = NOW()
                    WHERE user_id = $2
                ";

                $updateUserResult = pg_query_params(
                    $this->db,
                    $updateUserQuery,
                    [
                        $hashedPassword,
                        $userId
                    ]
                );

                if (!$updateUserResult) {
                    throw new Exception('Gagal update password: ' . pg_last_error($this->db));
                }
            }

            $_SESSION['success'] = 'Data dosen berhasil diperbarui!';
            header('Location: index.php?page=admin-dosen-detail&id=' . $dosenId);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?page=admin-dosen-edit&id=' . $dosenId);
            exit;
        }
    }

    /**
     * Hapus dosen (DELETE)
     * Menggunakan POST method dengan confirmation
     */
    public function destroy()
    {
        // Pastikan method POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        $dosenId = intval($_POST['dosen_id'] ?? 0);

        if ($dosenId <= 0) {
            $_SESSION['error'] = 'ID dosen tidak valid!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        // Ambil data dosen
        $dosen = $this->dosenModel->getDosenById($dosenId);

        if (!$dosen) {
            $_SESSION['error'] = 'Data dosen tidak ditemukan!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        $userId = $dosen['user_id'] ?? null;

        if (!$userId) {
            $_SESSION['error'] = 'User ID tidak ditemukan!';
            header('Location: index.php?page=admin-dosen');
            exit;
        }

        try {
            // Check if dosen has mahasiswa bimbingan
            $checkMahasiswaQuery = "
                SELECT COUNT(*) AS count
                FROM mahasiswa
                WHERE dosen_pembimbing = $1 OR lab_head = $1
            ";

            $checkMahasiswaResult = pg_query_params(
                $this->db,
                $checkMahasiswaQuery,
                [$dosenId]
            );

            if (!$checkMahasiswaResult) {
                throw new Exception('Gagal check mahasiswa: ' . pg_last_error($this->db));
            }

            $mahasiswaCount = pg_fetch_assoc($checkMahasiswaResult)['count'] ?? 0;

            if ($mahasiswaCount > 0) {
                $_SESSION['error'] = 'Tidak bisa menghapus dosen karena masih memiliki ' . $mahasiswaCount . ' mahasiswa bimbingan!';
                header('Location: index.php?page=admin-dosen-detail&id=' . $dosenId);
                exit;
            }

            // Delete dosen record
            $deleteDosenQuery = "DELETE FROM dosen WHERE dosen_id = $1";

            $deleteDosenResult = pg_query_params(
                $this->db,
                $deleteDosenQuery,
                [$dosenId]
            );

            if (!$deleteDosenResult) {
                throw new Exception('Gagal menghapus dosen: ' . pg_last_error($this->db));
            }

            // Delete user record
            $deleteUserQuery = "DELETE FROM users WHERE user_id = $1";

            $deleteUserResult = pg_query_params(
                $this->db,
                $deleteUserQuery,
                [$userId]
            );

            if (!$deleteUserResult) {
                throw new Exception('Gagal menghapus akun user: ' . pg_last_error($this->db));
            }

            $_SESSION['success'] = 'Dosen berhasil dihapus!';
            header('Location: index.php?page=admin-dosen');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?page=admin-dosen-detail&id=' . $dosenId);
            exit;
        }
    }
}

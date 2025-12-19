<?php

/**
 * DosenModel - Model untuk mengelola data dosen
 * Menggunakan VIEW dan FUNCTION dari database untuk pengambilan data
 */

class DosenModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Dapatkan daftar semua dosen menggunakan VIEW view_dosen
     * Lebih simple dan efisien menggunakan view
     * 
     * @return array Daftar dosen
     */
    public function getDaftarDosenFromView()
    {
        $query = "SELECT * FROM view_dosen WHERE status = 'active' ORDER BY nama ASC";
        $result = @pg_query($this->db, $query);

        $dosen = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $dosen[] = $row;
            }
        }

        return $dosen;
    }

    /**
     * Dapatkan daftar dosen dengan informasi jumlah mahasiswa
     * Menggunakan FUNCTION get_daftar_dosen() dari database
     * 
     * @return array Daftar dosen dengan jumlah mahasiswa
     */
    public function getDaftarDosenLengkap()
    {
        $query = "SELECT * FROM get_daftar_dosen()";
        $result = @pg_query($this->db, $query);

        $dosen = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $dosen[] = $row;
            }
        }

        return $dosen;
    }

    /**
     * Dapatkan dosen berdasarkan status (active/inactive)
     * Menggunakan FUNCTION get_dosen_by_status() dari database
     * 
     * @param string $status Status dosen (active/inactive)
     * @return array Daftar dosen sesuai status
     */
    public function getDosenByStatus($status = 'active')
    {
        $query = "SELECT * FROM get_dosen_by_status($1)";
        $result = @pg_query_params($this->db, $query, [$status]);

        $dosen = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $dosen[] = $row;
            }
        }

        return $dosen;
    }

    /**
     * Cari dosen berdasarkan nama atau NIP
     * Menggunakan FUNCTION search_dosen() dari database
     * 
     * @param string $searchTerm Kata kunci pencarian (nama atau NIP)
     * @return array Hasil pencarian dosen
     */
    public function searchDosen($searchTerm)
    {
        if (empty(trim($searchTerm))) {
            return [];
        }

        $query = "SELECT * FROM search_dosen($1)";
        $result = @pg_query_params($this->db, $query, [$searchTerm]);

        $dosen = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $dosen[] = $row;
            }
        }

        return $dosen;
    }

    /**
     * Dapatkan detail dosen dengan informasi lengkap
     * Menggunakan FUNCTION get_dosen_details() dari database
     * 
     * @param int $userId ID user dosen
     * @return array|null Detail dosen atau null jika tidak ditemukan
     */
    public function getDosenDetail($userId)
    {
        $query = "SELECT * FROM get_dosen_details($1)";
        $result = @pg_query_params($this->db, $query, [$userId]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }

        return null;
    }

    /**
     * Dapatkan jumlah mahasiswa bimbingan dosen
     * 
     * @param int $dosenId ID dosen
     * @return int Jumlah mahasiswa
     */
    public function getJumlahMahasiswa($dosenId)
    {
        $query = "SELECT count_mahasiswa_by_dosen($1) as total";
        $result = @pg_query_params($this->db, $query, [$dosenId]);

        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            return (int)$row['total'];
        }

        return 0;
    }

    /**
     * Dapatkan dosen berdasarkan ID
     * 
     * @param int $dosenId ID dosen
     * @return array|null Data dosen atau null jika tidak ditemukan
     */
    public function getDosenById($dosenId)
    {
        $query = "SELECT d.*, u.email, u.status 
                  FROM dosen d
                  LEFT JOIN users u ON u.id = d.user_id
                  WHERE d.id = $1";

        $result = @pg_query_params($this->db, $query, [$dosenId]);

        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }

        return null;
    }

    /**
     * Dapatkan performance dosen (menggunakan function dari DB)
     * 
     * @return array Performa semua dosen
     */
    public function getDosenPerformance()
    {
        $query = "SELECT * FROM get_dosen_performance()";
        $result = @pg_query($this->db, $query);

        $performance = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $performance[] = $row;
            }
        }

        return $performance;
    }
    /**
     * Tambah data dosen baru (Insert ke users dan dosen)
     * 
     * @param array $data Data dosen (username, email, password, nip, nama, origin, no_hp)
     * @return bool|int False jika gagal, ID dosen jika berhasil
     */
    public function create($data)
    {
        pg_query($this->db, "BEGIN");

        try {
            // 1. Insert ke tabel users
            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
            $queryUser = "INSERT INTO users (username, email, password, role_id, status) 
                          VALUES ($1, $2, $3, $4, 'active') RETURNING id";
            
            // Cari role_id untuk 'dosen' (asumsi ID 3, tapi sebaiknya query)
            // Hardcode 3 untuk dosen sesuai sql setup
            $roleId = 3; 

            $paramsUser = [
                $data['username'],
                $data['email'],
                $passwordHash,
                $roleId
            ];

            $resUser = pg_query_params($this->db, $queryUser, $paramsUser);
            
            if (!$resUser) {
                throw new Exception("Gagal insert user: " . pg_last_error($this->db));
            }

            $userRow = pg_fetch_assoc($resUser);
            $userId = $userRow['id'];

            // 2. Insert ke tabel dosen
            $queryDosen = "INSERT INTO dosen (user_id, nip, nama, origin, no_hp) 
                           VALUES ($1, $2, $3, $4, $5) RETURNING id";
            
            $paramsDosen = [
                $userId,
                $data['nip'],
                $data['nama'],
                $data['origin'] ?? '',
                $data['no_hp'] ?? ''
            ];

            $resDosen = pg_query_params($this->db, $queryDosen, $paramsDosen);

            if (!$resDosen) {
                throw new Exception("Gagal insert dosen: " . pg_last_error($this->db));
            }

            $dosenRow = pg_fetch_assoc($resDosen);
            $dosenId = $dosenRow['id'];

            pg_query($this->db, "COMMIT");
            return $dosenId;

        } catch (Exception $e) {
            pg_query($this->db, "ROLLBACK");
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Update data dosen
     * 
     * @param int $dosenId ID dosen
     * @param array $data Data dosen yang akan diupdate
     * @return bool True jika berhasil
     */
    public function update($dosenId, $data)
    {
        pg_query($this->db, "BEGIN");

        try {
            // Get user_id first
            $dosen = $this->getDosenById($dosenId);
            if (!$dosen) {
                throw new Exception("Dosen tidak ditemukan");
            }
            $userId = $dosen['user_id'];

            // 1. Update tabel dosen
            $queryDosen = "UPDATE dosen SET nip = $1, nama = $2, origin = $3, no_hp = $4, updated_at = NOW() 
                           WHERE id = $5";
            
            $paramsDosen = [
                $data['nip'],
                $data['nama'],
                $data['origin'] ?? $dosen['origin'],
                $data['no_hp'] ?? $dosen['no_hp'],
                $dosenId
            ];

            $resDosen = pg_query_params($this->db, $queryDosen, $paramsDosen);
            if (!$resDosen) {
                throw new Exception("Gagal update data dosen: " . pg_last_error($this->db));
            }

            // 2. Update tabel users (email dan status)
            $queryUser = "UPDATE users SET email = $1, status = $2, updated_at = NOW() WHERE id = $3";
            $paramsUser = [
                $data['email'],
                $data['status'],
                $userId
            ];

            // Jika password diisi, update password juga
            if (!empty($data['password'])) {
                $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
                $queryUser = "UPDATE users SET email = $1, status = $2, password = $3, updated_at = NOW() WHERE id = $4";
                $paramsUser = [
                    $data['email'],
                    $data['status'],
                    $passwordHash,
                    $userId
                ];
            }

            $resUser = pg_query_params($this->db, $queryUser, $paramsUser);
            if (!$resUser) {
                throw new Exception("Gagal update data user: " . pg_last_error($this->db));
            }

            pg_query($this->db, "COMMIT");
            return true;

        } catch (Exception $e) {
            pg_query($this->db, "ROLLBACK");
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Delete dosen (Insert ke users akan terhapus via CASCADE)
     * 
     * @param int $dosenId ID dosen
     * @return bool True jika berhasil
     */
    public function delete($dosenId)
    {
        // Karena ada constraint ON DELETE CASCADE pada tabel dosen refer ke users,
        // sebenarnya kita bisa langsung delete user-nya.
        // Tapi kita dapet ID dosen. Jadi ambil user_id dulu.
        
        $dosen = $this->getDosenById($dosenId);
        if (!$dosen) return false;

        $userId = $dosen['user_id'];

        // Hapus dari tabel users, otomatis hapus di tabel dosen karena CASCADE (biasanya)
        // Cek definisi tabel, user_id di dosen REFERENCES users(id) ON DELETE CASCADE
        // Jadi kita hapus usernya.
        
        $query = "DELETE FROM users WHERE id = $1";
        $result = pg_query_params($this->db, $query, [$userId]);

        return $result ? true : false;
    }
}

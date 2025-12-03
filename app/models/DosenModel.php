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
}

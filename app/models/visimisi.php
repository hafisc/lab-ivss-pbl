<?php

class VisiMisi {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Mengambil data Visi & Misi (hanya 1 baris)
     */
    public function get() {
        $result = pg_query($this->db, "SELECT * FROM visimisi LIMIT 1");
        // Gunakan LIMIT 1 (sudah benar)
        return pg_fetch_assoc($result) ?: null;
    }
    
    /**
     * Memastikan setidaknya satu baris data VisiMisi ada. 
     * Jika tidak ada, data awal akan di-INSERT dan dikembalikan.
     * @return array|null Data VisiMisi yang ada atau yang baru dibuat.
     */
    public function ensureRecordExists() {
        $data = $this->get();

        if (!$data) {
            // Data awal jika tabel kosong
            $initialVisi = 'Silakan masukkan Visi Anda di sini.';
            $initialMisi = 'Silakan masukkan Misi Anda di sini.';
            
            // Lakukan INSERT data awal dan kembalikan datanya
            $result = pg_query_params(
                $this->db,
                // Pastikan mengembalikan semua kolom yang dibutuhkan
                "INSERT INTO visimisi (visi, misi) VALUES ($1, $2) RETURNING id, visi, misi",
                [
                    $initialVisi,
                    $initialMisi
                ]
            );
            
            // Kembalikan data yang baru di-insert
            return pg_fetch_assoc($result) ?: null;
        }
        
        // Kembalikan data yang sudah ada
        return $data; 
    }

    /**
     * Mengupdate data Visi & Misi berdasarkan ID (ID ini harusnya selalu 1)
     */
    public function update($id, $data) {
        return pg_query_params(
            $this->db,
            "UPDATE visimisi SET visi=$1, misi=$2 WHERE id=$3",
            [
                $data['visi'],
                $data['misi'],
                $id
            ]
        );
        
    }
}
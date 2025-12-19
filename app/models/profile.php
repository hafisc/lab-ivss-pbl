<?php
// File: app/Models/Profile.php

class profile {
    private $db;
    private $tableName = 'profile_lab'; // Samakan dengan Controller

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Mengambil data Profil (Baris Pertama)
     */
    public function get() {
        // Menggunakan double quotes agar aman di PostgreSQL
        $result = pg_query($this->db, "SELECT * FROM \"{$this->tableName}\" LIMIT 1");
        return pg_fetch_assoc($result) ?: null;
    }
    
    /**
     * Memastikan data default ada jika tabel kosong
     */
    public function ensureRecordExists() {
    $data = $this->get();

    if (!$data) {
        // Variabel $initialImage ini tidak terpakai karena Anda langsung 
        // memasukkan string 'default.png' di bawah. Bisa dihapus agar bersih.
        // $initialImage = '/public/uploads/default_profile.png'; 
        
        $sql = "INSERT INTO \"{$this->tableName}\" 
                (id, nama_lab, singkatan, deskripsi_singkat, image) 
                VALUES ($1, $2, $3, $4, $5) 
                RETURNING *";
        
        $result = pg_query_params($this->db, $sql, [
            1, 
            'Laboratorium IVSS', 
            'IVSS', 
            'Deskripsi default laboratorium.', 
            'default.png' // Pastikan file ini ada di folder public/uploads/profiles/
        ]);
        
        return pg_fetch_assoc($result);
    }
    
    return $data; 
}

    /**
     * Mengupdate data Profil secara lengkap
     */
    public function update($id, $data) {
    $query = "UPDATE \"{$this->tableName}\" SET 
                nama_lab = $1, 
                singkatan = $2, 
                deskripsi_singkat = $3, 
                lokasi_ruangan = $4,
                riset_fitur_judul = $5, 
                riset_fitur_desk = $6,
                fasilitas_fitur_judul = $7, 
                fasilitas_fitur_desk = $8,
                image = $9,
                updated_at = CURRENT_TIMESTAMP
              WHERE id = $10";
    
    return pg_query_params($this->db, $query, [
        $data['nama_lab'],
        $data['singkatan'],
        $data['deskripsi_singkat'],
        $data['lokasi_ruangan'],
        $data['riset_fitur_judul'],
        $data['riset_fitur_desk'],
        $data['fasilitas_fitur_judul'],
        $data['fasilitas_fitur_desk'],
        $data['image'], // Nama file gambar
        $id
    ]);
}
}
<?php

class Visimisi {
    private $conn;
    private $table = 'visimisi';

    public $id;
    public $misi;
    public $visi;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }
    // Get news by ID
    public function getById($id) {
        $query = "SELECT n.*, 
                         COALESCE(d.nama, m.nama, u.username) as author_name 
                  FROM " . $this->table . " n 
                  LEFT JOIN users u ON n.author_id = u.id 
                  LEFT JOIN dosen d ON u.id = d.user_id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id
                  WHERE n.id = $1 
                  LIMIT 1";
    }
    // Update news
    public function update() {
    $query = "UPDATE " . $this->table . " 
              SET visi = $1, misi = $2, updated_at = CURRENT_TIMESTAMP 
              WHERE id = $3";

    $result = pg_query_params($this->conn, $query, array(
        $this->visi,
        $this->misi,
        // Hapus $this->updated_at, karena sudah CURRENT_TIMESTAMP di SQL
        $this->id // Ini akan menjadi $3
    ));

    return $result !== false;
}

}

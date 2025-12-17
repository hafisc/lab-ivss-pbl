<?php
/**
 * Title: Course Model
 * Description: Model untuk mengelola data mata kuliah (perkuliahan terkait).
 */

class Course
{
    private $conn;
    private $table = 'courses';

    public function __construct($db)
    {
        // Mendukung both PDO dan Legacy resource
        $this->conn = $db;
    }

    /**
     * Mengambil semua data mata kuliah
     */
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id ASC";
        
        // Cek tipe koneksi (PDO vs Resource)
        if ($this->conn instanceof PDO) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = pg_query($this->conn, $query);
            $courses = [];
            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    $courses[] = $row;
                }
            }
            return $courses;
        }
    }

    /**
     * Mengambil data mata kuliah berdasarkan ID
     */
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = $1";
        
        if ($this->conn instanceof PDO) {
            $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = pg_query_params($this->conn, $query, [$id]);
            return ($result && pg_num_rows($result) > 0) ? pg_fetch_assoc($result) : null;
        }
    }

    /**
     * Menambahkan mata kuliah baru
     */
    public function create($data)
    {
        $query = "INSERT INTO " . $this->table . " (name, code, sks, semester, description, created_at) VALUES ($1, $2, $3, $4, $5, NOW()) RETURNING id";
        $params = [
            $data['name'], 
            $data['code'] ?? null, 
            $data['sks'] ?? 0, 
            $data['semester'] ?? null, 
            $data['description']
        ];
        
        if ($this->conn instanceof PDO) {
            $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (name, code, sks, semester, description, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            if ($stmt->execute($params)) {
                 // PDO returning ID is tricky with pgsql sometimes, but lastInsertId usually works well if sequence usage is standard
                 return $this->conn->lastInsertId();
            }
            return false;
        } else {
            $result = pg_query_params($this->conn, $query, $params);
            if ($result) {
                $row = pg_fetch_assoc($result);
                return $row['id'];
            }
            return false;
        }
    }

    /**
     * Mengupdate data mata kuliah
     */
    public function update($id, $data)
    {
        $query = "UPDATE " . $this->table . " SET name = $1, code = $2, sks = $3, semester = $4, description = $5, updated_at = NOW() WHERE id = $6";
        $params = [
            $data['name'], 
            $data['code'] ?? null, 
            $data['sks'] ?? 0, 
            $data['semester'] ?? null, 
            $data['description'], 
            $id
        ];

        if ($this->conn instanceof PDO) {
            $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET name = ?, code = ?, sks = ?, semester = ?, description = ?, updated_at = NOW() WHERE id = ?");
            return $stmt->execute($params);
        } else {
            return pg_query_params($this->conn, $query, $params);
        }
    }

    /**
     * Menghapus mata kuliah
     */
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = $1";
        
        if ($this->conn instanceof PDO) {
            $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id = ?");
            return $stmt->execute([$id]);
        } else {
            return pg_query_params($this->conn, $query, [$id]);
        }
    }
}

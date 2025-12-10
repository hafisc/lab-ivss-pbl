<?php

class Gallery {
    private $db;
    private $table = 'gallery';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $result = pg_query($this->db, $query);
        
        $items = [];
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $items[] = $row;
            }
        }
        return $items;
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = $1";
        $result = pg_query_params($this->db, $query, [$id]);
        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }
        return false;
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (title, description, image_path, created_at, updated_at) VALUES ($1, $2, $3, NOW(), NOW())";
        return pg_query_params($this->db, $query, [
            $data['title'] ?? null, 
            $data['description'] ?? null, 
            $data['image_path']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET title = $1, description = $2, updated_at = NOW()";
        $params = [$data['title'] ?? null, $data['description'] ?? null];
        
        if (isset($data['image_path'])) {
            $query .= ", image_path = $3";
            $params[] = $data['image_path'];
            $query .= " WHERE id = $4";
            $params[] = $id;
        } else {
            $query .= " WHERE id = $3";
            $params[] = $id;
        }
        
        return pg_query_params($this->db, $query, $params);
    }
    
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = $1";
        return pg_query_params($this->db, $query, [$id]);
    }
}

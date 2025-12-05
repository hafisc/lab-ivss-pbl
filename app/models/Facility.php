<?php

class Facility {
    private $db;
    private $table = 'facilities';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id ASC";
        $result = pg_query($this->db, $query);
        
        $facilities = [];
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $facilities[] = $row;
            }
        }
        return $facilities;
    }

    public function create($name, $description = null, $image = null) {
        $query = "INSERT INTO {$this->table} (name, description, image) VALUES ($1, $2, $3)";
        return pg_query_params($this->db, $query, [$name, $description, $image]);
    }
    
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = $1";
        return pg_query_params($this->db, $query, [$id]);
    }
}

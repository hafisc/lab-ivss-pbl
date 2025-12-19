<?php
class MemberPublication {
    private $db;
    private $table = 'member_publications';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getByUserId($userId) {
        $query = "SELECT * FROM {$this->table} WHERE user_id = $1 ORDER BY year DESC, created_at DESC";
        $result = pg_query_params($this->db, $query, [$userId]);
        
        $data = [];
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function create($data) {
        $fields = ['user_id', 'title', 'authors', 'journal', 'year', 'doi', 'status', 'file_path', 'volume', 'issue', 'pages', 'url'];
        $placeholders = [];
        $values = [];
        
        $counter = 1;
        $activeFields = [];
        
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                 $activeFields[] = $field;
                 $placeholders[] = '$' . $counter;
                 $values[] = $data[$field];
                 $counter++;
            }
        }

        $query = "INSERT INTO {$this->table} (" . implode(', ', $activeFields) . ", created_at) 
                  VALUES (" . implode(', ', $placeholders) . ", NOW()) RETURNING id";
        
        $result = pg_query_params($this->db, $query, $values);
        return $result ? pg_fetch_result($result, 0, 0) : false;
    }
    
    public function update($id, $data) {
        $fields = ['title', 'authors', 'journal', 'year', 'doi', 'status', 'file_path', 'volume', 'issue', 'pages', 'url'];
        $setClauses = [];
        $values = [];
        $counter = 1;
        
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $setClauses[] = "$field = $$counter";
                $values[] = $data[$field];
                $counter++;
            }
        }
        
        $values[] = $id;
        $query = "UPDATE {$this->table} SET " . implode(', ', $setClauses) . ", updated_at = NOW() WHERE id = $$counter";
        
        return pg_query_params($this->db, $query, $values);
    }
    
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = $1";
        return pg_query_params($this->db, $query, [$id]);
    }
    
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = $1";
        $result = pg_query_params($this->db, $query, [$id]);
        return $result ? pg_fetch_assoc($result) : null;
    }
}

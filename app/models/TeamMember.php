<?php

class TeamMember {
    private $conn;
    private $table = 'team_members';

    public function __construct($db) {
        $this->conn = $db; // PostgreSQL native connection
    }

    /**
     * Get all team members (for admin)
     */
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY order_position ASC, id ASC";
        $result = pg_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        $members = array();
        while ($row = pg_fetch_assoc($result)) {
            $members[] = $row;
        }
        
        return $members;
    }

    /**
     * Get active team members only (for home page)
     */
    public function getActive() {
        $query = "SELECT * FROM {$this->table} 
                  WHERE is_active = TRUE 
                  ORDER BY order_position ASC, id ASC";
        $result = pg_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        $members = array();
        while ($row = pg_fetch_assoc($result)) {
            $members[] = $row;
        }
        
        return $members;
    }

    /**
     * Get team member by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = $1 LIMIT 1";
        $result = pg_query_params($this->conn, $query, array($id));
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }

    /**
     * Create new team member
     */
    public function create($data) {
        $query = "INSERT INTO {$this->table} (name, position, photo, email, bio, order_position, is_active) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7) RETURNING id";
        
        $result = pg_query_params($this->conn, $query, array(
            $data['name'],
            $data['position'],
            $data['photo'] ?? null,
            $data['email'] ?? null,
            $data['bio'] ?? null,
            $data['order_position'] ?? 0,
            $data['is_active'] ?? true
        ));
        
        if (!$result) {
            return false;
        }
        
        $row = pg_fetch_assoc($result);
        return $row['id'];
    }

    /**
     * Update team member
     */
    public function update($id, $data) {
        $query = "UPDATE {$this->table} 
                  SET name = $1, position = $2, photo = $3, email = $4, bio = $5, 
                      order_position = $6, is_active = $7, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = $8";
        
        $result = pg_query_params($this->conn, $query, array(
            $data['name'],
            $data['position'],
            $data['photo'],
            $data['email'] ?? null,
            $data['bio'] ?? null,
            $data['order_position'] ?? 0,
            $data['is_active'] ?? true,
            $id
        ));
        
        return $result !== false;
    }

    /**
     * Delete team member
     */
    public function delete($id) {
        // Get photo path untuk delete file
        $member = $this->getById($id);
        
        $query = "DELETE FROM {$this->table} WHERE id = $1";
        $result = pg_query_params($this->conn, $query, array($id));
        
        // Delete photo file if exists
        if ($result && $member && !empty($member['photo'])) {
            $photoPath = __DIR__ . '/../../public/' . $member['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }
        
        return $result !== false;
    }

    /**
     * Update order position
     */
    public function updateOrder($id, $order) {
        $query = "UPDATE {$this->table} SET order_position = $1 WHERE id = $2";
        $result = pg_query_params($this->conn, $query, array($order, $id));
        
        return $result !== false;
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id) {
        $query = "UPDATE {$this->table} SET is_active = NOT is_active WHERE id = $1";
        $result = pg_query_params($this->conn, $query, array($id));
        
        return $result !== false;
    }
}

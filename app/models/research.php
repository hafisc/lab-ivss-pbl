<?php

class Research {
    private $conn;
    private $table = 'research';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $result = pg_query($this->conn, $query);
        
        $researches = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                // Format image URL if needed
                if (!empty($row['image'])) {
                    $row['image_url'] = $row['image'];
                } else {
                    $row['image_url'] = null;
                }
                $researches[] = $row;
            }
        }
        return $researches;
    }

    public function getActive($limit = 4) {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY created_at DESC LIMIT $1";
        $result = pg_query_params($this->conn, $query, array($limit));
        
        $researches = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                if (!empty($row['image'])) {
                    $row['image_url'] = $row['image'];
                } else {
                    $row['image_url'] = null;
                }
                $researches[] = $row;
            }
        }
        return $researches;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = $1";
        $result = pg_query_params($this->conn, $query, array($id));
        
        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            if (!empty($row['image'])) {
                $row['image_url'] = $row['image'];
            } else {
                $row['image_url'] = null;
            }
            return $row;
        }
        return null;
    }

    public function getMembers($research_id) {
        $query = "SELECT * FROM get_research_members($1)";
        $result = pg_query_params($this->conn, $query, array($research_id));
        
        $members = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $members[] = $row;
            }
        }
        return $members;
    }

    public function addMember($research_id, $user_id, $role) {
        $query = "CALL add_member_to_research($1, $2, $3)";
        return pg_query_params($this->conn, $query, array($research_id, $user_id, $role));
    }

    public function removeMember($research_id, $user_id) {
        $query = "CALL remove_member_from_research($1, $2)";
        return pg_query_params($this->conn, $query, array($research_id, $user_id));
    }

    public function getStats() {
        $query = "SELECT * FROM get_research_statistics()";
        $result = pg_query($this->conn, $query);
        
        if ($result) {
            return pg_fetch_assoc($result);
        }
        return [
            'total_research' => 0,
            'active_research' => 0,
            'completed_research' => 0,
            'total_members' => 0
        ];
    }

    // CRUD Methods
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (title, description, category, image, leader_id, status, start_date, end_date, funding, team_members, publications, url, created_at) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, NOW()) RETURNING id";
        
        $params = [
            $data['title'],
            $data['description'],
            $data['category'],
            $data['image'] ?? null,
            $data['leader_id'] ?? null,
            $data['status'] ?? 'active',
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['funding'] ?? null,
            $data['team_members'] ?? null,
            $data['publications'] ?? null,
            $data['url'] ?? null
        ];

        $result = pg_query_params($this->conn, $query, $params);
        
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['id'];
        }
        return false;
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET title = $1, description = $2, category = $3, image = $4, status = $5, 
                      start_date = $6, end_date = $7, funding = $8, team_members = $9, 
                      publications = $10, url = $11, updated_at = NOW() 
                  WHERE id = $12";
        
        $params = [
            $data['title'],
            $data['description'],
            $data['category'],
            $data['image'], // Can be null or existing image
            $data['status'],
            $data['start_date'] ?? null,
            $data['end_date'] ?? null,
            $data['funding'] ?? null,
            $data['team_members'] ?? null,
            $data['publications'] ?? null,
            $data['url'] ?? null,
            $id
        ];

        return pg_query_params($this->conn, $query, $params);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = $1";
        return pg_query_params($this->conn, $query, array($id));
    }
}

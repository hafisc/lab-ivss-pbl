<?php

class Member {
    private $conn;
    private $table = 'member_registrations';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register new member
    public function register($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (name, email, nim, phone, angkatan, origin, password, research_title, supervisor_id, motivation, status) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, 'pending_supervisor') 
                  RETURNING id";

        $params = array(
            $data['name'],
            $data['email'],
            $data['nim'],
            $data['phone'],
            $data['angkatan'],
            $data['origin'],
            password_hash($data['password'], PASSWORD_DEFAULT), // Hash password here
            $data['research_title'],
            $data['supervisor_id'],
            $data['motivation']
        );

        $result = pg_query_params($this->conn, $query, $params);

        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['id'];
        }
        
        return false;
    }

    // Get pending registrations by supervisor using function
    public function getPendingBySupervisor($supervisor_id) {
        $query = "SELECT * FROM get_pending_registrations_by_supervisor($1)";
        
        $result = pg_query_params($this->conn, $query, array($supervisor_id));
        
        if (!$result) {
            return [];
        }

        $registrations = array();
        while ($row = pg_fetch_assoc($result)) {
            $registrations[] = $row;
        }
        return $registrations;
    }

    // Approve by supervisor using procedure
    public function approveBySupervisor($id, $notes = null) {
        $query = "CALL approve_registration_supervisor($1, $2)";
        
        $result = pg_query_params($this->conn, $query, array($id, $notes));
        
        return $result !== false;
    }

    // Reject by supervisor using procedure
    public function rejectBySupervisor($id, $notes) {
        $query = "CALL reject_registration_supervisor($1, $2)";
        
        $result = pg_query_params($this->conn, $query, array($id, $notes));
        
        return $result !== false;
    }

    // Approve by lab head using procedure
    public function approveByLabHead($id, $notes = null) {
        $query = "CALL approve_registration_lab_head($1, $2)";
        
        $result = pg_query_params($this->conn, $query, array($id, $notes));
        
        return $result !== false;
    }

    // Reject by lab head using procedure
    public function rejectByLabHead($id, $notes) {
        $query = "CALL reject_registration_lab_head($1, $2)";
        
        $result = pg_query_params($this->conn, $query, array($id, $notes));
        
        return $result !== false;
    }
    
    // Get pending count using function
    public function getPendingCount() {
        $query = "SELECT * FROM get_pending_registrations_count()";
        $result = pg_query($this->conn, $query);
        if ($result) {
            return pg_fetch_assoc($result);
        }
        return false;
    }
}

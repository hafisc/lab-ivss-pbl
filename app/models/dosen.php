<?php

class Dosen {
    private $conn;
    private $table = 'dosen';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get dosen details using function get_dosen_details()
    public function getDetails($user_id) {
        $query = "SELECT * FROM get_dosen_details($1)";
        
        $result = pg_query_params($this->conn, $query, array($user_id));
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }

    // Count mahasiswa by dosen using function
    public function countMahasiswa($dosen_id) {
        $query = "SELECT count_mahasiswa_by_dosen($1)";
        
        $result = pg_query_params($this->conn, $query, array($dosen_id));
        
        if (!$result) {
            return 0;
        }
        
        $row = pg_fetch_row($result);
        return $row[0];
    }

    // Get performance statistics using function get_dosen_performance()
    public function getPerformance() {
        $query = "SELECT * FROM get_dosen_performance()";
        
        $result = pg_query($this->conn, $query);
        
        if (!$result) {
            return [];
        }

        $performance = array();
        while ($row = pg_fetch_assoc($result)) {
            $performance[] = $row;
        }
        return $performance;
    }
}

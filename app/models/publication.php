<?php

class Publication {
    private $conn;
    private $table = 'publications';

    public $id;
    public $title;
    public $authors;
    public $year;
    public $journal;
    public $conference;
    public $doi;
    public $url;
    public $abstract;
    public $citations;
    public $keywords;
    public $type;
    public $status;
    public $featured;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db; // PostgreSQL native connection
    }

    public function getAll($limit = null) {
        if ($limit !== null) {
            $query = "SELECT * FROM {$this->table}
                    WHERE status = 'published'
                    ORDER BY year DESC, citations DESC
                    LIMIT $1";
            $result = pg_query_params($this->conn, $query, array($limit));
        } else {
            $query = "SELECT * FROM {$this->table}
                    WHERE status = 'published'
                    ORDER BY year DESC, citations DESC";
            $result = pg_query($this->conn, $query);
        }

        if (!$result) {
            return false;
        }

        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }

        return $publications;
    }

    public function getFeatured($limit = 6) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE status = 'published' AND featured = TRUE 
                  ORDER BY year DESC, citations DESC 
                  LIMIT $1";

        $result = pg_query_params($this->conn, $query, array($limit));
        
        if (!$result) {
            return false;
        }
        
        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }
        
        return $publications;
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = $1 LIMIT 1";
        $result = pg_query_params($this->conn, $query, array($id));
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }

    public function getByYear($year) {
        $query = "SELECT * FROM {$this->table}
                WHERE year = $1 AND status = 'published'
                ORDER BY citations DESC";
        $result = pg_query_params($this->conn, $query, array($year));
        
        if (!$result) {
            return false;
        }
        
        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }
        
        return $publications;
    }

    public function getByType($type) {
        $query = "SELECT * FROM {$this->table}
                WHERE type = $1 AND status = 'published'
                ORDER BY year DESC, citations DESC";
        $result = pg_query_params($this->conn, $query, array($type));
        
        if (!$result) {
            return false;
        }
        
        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }
        
        return $publications;
    }

    public function search($keyword) {
        $kw = '%' . $keyword . '%';
        $query = "SELECT * FROM {$this->table}
                WHERE status = 'published'
                  AND (title ILIKE $1
                       OR authors ILIKE $1
                       OR keywords ILIKE $1
                       OR abstract ILIKE $1)
                ORDER BY year DESC, citations DESC";
        $result = pg_query_params($this->conn, $query, array($kw));
        
        if (!$result) {
            return false;
        }
        
        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }
        
        return $publications;
    }

    public function getStats() {
        $query = "SELECT
                    COUNT(*)                    AS total_publications,
                    COALESCE(SUM(citations),0) AS total_citations,
                    COALESCE(AVG(citations),0) AS avg_citations,
                    MAX(year)                  AS latest_year,
                    MIN(year)                  AS earliest_year
                FROM {$this->table}
                WHERE status = 'published'";
        $result = pg_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }

    /**
     * Get all publications from unified view (lab + member publications)
     * @param int|null $limit Maximum number of results
     * @param string $orderBy Order by field (citations, year, created_at)
     * @return array|false
     */
    public function getAllUnified($limit = null, $orderBy = 'citations') {
        $validOrderFields = ['citations', 'year', 'created_at'];
        if (!in_array($orderBy, $validOrderFields)) {
            $orderBy = 'citations';
        }

        if ($limit !== null) {
            $query = "SELECT * FROM all_publications_view 
                    ORDER BY $orderBy DESC, year DESC
                    LIMIT $1";
            $result = pg_query_params($this->conn, $query, array($limit));
        } else {
            $query = "SELECT * FROM all_publications_view 
                    ORDER BY $orderBy DESC, year DESC";
            $result = pg_query($this->conn, $query);
        }

        if (!$result) {
            return false;
        }

        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }

        return $publications;
    }

    /**
     * Get featured publications from unified view
     * Featured means: high citation count OR featured flag
     * @param int $limit Maximum number of results
     * @return array|false
     */
    public function getFeaturedUnified($limit = 6) {
        $query = "SELECT * FROM all_publications_view 
                  WHERE featured = TRUE OR citations >= 20
                  ORDER BY citations DESC, year DESC 
                  LIMIT $1";

        $result = pg_query_params($this->conn, $query, array($limit));
        
        if (!$result) {
            return false;
        }
        
        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }
        
        return $publications;
    }
}
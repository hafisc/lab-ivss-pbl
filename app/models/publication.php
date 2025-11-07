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
        $this->conn = $db;
    }

    // Get all publications
    public function getAll($limit = null) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE status = 'published' 
                  ORDER BY year DESC, citations DESC";
        
        if ($limit) {
            $query .= " LIMIT " . intval($limit);
        }

        $result = pg_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        return $result;
    }

    // Get featured publications (untuk home page)
    public function getFeatured($limit = 6) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE status = 'published' AND featured = TRUE 
                  ORDER BY year DESC, citations DESC 
                  LIMIT $1";

        $result = pg_query_params($this->conn, $query, array($limit));
        
        if (!$result) {
            return false;
        }
        
        // Convert to array for easier use in view
        $publications = array();
        while ($row = pg_fetch_assoc($result)) {
            $publications[] = $row;
        }
        
        return $publications;
    }

    // Get publication by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = $1 LIMIT 1";
        
        $result = pg_query_params($this->conn, $query, array($id));
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }

    // Get by year
    public function getByYear($year) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE year = $1 AND status = 'published' 
                  ORDER BY citations DESC";
        
        $result = pg_query_params($this->conn, $query, array($year));
        
        if (!$result) {
            return false;
        }
        
        return $result;
    }

    // Get by type (journal, conference, etc)
    public function getByType($type) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE type = $1 AND status = 'published' 
                  ORDER BY year DESC, citations DESC";
        
        $result = pg_query_params($this->conn, $query, array($type));
        
        if (!$result) {
            return false;
        }
        
        return $result;
    }

    // Search publications
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE status = 'published' 
                  AND (title ILIKE $1 OR authors ILIKE $1 OR keywords ILIKE $1 OR abstract ILIKE $1) 
                  ORDER BY year DESC, citations DESC";
        
        $searchTerm = "%" . $keyword . "%";
        $result = pg_query_params($this->conn, $query, array($searchTerm));
        
        if (!$result) {
            return false;
        }
        
        return $result;
    }

    // Get statistics
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total_publications,
                    SUM(citations) as total_citations,
                    AVG(citations) as avg_citations,
                    MAX(year) as latest_year,
                    MIN(year) as earliest_year
                  FROM " . $this->table . " 
                  WHERE status = 'published'";
        
        $result = pg_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }

    // Create new publication
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (title, authors, year, journal, conference, doi, url, abstract, citations, keywords, type, status, featured) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13)";

        $result = pg_query_params($this->conn, $query, array(
            $this->title, 
            $this->authors, 
            $this->year, 
            $this->journal, 
            $this->conference, 
            $this->doi, 
            $this->url, 
            $this->abstract, 
            $this->citations, 
            $this->keywords, 
            $this->type, 
            $this->status, 
            $this->featured
        ));

        return $result !== false;
    }

    // Update publication
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET title = $1, authors = $2, year = $3, journal = $4, conference = $5, 
                      doi = $6, url = $7, abstract = $8, citations = $9, keywords = $10, 
                      type = $11, status = $12, featured = $13, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = $14";

        $result = pg_query_params($this->conn, $query, array(
            $this->title, 
            $this->authors, 
            $this->year, 
            $this->journal, 
            $this->conference, 
            $this->doi, 
            $this->url, 
            $this->abstract, 
            $this->citations, 
            $this->keywords, 
            $this->type, 
            $this->status, 
            $this->featured, 
            $this->id
        ));

        return $result !== false;
    }

    // Delete publication
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = $1";
        
        $result = pg_query_params($this->conn, $query, array($this->id));
        
        return $result !== false;
    }
}

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
        $this->conn = $db; // PDO instance
    }

    public function getAll($limit = null) {
        $sql = "SELECT * FROM {$this->table}
                WHERE status = 'published'
                ORDER BY year DESC, citations DESC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->conn->query($sql);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByYear($year) {
        $sql = "SELECT * FROM {$this->table}
                WHERE year = :year AND status = 'published'
                ORDER BY citations DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':year' => $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByType($type) {
        $sql = "SELECT * FROM {$this->table}
                WHERE type = :type AND status = 'published'
                ORDER BY year DESC, citations DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':type' => $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($keyword) {
        $sql = "SELECT * FROM {$this->table}
                WHERE status = 'published'
                  AND (title ILIKE :kw
                       OR authors ILIKE :kw
                       OR keywords ILIKE :kw
                       OR abstract ILIKE :kw)
                ORDER BY year DESC, citations DESC";

        $stmt = $this->conn->prepare($sql);
        $kw = '%' . $keyword . '%';
        $stmt->execute([':kw' => $kw]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStats() {
        $sql = "SELECT
                    COUNT(*)                    AS total_publications,
                    COALESCE(SUM(citations),0) AS total_citations,
                    COALESCE(AVG(citations),0) AS avg_citations,
                    MAX(year)                  AS latest_year,
                    MIN(year)                  AS earliest_year
                FROM {$this->table}
                WHERE status = 'published'";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $sql = "INSERT INTO {$this->table}
                (title, authors, year, journal, conference, doi, url,
                 abstract, citations, keywords, type, status, featured)
                VALUES
                (:title, :authors, :year, :journal, :conference, :doi, :url,
                 :abstract, :citations, :keywords, :type, :status, :featured)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title'      => $this->title,
            ':authors'    => $this->authors,
            ':year'       => $this->year,
            ':journal'    => $this->journal,
            ':conference' => $this->conference,
            ':doi'        => $this->doi,
            ':url'        => $this->url,
            ':abstract'   => $this->abstract,
            ':citations'  => $this->citations,
            ':keywords'   => $this->keywords,
            ':type'       => $this->type,
            ':status'     => $this->status,
            ':featured'   => $this->featured,
        ]);
    }

    public function update() {
        $sql = "UPDATE {$this->table}
                SET title      = :title,
                    authors    = :authors,
                    year       = :year,
                    journal    = :journal,
                    conference = :conference,
                    doi        = :doi,
                    url        = :url,
                    abstract   = :abstract,
                    citations  = :citations,
                    keywords   = :keywords,
                    type       = :type,
                    status     = :status,
                    featured   = :featured,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':title'      => $this->title,
            ':authors'    => $this->authors,
            ':year'       => $this->year,
            ':journal'    => $this->journal,
            ':conference' => $this->conference,
            ':doi'        => $this->doi,
            ':url'        => $this->url,
            ':abstract'   => $this->abstract,
            ':citations'  => $this->citations,
            ':keywords'   => $this->keywords,
            ':type'       => $this->type,
            ':status'     => $this->status,
            ':featured'   => $this->featured,
            ':id'         => $this->id,
        ]);
    }

    public function delete() {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $this->id]);
    }
}
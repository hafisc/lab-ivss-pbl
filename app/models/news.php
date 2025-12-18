<?php

class News {
    private $conn;
    private $table = 'news';

    public $id;
    public $title;
    public $slug;
    public $content;
    public $excerpt;
    public $image;
    public $file_path;
    public $category;
    public $tags;
    public $author_id;
    public $status;
    public $published_at;
    public $views;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all news
    public function getAll($limit = null, $status = 'published') {
        $query = "SELECT n.*, 
                         COALESCE(d.nama, m.nama, u.username) as author_name 
                  FROM " . $this->table . " n 
                  LEFT JOIN users u ON n.author_id = u.id 
                  LEFT JOIN dosen d ON u.id = d.user_id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id
                  WHERE n.status = $1 
                  ORDER BY n.published_at DESC, n.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT " . intval($limit);
        }

        $result = pg_query_params($this->conn, $query, array($status));
        
        if (!$result) {
            return false;
        }
        
        // Convert to array
        $news = array();
        while ($row = pg_fetch_assoc($result)) {
            // Format image URL
            if (!empty($row['image'])) {
                $row['image_url'] = $row['image'];
            } else {
                $row['image_url'] = null;
            }
            $news[] = $row;
        }
        
        return $news;
    }

    // Get latest published news untuk home page
    public function getLatest($limit = 6) {
        $query = "SELECT n.*, 
                         COALESCE(d.nama, m.nama, u.username) as author_name 
                  FROM " . $this->table . " n 
                  LEFT JOIN users u ON n.author_id = u.id 
                  LEFT JOIN dosen d ON u.id = d.user_id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id
                  WHERE n.status = 'published' 
                  ORDER BY n.published_at DESC, n.created_at DESC 
                  LIMIT $1";

        $result = pg_query_params($this->conn, $query, array($limit));
        
        if (!$result) {
            return false;
        }
        
        // Convert to array
        $news = array();
        while ($row = pg_fetch_assoc($result)) {
            // Format image URL
            if (!empty($row['image'])) {
                $row['image_url'] = $row['image'];
            } else {
                $row['image_url'] = null;
            }
            $news[] = $row;
        }
        
        return $news;
    }

    // Get news by ID
    public function getById($id) {
        $query = "SELECT n.*, 
                         COALESCE(d.nama, m.nama, u.username) as author_name 
                  FROM " . $this->table . " n 
                  LEFT JOIN users u ON n.author_id = u.id 
                  LEFT JOIN dosen d ON u.id = d.user_id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id
                  WHERE n.id = $1 
                  LIMIT 1";
        
        $result = pg_query_params($this->conn, $query, array($id));
        
        if (!$result) {
            return false;
        }
        
        $row = pg_fetch_assoc($result);
        if ($row) {
            // Format image URL
            if (!empty($row['image'])) {
                $row['image_url'] = $row['image'];
            } else {
                $row['image_url'] = null;
            }
        }
        return $row;
    }

    // Get news by slug
    public function getBySlug($slug) {
        $query = "SELECT n.*, 
                         COALESCE(d.nama, m.nama, u.username) as author_name 
                  FROM " . $this->table . " n 
                  LEFT JOIN users u ON n.author_id = u.id 
                  LEFT JOIN dosen d ON u.id = d.user_id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id
                  WHERE n.slug = $1 
                  LIMIT 1";
        
        $result = pg_query_params($this->conn, $query, array($slug));
        
        if (!$result) {
            return false;
        }
        
        $row = pg_fetch_assoc($result);
        if ($row) {
            // Format image URL
            if (!empty($row['image'])) {
                $row['image_url'] = $row['image'];
            } else {
                $row['image_url'] = null;
            }
        }
        return $row;
    }

    // Search news
    public function search($keyword) {
        $query = "SELECT n.*, 
                         COALESCE(d.nama, m.nama, u.username) as author_name 
                  FROM " . $this->table . " n 
                  LEFT JOIN users u ON n.author_id = u.id 
                  LEFT JOIN dosen d ON u.id = d.user_id
                  LEFT JOIN mahasiswa m ON u.id = m.user_id
                  WHERE n.status = 'published' 
                  AND (n.title ILIKE $1 OR n.content ILIKE $1 OR n.excerpt ILIKE $1) 
                  ORDER BY n.published_at DESC";
        
        $searchTerm = "%" . $keyword . "%";
        $result = pg_query_params($this->conn, $query, array($searchTerm));
        
        if (!$result) {
            return false;
        }
        
        $news = array();
        while ($row = pg_fetch_assoc($result)) {
            // Format image URL
            if (!empty($row['image'])) {
                $row['image_url'] = $row['image'];
            } else {
                $row['image_url'] = null;
            }
            $news[] = $row;
        }
        
        return $news;
    }

    // Increment views
    public function incrementViews($id) {
        $query = "UPDATE " . $this->table . " 
                  SET views = views + 1 
                  WHERE id = $1";
        
        $result = pg_query_params($this->conn, $query, array($id));
        
        return $result !== false;
    }

    // Create new news
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (title, slug, content, excerpt, image, file_path, category, tags, author_id, status, published_at) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11) 
                  RETURNING id";

        $result = pg_query_params($this->conn, $query, array(
            $this->title, 
            $this->slug, 
            $this->content, 
            $this->excerpt, 
            $this->image,
            $this->file_path,
            $this->category,
            $this->tags, 
            $this->author_id, 
            $this->status, 
            $this->published_at
        ));

        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['id'];
        }
        
        return false;
    }

    // Update news
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET title = $1, slug = $2, content = $3, excerpt = $4, 
                      image = $5, file_path = $6, category = $7, tags = $8, status = $9, published_at = $10, updated_at = CURRENT_TIMESTAMP 
                  WHERE id = $11";

        $result = pg_query_params($this->conn, $query, array(
            $this->title, 
            $this->slug, 
            $this->content, 
            $this->excerpt, 
            $this->image,
            $this->file_path,
            $this->category,
            $this->tags, 
            $this->status, 
            $this->published_at, 
            $this->id
        ));

        return $result !== false;
    }

    // Delete news
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = $1";
        
        $result = pg_query_params($this->conn, $query, array($this->id));
        
        return $result !== false;
    }

    // Get statistics
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total_news,
                    SUM(views) as total_views,
                    AVG(views) as avg_views
                  FROM " . $this->table . " 
                  WHERE status = 'published'";
        
        $result = pg_query($this->conn, $query);
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }
}

<?php

class Equipment
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // PgSql\Connection dari getDb()
    }

    public function getAll()
    {
        $result = pg_query($this->db, "SELECT * FROM equipment ORDER BY id DESC");
        if (!$result) {
            return [];
        }
        $rows = [];
        while ($row = pg_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Ambil data untuk landing page
    public function getForLanding($limit = 8)
    {
        $limit = (int)$limit;
        $result = pg_query_params(
            $this->db,
            "SELECT * FROM equipment ORDER BY id DESC LIMIT $1",
            [$limit]
        );

        if (!$result) {
            return [];
        }

        $rows = [];
        while ($row = pg_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function findById($id)
    {
        $result = pg_query_params(
            $this->db,
            "SELECT * FROM equipment WHERE id = $1",
            [(int)$id]
        );

        if (!$result) {
            return null;
        }

        return pg_fetch_assoc($result) ?: null;
    }

    public function create($data)
    {
        $result = pg_query_params(
            $this->db,
            "INSERT INTO equipment (name, category, brand, image, quantity, condition, location)
             VALUES ($1, $2, $3, $4, $5, $6, $7)",
            [
                $data['name'],
                $data['category'],
                $data['brand'] ?? null,
                $data['image'] ?? null,
                (int)($data['quantity'] ?? 1),
                $data['condition'],
                $data['location'] ?? null,
            ]
        );

        return $result !== false;
    }

    public function update($id, $data)
    {
        $result = pg_query_params(
            $this->db,
            "UPDATE equipment
             SET name = $1,
                 category = $2,
                 brand = $3,
                 image = $4,
                 quantity = $5,
                 condition = $6,
                 location = $7
             WHERE id = $8",
            [
                $data['name'],
                $data['category'],
                $data['brand'] ?? null,
                $data['image'] ?? null,
                (int)($data['quantity'] ?? 1),
                $data['condition'],
                $data['location'] ?? null,
                (int)$id,
            ]
        );

        return $result !== false;
    }

    public function delete($id)
    {
        $result = pg_query_params(
            $this->db,
            "DELETE FROM equipment WHERE id = $1",
            [(int)$id]
        );

        return $result !== false;
    }
}
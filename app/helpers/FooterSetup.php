<?php

class FooterSetup
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Initialize footer_settings table if it doesn't exist
     * and create default record if needed
     */
    public function initialize()
    {
        try {
            // Check if table exists
            $checkTable = "SELECT EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_name = 'footer_settings'
            )";
            $result = @pg_query($this->db, $checkTable);

            if (!$result) {
                throw new Exception('Cannot check table: ' . pg_last_error($this->db));
            }

            $row = pg_fetch_row($result);
            $tableExists = $row[0]; 

            if (!$tableExists) {
                // Create table
                $createTable = "CREATE TABLE IF NOT EXISTS footer_settings (
                    id SERIAL PRIMARY KEY,
                    description TEXT,
                    email VARCHAR(255),
                    phone VARCHAR(20),
                    address TEXT,
                    instagram VARCHAR(255),
                    facebook VARCHAR(255),
                    linkedin VARCHAR(255),
                    twitter VARCHAR(255),
                    youtube VARCHAR(255),
                    quick_links JSONB DEFAULT '[]',
                    resources JSONB DEFAULT '[]',
                    copyright_text VARCHAR(255),
                    privacy_url VARCHAR(255),
                    terms_url VARCHAR(255),
                    operating_hours TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

                $res = @pg_query($this->db, $createTable);
                if (!$res) {
                    throw new Exception('Failed to create footer_settings table: ' . pg_last_error($this->db));
                }

                // Create index
                $createIndex = "CREATE INDEX IF NOT EXISTS idx_footer_settings_id ON footer_settings(id)";
                @pg_query($this->db, $createIndex);
            } else {
                // Table exists, check if new columns need to be added
                $checkColumns = "SELECT column_name FROM information_schema.columns WHERE table_name='footer_settings'";
                $result = @pg_query($this->db, $checkColumns);
                $columns = [];
                while ($col = pg_fetch_assoc($result)) {
                    $columns[] = $col['column_name'];
                }

                // Add missing columns if they don't exist
                if (!in_array('copyright_text', $columns)) {
                    @pg_query($this->db, "ALTER TABLE footer_settings ADD COLUMN copyright_text VARCHAR(255)");
                }
                if (!in_array('privacy_url', $columns)) {
                    @pg_query($this->db, "ALTER TABLE footer_settings ADD COLUMN privacy_url VARCHAR(255)");
                }
                if (!in_array('terms_url', $columns)) {
                    @pg_query($this->db, "ALTER TABLE footer_settings ADD COLUMN terms_url VARCHAR(255)");
                }
                if (!in_array('operating_hours', $columns)) {
                    @pg_query($this->db, "ALTER TABLE footer_settings ADD COLUMN operating_hours TEXT");
                }
            }

            // Check if default record exists
            $checkDefault = "SELECT id FROM footer_settings LIMIT 1";
            $result = @pg_query($this->db, $checkDefault);

            if (!$result) {
                throw new Exception('Cannot query footer_settings: ' . pg_last_error($this->db));
            }

            if (pg_num_rows($result) === 0) {
                // Insert default record
                $insertDefault = "INSERT INTO footer_settings (description, quick_links, resources)
                    VALUES ($1, $2, $3)";

                $params = [
                    'Laboratorium Inovasi Visi Sistem Intelligent',
                    json_encode([]),
                    json_encode([])
                ];

                $res = @pg_query_params($this->db, $insertDefault, $params);
                if (!$res) {
                    throw new Exception('Failed to insert default footer record: ' . pg_last_error($this->db));
                }
            }

            return true;
        } catch (Exception $e) {
            error_log('FooterSetup Error: ' . $e->getMessage());
            return false;
        }
    }
}

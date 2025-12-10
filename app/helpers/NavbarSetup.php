<?php

class NavbarSetup
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Initialize navbar_settings table if it doesn't exist
     */
    public function initialize()
    {
        try {
            // Check if table exists
            $checkTable = "SELECT EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_name = 'navbar_settings'
            )";
            $result = @pg_query($this->db, $checkTable);

            if (!$result) {
                throw new Exception('Cannot check table: ' . pg_last_error($this->db));
            }

            $row = pg_fetch_row($result);
            $tableExists = $row[0];

            if (!$tableExists) {
                // Create table
                $createTable = "CREATE TABLE IF NOT EXISTS navbar_settings (
                    id SERIAL PRIMARY KEY,
                    topbar_text VARCHAR(255),
                    institution_name VARCHAR(255),
                    lab_name VARCHAR(255),
                    logo_url VARCHAR(255),
                    login_url VARCHAR(255),
                    menu_items JSONB DEFAULT '[]',
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

                $res = @pg_query($this->db, $createTable);
                if (!$res) {
                    throw new Exception('Failed to create navbar_settings table: ' . pg_last_error($this->db));
                }

                // Create index
                $createIndex = "CREATE INDEX IF NOT EXISTS idx_navbar_settings_id ON navbar_settings(id)";
                @pg_query($this->db, $createIndex);
            } else {
                // Table exists, check if new columns need to be added
                $checkColumns = "SELECT column_name FROM information_schema.columns WHERE table_name='navbar_settings'";
                $result = @pg_query($this->db, $checkColumns);
                $columns = [];
                while ($col = pg_fetch_assoc($result)) {
                    $columns[] = $col['column_name'];
                }

                // Add missing columns if they don't exist
                if (!in_array('topbar_text', $columns)) {
                    @pg_query($this->db, "ALTER TABLE navbar_settings ADD COLUMN topbar_text VARCHAR(255)");
                }
                if (!in_array('menu_items', $columns)) {
                    @pg_query($this->db, "ALTER TABLE navbar_settings ADD COLUMN menu_items JSONB DEFAULT '[]'");
                }
            }

            // Check if default record exists
            $checkDefault = "SELECT id FROM navbar_settings LIMIT 1";
            $result = @pg_query($this->db, $checkDefault);

            if (!$result) {
                throw new Exception('Cannot query navbar_settings: ' . pg_last_error($this->db));
            }

            if (pg_num_rows($result) === 0) {
                // Insert default record with default menu items
                $defaultMenuItems = json_encode([
                    ['label' => 'Beranda', 'url' => '#beranda', 'order' => 1],
                    ['label' => 'Profil', 'url' => '#profil', 'order' => 2],
                    ['label' => 'Riset', 'url' => '#riset', 'order' => 3],
                    ['label' => 'Fasilitas', 'url' => '#fasilitas', 'order' => 4],
                    ['label' => 'Member', 'url' => '#member', 'order' => 5],
                    ['label' => 'Berita', 'url' => '#berita', 'order' => 6],
                    ['label' => 'Kontak', 'url' => '#kontak', 'order' => 7]
                ]);

                $insertDefault = "INSERT INTO navbar_settings 
                    (topbar_text, institution_name, lab_name, logo_url, login_url, menu_items)
                    VALUES ($1, $2, $3, $4, $5, $6)";

                $params = [
                    'Laboratorium Intelligent Vision and Smart System (IVSS) – Jurusan Teknologi Informasi – Politeknik Negeri Malang',
                    'Politeknik Negeri Malang',
                    'Lab Intelligent Vision and Smart System',
                    'assets/images/logo1.png',
                    'index.php?page=login',
                    $defaultMenuItems
                ];

                $res = @pg_query_params($this->db, $insertDefault, $params);
                if (!$res) {
                    throw new Exception('Failed to insert default navbar record: ' . pg_last_error($this->db));
                }
            }

            return true;
        } catch (Exception $e) {
            error_log('NavbarSetup Error: ' . $e->getMessage());
            return false;
        }
    }
}

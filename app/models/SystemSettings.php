<?php

class SystemSettings {
    private $db;
    private $table = 'system_settings';

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        $result = pg_query($this->db, $query);
        
        $settings = [];
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }
        return $settings;
    }

    public function update($key, $value) {
        $query = "UPDATE {$this->table} SET setting_value = $1, updated_at = NOW() WHERE setting_key = $2";
        return pg_query_params($this->db, $query, [$value, $key]);
    }
}

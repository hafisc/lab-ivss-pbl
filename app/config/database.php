<?php
class Database
{
    private $host = '127.0.0.1';
    private $port = '5432';
    private $db_name = 'lab_ivss';
    private $username = 'postgres';
    private $password = '12345';
    private $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }

        return $this->conn;
    }
}

// Legacy function untuk backward compatibility
function getDb()
{
    $host = '127.0.0.1';
    $port = '5432';               
    $db   = 'lab_ivss';
    $user = 'postgres';          
    $pass = '12345';           

    $connection_string = "host=$host port=$port dbname=$db user=$user password=$pass";

    // Coba koneksi tanpa suppress error supaya kita bisa menangkap pesan yang jelas
    $connection = pg_connect($connection_string);

    // Jika koneksi gagal, ambil pesan error PHP terakhir (mis. peringatan dari pg_connect)
    if ($connection === false) {
        $last = error_get_last();
        $msg = 'Unable to connect to PostgreSQL.';
        if ($last && isset($last['message']) && !empty($last['message'])) {
            $msg = $last['message'];
        }

        // Jangan panggil pg_last_error() tanpa resource — itu deprecated/menimbulkan fatal error.
        die('Database connection error: ' . $msg);
    }

    // Set timezone PostgreSQL ke Asia/Jakarta untuk konsistensi dengan PHP
    pg_query($connection, "SET TIME ZONE 'Asia/Jakarta'");

    return $connection;
}

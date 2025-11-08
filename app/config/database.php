<?php
class Database {
    private $host = '127.0.0.1';
    private $port = '5433';
    private $db_name = 'lab_ivss';
    private $username = 'USER';
    private $password = 'Nada140125@';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }

        return $this->conn;
    }
}

// Legacy function untuk backward compatibility
function getDb()
{
    $host = '127.0.0.1';
    $port = '5433';               
    $db   = 'lab_ivss';
    $user = 'USER';          
    $pass = 'Nada140125@';           

    $connection_string = "host=$host port=$port dbname=$db user=$user password=$pass";

    $connection = @pg_connect($connection_string);

    if (!$connection) {
        die('Database connection error: ' . pg_last_error());
    }

    return $connection;
}

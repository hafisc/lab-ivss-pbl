<?php
/**
 * Database Connection Handler
 * Singleton pattern untuk efficient connection management
 */
class Database
{
    private static $instance = null;
    private $pdo = null;
    private $pg = null;
    
    // Database config (loaded from .env file)
    private $host;
    private $port;
    private $dbname;
    private $user;
    private $pass;

    /**
     * Private constructor untuk singleton pattern
     */
    private function __construct()
    {
        // Load .env file
        $this->loadEnv();
        
        // Load database config dari .env
        $this->host   = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $this->port   = $_ENV['DB_PORT'] ?? '5432';
        $this->dbname = $_ENV['DB_DATABASE'] ?? 'lab_ivss';
        $this->user   = $_ENV['DB_USERNAME'] ?? 'US';
        $this->pass   = $_ENV['DB_PASSWORD'] ?? '1707';
    }

    /**
     * Load .env file and populate $_ENV
     */
    private function loadEnv()
    {
        $envFile = __DIR__ . '/../../.env';
        
        if (!file_exists($envFile)) {
            return; // Skip jika file tidak ada, gunakan default
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove quotes if present
                $value = trim($value, '"\'');
                
                // Set to $_ENV
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }

    /**
     * Get singleton instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get PDO connection (modern approach)
     */
    public function getConnection()
    {
        if ($this->pdo !== null) {
            return $this->pdo;
        }

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Set timezone
            $this->pdo->exec("SET TIME ZONE 'Asia/Jakarta'");
            
            return $this->pdo;
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    /**
     * Get pg_connect resource (legacy support)
     */
    public function getPgConnection()
    {
        if ($this->pg !== null) {
            return $this->pg;
        }

        $connString = "host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user} password={$this->pass}";
        $this->pg = pg_connect($connString);

        if ($this->pg === false) {
            $error = error_get_last();
            $msg = $error['message'] ?? 'Unable to connect to PostgreSQL.';
            die('Database connection error: ' . $msg);
        }

        // Set timezone
        pg_query($this->pg, "SET TIME ZONE 'Asia/Jakarta'");

        return $this->pg;
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Prevent unserialization
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}

/**
 * Helper function untuk backward compatibility
 * @return resource PostgreSQL connection
 */
function getDb()
{
    return Database::getInstance()->getPgConnection();
}

<?php
/**
 * Handler Koneksi Database
 * Menerapkan pola Singleton untuk manajemen koneksi yang efisien.
 * Mengelola koneksi ke database PostgreSQL menggunakan PDO dan pg_connect.
 * 
 * @package App\Config
 */
class Database
{
    /**
     * @var Database|null Instance singleton
     */
    private static $instance = null;

    /**
     * @var PDO|null Objek koneksi PDO
     */
    private $pdo = null;

    /**
     * @var resource|null Resource koneksi PostgreSQL (legacy)
     */
    private $pg = null;
    
    // Konfigurasi database (dimuat dari file .env)
    private $host;
    private $port;
    private $dbname;
    private $user;
    private $pass;

    /**
     * Konstruktor privat untuk pola singleton.
     * Memuat konfigurasi dari file .env saat inisialisasi.
     */
    private function __construct()
    {
        // Muat file .env
        $this->loadEnv();
        
        // Atur konfigurasi database dari variabel environment
        $this->host   = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $this->port   = $_ENV['DB_PORT'] ?? '5433';
        $this->dbname = $_ENV['DB_DATABASE'] ?? 'lab_ivss';
        $this->user   = $_ENV['DB_USERNAME'] ?? 'USER';
        $this->pass   = $_ENV['DB_PASSWORD'] ?? 'Nada140125@';
    }

    /**
     * Memuat file .env dan mengisi array global $_ENV.
     * Parsing sederhana untuk file konfigurasi environment.
     * 
     * @return void
     */
    private function loadEnv()
    {
        $envFile = __DIR__ . '/../../.env';
        
        if (!file_exists($envFile)) {
            return; // Lewati jika file tidak ditemukan
        }

        // Baca file baris per baris
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Lewati komentar
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parsing format KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Hapus tanda kutip jika ada
                $value = trim($value, '"\'');
                
                // Simpan ke $_ENV dan environment server
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }

    /**
     * Mendapatkan instance singleton dari kelas Database.
     * 
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Mendapatkan koneksi PDO (Pendekatan Modern).
     * Disarankan untuk query baru yang menggunakan prepared statements.
     * 
     * @return PDO
     */
    public function getConnection()
    {
        if ($this->pdo !== null) {
            return $this->pdo;
        }

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            
            // Atur mode error ke Exception agar mudah didebug
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Atur default fetch mode ke Associative Array
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Set timezone ke WIB
            $this->pdo->exec("SET TIME ZONE 'Asia/Jakarta'");
            
            return $this->pdo;
        } catch (PDOException $e) {
            die("Kesalahan koneksi database: " . $e->getMessage());
        }
    }

    /**
     * Mendapatkan resource koneksi pg_connect (Dukungan Legacy).
     * Digunakan untuk kode lama yang masih menggunakan fungsi pg_*.
     * 
     * @return resource|false
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
            $msg = $error['message'] ?? 'Tidak dapat terhubung ke PostgreSQL.';
            die('Kesalahan koneksi database: ' . $msg);
        }

        // Set timezone koneksi
        pg_query($this->pg, "SET TIME ZONE 'Asia/Jakarta'");

        return $this->pg;
    }

    /**
     * Mencegah cloning instance (Singleton).
     */
    private function __clone() {}

    /**
     * Mencegah unserialize instance (Singleton).
     * 
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Tidak dapat melakukan unserialize pada singleton.");
    }
}

/**
 * Fungsi Helper Global untuk mendapatkan koneksi database.
 * Memudahkan akses koneksi tanpa memanggil Database::getInstance() berulang kali.
 * 
 * @return resource Koneksi PostgreSQL (pg_connect resource)
 */
function getDb()
{
    return Database::getInstance()->getPgConnection();
}

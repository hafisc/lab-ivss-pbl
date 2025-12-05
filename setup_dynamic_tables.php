<?php
require_once __DIR__ . '/app/config/database.php';

$db = getDB();

// Create facilities table
$query = "CREATE TABLE IF NOT EXISTS facilities (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$result = pg_query($db, $query);

if ($result) {
    echo "Table facilities created successfully.\n";
    
    // Insert default facilities if empty
    $check = pg_query($db, "SELECT COUNT(*) FROM facilities");
    $count = pg_fetch_result($check, 0, 0);
    
    if ($count == 0) {
        $defaults = [
            ['Deep Camera', 'Kamera depth sensing untuk riset 3D vision'],
            ['High FPS Camera', 'Kamera kecepatan tinggi untuk menangkap gerakan cepat'],
            ['Sony Alpha 6700', 'Kamera mirrorless high-end untuk pengambilan dataset berkualitas'],
            ['Lampu Data Primer', 'Pencahayaan studio untuk kondisi cahaya terkontrol'],
            ['Peralatan Objek Kecil', 'Meja putar dan background untuk scanning objek kecil'],
            ['Musholla', 'Tempat ibadah yang nyaman'],
            ['Loker Penyimpanan', 'Loker aman untuk menyimpan barang pribadi member'],
            ['Ruang Pelatihan Internal', 'Ruang kelas untuk workshop dan sharing session']
        ];
        
        foreach ($defaults as $facility) {
            pg_query_params($db, "INSERT INTO facilities (name, description) VALUES ($1, $2)", $facility);
        }
        echo "Default facilities inserted.\n";
    }
} else {
    echo "Error creating table: " . pg_last_error($db) . "\n";
}

// Check team_members table
$query = "CREATE TABLE IF NOT EXISTS team_members (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    position VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    email VARCHAR(255),
    bio TEXT,
    order_position INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
pg_query($db, $query);

// Insert default team members if empty
$check = pg_query($db, "SELECT COUNT(*) FROM team_members");
$count = pg_fetch_result($check, 0, 0);

if ($count == 0) {
    $defaults = [
        ['Ir. Andre', 'Kepala Laboratorium', 'Computer Vision & AI'],
        ['Dr. Ari', 'Dosen Pembina', 'Deep Learning & Image Processing'],
        ['Bu Mungki', 'Dosen Pembina', 'Intelligent Systems'],
        ['Bu Eli', 'Dosen Pembina', 'Pattern Recognition'],
        ['Bu Heni', 'Dosen Pembina', 'Computer Vision'],
        ['Bu Vivi', 'Dosen Pembina', 'AI & Machine Learning']
    ];
    
    $i = 1;
    foreach ($defaults as $member) {
        pg_query_params($db, "INSERT INTO team_members (name, position, bio, order_position) VALUES ($1, $2, $3, $4)", [$member[0], $member[1], $member[2], $i++]);
    }
    echo "Default team members inserted.\n";
}

echo "Database setup completed.\n";

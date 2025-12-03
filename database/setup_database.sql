-- ========================================
-- Lab IVSS Database Setup - Restructured
-- Run this script in your SQL Editor
-- ========================================

-- Drop existing tables (OPTIONAL - uncomment untuk reset database)
-- DROP TABLE IF EXISTS member_publications CASCADE;
-- DROP TABLE IF EXISTS research_documents CASCADE;
-- DROP TABLE IF EXISTS research_members CASCADE;
-- DROP TABLE IF EXISTS notifications CASCADE;
-- DROP TABLE IF EXISTS system_settings CASCADE;
-- DROP TABLE IF EXISTS equipment CASCADE;
-- DROP TABLE IF EXISTS publications CASCADE;
-- DROP TABLE IF EXISTS news CASCADE;
-- DROP TABLE IF EXISTS member_registrations CASCADE;
-- DROP TABLE IF EXISTS mahasiswa CASCADE;
-- DROP TABLE IF EXISTS dosen CASCADE;
-- DROP TABLE IF EXISTS research CASCADE;
-- DROP TABLE IF EXISTS users CASCADE;
-- DROP TABLE IF EXISTS roles CASCADE;

-- ========================================
-- 1. TABEL ROLES (MASTER DATA)
-- ========================================
-- Untuk menyimpan master data role dalam sistem
CREATE TABLE IF NOT EXISTS roles (
    id SERIAL PRIMARY KEY,
    role_name VARCHAR(50) UNIQUE NOT NULL,
    role_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO roles (role_name, role_description) VALUES
('admin', 'Administrator sistem dengan akses penuh'),
('ketua_lab', 'Ketua laboratorium yang mengelola lab'),
('dosen', 'Dosen pengampu/pembimbing riset'),
('mahasiswa', 'Mahasiswa anggota lab');

-- ========================================
-- 2. TABEL USERS (RESTRUCTURED - UNTUK AUTENTIKASI)
-- ========================================
-- Tabel utama untuk autentikasi, hanya berisi kredensial dan info umum
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INTEGER NOT NULL REFERENCES roles(id),
    status VARCHAR(50) DEFAULT 'active',  -- 'pending', 'active', 'inactive', 'rejected'
    photo VARCHAR(255),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP
);

-- Index untuk performa
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_role ON users(role_id);
CREATE INDEX idx_users_status ON users(status);

-- Insert data user default (admin & ketua lab)
-- Password untuk semua user: admin123
INSERT INTO users (username, email, password, role_id, status, last_login) VALUES
-- Admin
('admin_ivss', 'admin@ivss.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 1, 'active', CURRENT_TIMESTAMP),

-- Ketua Lab
('dr_hasan', 'ketualab@ivss.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 2, 'active', CURRENT_TIMESTAMP);

-- ========================================
-- 3. TABEL DOSEN
-- ========================================
-- Untuk menyimpan data spesifik dosen
CREATE TABLE IF NOT EXISTS dosen (
    id SERIAL PRIMARY KEY,
    user_id INTEGER UNIQUE NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    nip VARCHAR(50) UNIQUE NOT NULL,
    nama VARCHAR(255) NOT NULL,
    origin VARCHAR(255),  -- Asal institusi/pendidikan
    no_hp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_dosen_user ON dosen(user_id);
CREATE INDEX idx_dosen_nip ON dosen(nip);

-- Insert user dosen terlebih dahulu
INSERT INTO users (username, email, password, role_id, status, last_login) VALUES
('budi_dosen', 'budi.dosen@polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 3, 'active', CURRENT_TIMESTAMP),
('andi_dosen', 'andi.dosen@polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 3, 'active', CURRENT_TIMESTAMP),
('siti_dosen', 'siti.dosen@polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 3, 'active', CURRENT_TIMESTAMP);

-- Insert data dosen
INSERT INTO dosen (user_id, nip, nama, origin, no_hp) VALUES
(3, '197505152000031001', 'Dr. Budi Santoso', 'S3 Teknik Informatika - Institut Teknologi Bandung', '081234567892'),
(4, '198003102005011002', 'Dr. Andi Wijaya', 'S3 Computer Science - Universitas Gadjah Mada', '081234567893'),
(5, '198206182008012003', 'Dr. Siti Nurhaliza', 'S3 Artificial Intelligence - Institut Teknologi Sepuluh Nopember', '081234567894');

-- ========================================
-- 4. TABEL MAHASISWA
-- ========================================
-- Untuk menyimpan data spesifik mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
    id SERIAL PRIMARY KEY,
    user_id INTEGER UNIQUE NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    nim VARCHAR(50) UNIQUE NOT NULL,
    nama VARCHAR(255) NOT NULL,
    angkatan VARCHAR(10),
    research_title VARCHAR(255),
    no_phone VARCHAR(20),
    supervisor_id INTEGER REFERENCES dosen(id) ON DELETE SET NULL,  -- FK ke tabel dosen
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_mahasiswa_user ON mahasiswa(user_id);
CREATE INDEX idx_mahasiswa_nim ON mahasiswa(nim);
CREATE INDEX idx_mahasiswa_supervisor ON mahasiswa(supervisor_id);
CREATE INDEX idx_mahasiswa_angkatan ON mahasiswa(angkatan);

-- Insert user mahasiswa terlebih dahulu
INSERT INTO users (username, email, password, role_id, status, last_login) VALUES
-- Mahasiswa aktif
('ahmad_fauzi', 'ahmad@student.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 4, 'active', CURRENT_TIMESTAMP),

-- Mahasiswa alumni (inactive)
('agus_prasetyo', 'agus@alumni.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 4, 'inactive', '2024-10-15 10:00:00');

-- Insert data mahasiswa
INSERT INTO mahasiswa (user_id, nim, nama, angkatan, research_title, no_phone, supervisor_id) VALUES
(6, '2141720010', 'Ahmad Fauzi', '2024', 'Face Recognition dengan Deep Learning', '081234567895', 1),  -- Supervisor: Dr. Budi
(7, '2131720001', 'Agus Prasetyo', '2021', 'Object Detection untuk Smart City', '081234567896', 2);     -- Supervisor: Dr. Andi

-- ========================================
-- 5. TABEL RESEARCH (OPTIMIZED)
-- ========================================
-- Untuk menyimpan data riset/penelitian
CREATE TABLE IF NOT EXISTS research (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100) DEFAULT 'Riset Lainnya',
    image VARCHAR(255),
    leader_id INTEGER REFERENCES users(id),  -- Bisa dosen, ketua_lab, atau admin
    status VARCHAR(50) DEFAULT 'active',
    start_date DATE,
    end_date DATE,
    funding VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_research_status ON research(status);
CREATE INDEX idx_research_category ON research(category);
CREATE INDEX idx_research_leader ON research(leader_id);

-- Insert sample data riset
INSERT INTO research (title, description, category, leader_id, status, start_date, funding) VALUES
('Face Recognition dengan Deep Learning', 
'Riset pengembangan sistem face recognition menggunakan Convolutional Neural Network (CNN) untuk aplikasi keamanan dan absensi.', 
'Riset Utama', 3, 'active', '2024-01-15', 'Hibah Dikti 2024'),

('Object Detection untuk Smart Surveillance', 
'Pengembangan sistem deteksi objek real-time menggunakan YOLO untuk aplikasi surveillance pintar di kampus.', 
'Riset Utama', 4, 'active', '2024-02-01', 'Hibah Internal'),

('Natural Language Processing untuk Bahasa Indonesia', 
'Riset pengembangan model NLP untuk pemrosesan bahasa Indonesia dalam aplikasi chatbot dan text analysis.', 
'Riset Utama', 5, 'active', '2024-02-20', 'Hibah Dikti 2024'),

('IoT-based Smart Room Monitoring', 
'Sistem monitoring ruangan pintar menggunakan sensor IoT dan computer vision untuk efisiensi energi.', 
'Riset Pendukung', 3, 'active', '2024-03-10', 'Mandiri'),

('Emotion Recognition dari Facial Expression', 
'Riset pengenalan emosi berdasarkan ekspresi wajah menggunakan deep learning untuk aplikasi HCI.', 
'Riset Pendukung', 4, 'completed', '2023-06-01', 'Hibah Dikti 2023');

-- ========================================
-- 6. TABEL MEMBER_REGISTRATIONS
-- ========================================
-- Untuk menyimpan pendaftaran member baru (pending approval bertingkat)
CREATE TABLE IF NOT EXISTS member_registrations (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    nim VARCHAR(50),
    phone VARCHAR(20),
    angkatan VARCHAR(10),
    origin VARCHAR(255),
    password VARCHAR(255),  -- Password akan disimpan untuk nanti saat create user
    
    -- Penelitian
    research_title VARCHAR(255),
    research_id INTEGER REFERENCES research(id) ON DELETE SET NULL,
    
    -- Dosen Pengampu
    supervisor_id INTEGER REFERENCES users(id) ON DELETE SET NULL,
    supervisor_approved_at TIMESTAMP,
    supervisor_notes TEXT,
    
    -- Ketua Lab
    lab_head_approved_at TIMESTAMP,
    lab_head_notes TEXT,
    
    role_wanted VARCHAR(50) DEFAULT 'mahasiswa',
    motivation TEXT,
    status VARCHAR(50) DEFAULT 'pending_supervisor',  -- 'pending_supervisor', 'pending_lab_head', 'approved', 'rejected_supervisor', 'rejected_lab_head'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_registrations_status ON member_registrations(status);
CREATE INDEX idx_registrations_supervisor ON member_registrations(supervisor_id);

-- Insert sample data pendaftar (masih pending, belum jadi mahasiswa)
-- Password untuk semua pendaftar: admin123
INSERT INTO member_registrations (name, email, nim, phone, angkatan, origin, password, research_title, supervisor_id, motivation, status, supervisor_approved_at) VALUES
-- Pendaftar yang pilih Dr. Budi Santoso (user_id=3)
('Budi Santoso', 'budi.santoso@student.polinema.ac.id', '2141720020', '081234567890', '2024', 'TI 3A - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Pengenalan Emosi dengan Deep Learning', 3, 'Saya tertarik dengan computer vision dan ingin belajar lebih dalam tentang AI. Ingin mengembangkan skill di bidang emotion recognition untuk aplikasi HCI.', 'pending_supervisor', NULL),
('Yusuf Rahman', 'yusuf@student.polinema.ac.id', '2141720023', '081234567893', '2024', 'TI 3C - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Smart Parking System', 3, 'Ingin belajar machine learning dan AI untuk aplikasi real-world seperti smart parking system.', 'pending_supervisor', NULL),

-- Pendaftar yang pilih Dr. Andi Wijaya (user_id=4)
('Siti Aminah', 'siti.aminah@student.polinema.ac.id', '2141720021', '081234567891', '2024', 'TI 3B - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Object Detection untuk Smart City', 4, 'Ingin mengembangkan skill di bidang image processing dan computer vision. Tertarik dengan aplikasi AI untuk smart city.', 'pending_supervisor', NULL),
('Fitri Handayani', 'fitri@student.polinema.ac.id', '2141720024', '081234567894', '2024', 'TI 3B - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'IoT-based Smart Room Monitoring', 4, 'Tertarik dengan IoT dan smart systems. Ingin mengembangkan sistem monitoring yang efisien untuk gedung kampus.', 'pending_supervisor', NULL),

-- Pendaftar yang pilih Dr. Siti Nurhaliza (user_id=5)
('Rudi Hermawan', 'rudi@student.polinema.ac.id', '2141720025', '081234567895', '2024', 'TI 3A - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Natural Language Processing untuk Bahasa Indonesia', 5, 'Tertarik dengan NLP dan ingin berkontribusi dalam pengembangan aplikasi AI untuk bahasa Indonesia.', 'pending_supervisor', NULL),

-- Pendaftar yang sudah lolos approval dosen (untuk testing Ketua Lab)
('Andi Pratama', 'andi.pratama@student.polinema.ac.id', '2141720022', '081234567892', '2023', 'TI 3A - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Face Recognition dengan CNN', 3, 'Tertarik dengan riset face recognition dan ingin berkontribusi dalam pengembangan sistem keamanan berbasis AI.', 'pending_lab_head', CURRENT_TIMESTAMP);

-- ========================================
-- 7. TABEL NEWS
-- ========================================
-- Untuk menyimpan berita dan artikel lab
CREATE TABLE IF NOT EXISTS news (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    image VARCHAR(255),
    category VARCHAR(100),
    tags TEXT,
    author_id INTEGER REFERENCES users(id),
    status VARCHAR(50) DEFAULT 'draft',
    published_at TIMESTAMP,
    views INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_news_status ON news(status);
CREATE INDEX idx_news_slug ON news(slug);
CREATE INDEX idx_news_author ON news(author_id);

-- Insert sample data berita
INSERT INTO news (title, slug, content, excerpt, author_id, status, published_at, views) VALUES
('Workshop Computer Vision 2024', 'workshop-computer-vision-2024', 
'Lab IVSS mengadakan workshop computer vision dengan tema Deep Learning untuk mahasiswa semester 5-7. Workshop ini akan membahas teknik-teknik terkini dalam image processing dan object detection.', 
'Workshop computer vision dengan tema Deep Learning', 1, 'published', CURRENT_TIMESTAMP, 145),

('Publikasi Riset Face Recognition di Jurnal Internasional', 'publikasi-riset-face-recognition', 
'Tim riset Lab IVSS berhasil mempublikasikan paper tentang Face Recognition menggunakan CNN di jurnal internasional terindeks Scopus Q2.', 
'Paper face recognition berhasil dipublikasikan', 1, 'published', CURRENT_TIMESTAMP - INTERVAL '5 days', 89),

('Kerjasama dengan Industri untuk Smart Room System', 'kerjasama-industri-smart-room', 
'Lab IVSS menjalin kerjasama dengan PT. Smart Tech Indonesia untuk pengembangan sistem smart room menggunakan IoT dan computer vision.', 
'Kerjasama pengembangan smart room system', 1, 'published', CURRENT_TIMESTAMP - INTERVAL '10 days', 67),

('Program Magang di Lab IVSS Semester Genap 2024', 'program-magang-lab-ivss', 
'Dibuka kesempatan magang untuk mahasiswa yang ingin belajar dan berkontribusi dalam riset computer vision dan smart systems di Lab IVSS.', 
'Program magang semester genap 2024', 1, 'published', CURRENT_TIMESTAMP - INTERVAL '15 days', 123),

('Pengembangan Sistem Absensi dengan Face Recognition', 'sistem-absensi-face-recognition', 
'Lab IVSS sedang mengembangkan sistem absensi otomatis menggunakan teknologi face recognition untuk kampus Politeknik Negeri Malang.', 
'Pengembangan sistem absensi pintar', 1, 'draft', NULL, 0);

-- ========================================
-- 8. TABEL EQUIPMENT
-- ========================================
-- Untuk menyimpan inventaris peralatan lab
CREATE TABLE IF NOT EXISTS equipment (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    brand VARCHAR(100),
    image VARCHAR(255),
    quantity INTEGER DEFAULT 1,
    condition VARCHAR(50) DEFAULT 'baik',
    purchase_year INTEGER,
    location VARCHAR(255),
    specifications TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_equipment_category ON equipment(category);
CREATE INDEX idx_equipment_condition ON equipment(condition);

-- Insert sample data peralatan
INSERT INTO equipment (name, category, brand, quantity, condition, purchase_year, location, specifications, notes) VALUES
('Arduino Uno R3', 'Hardware', 'Arduino', 15, 'baik', 2023, 'Rak A3', 'Microcontroller ATmega328P, 14 Digital I/O, 6 Analog Input', 'Untuk prototyping IoT'),
('Camera Canon EOS M50', 'Hardware', 'Canon', 1, 'maintenance', 2024, 'Service Center', 'Mirrorless 24.1MP, DIGIC 8, 4K Video', 'Service rutin sensor cleaning'),
('Camera Logitech C920', 'Hardware', 'Logitech', 5, 'baik', 2023, 'Rak A1', 'HD Pro Webcam 1080p, Autofocus, Dual Stereo Mics', 'Untuk riset face recognition'),
('ESP32 DevKit', 'Hardware', 'Espressif', 12, 'baik', 2024, 'Rak A3', 'WiFi + Bluetooth, Dual-core 240MHz, 520KB SRAM', 'IoT development'),
('GPU NVIDIA RTX 3080', 'Hardware', 'NVIDIA', 2, 'baik', 2024, 'Server Room', 'RTX 3080 10GB GDDR6X, 8704 CUDA Cores, 320-bit', 'Training model AI dan deep learning'),
('Laptop Dell Precision', 'Hardware', 'Dell', 3, 'baik', 2024, 'Meja Lab', 'Precision 5540, i7-9850H, 32GB RAM, Quadro T2000', 'Deep learning workstation'),
('LED Ring Light', 'Aksesoris', 'Godox', 3, 'baik', 2023, 'Lemari Storage', 'LR180 18" Ring Light, Dimmable 3200K-5600K', 'Lighting untuk capture'),
('MATLAB R2023', 'Software', 'MathWorks', 5, 'baik', 2023, 'Komputer Lab', 'R2023b License untuk 5 concurrent users', 'Signal & image processing'),
('OpenCV Library', 'Software', 'OpenCV', 1, 'baik', 2023, 'Server', 'Version 4.8.0 Computer Vision Library', 'Open source CV framework'),
('Python Deep Learning', 'Software', 'PyTorch', 1, 'baik', 2024, 'Server', 'PyTorch v2.0 with CUDA Support', 'Framework deep learning'),
('Raspberry Pi 4 Model B', 'Hardware', 'Raspberry Pi', 10, 'baik', 2023, 'Rak A2', '4B 8GB RAM, Quad-core ARM Cortex-A72, WiFi & Bluetooth', 'IoT dan edge computing'),
('Sensor HC-SR04', 'Hardware', 'Generic', 20, 'baik', 2023, 'Laci B1', 'Ultrasonic Sensor, Range 2cm-400cm', 'Sensor jarak ultrasonik'),
('Tripod Manfrotto', 'Aksesoris', 'Manfrotto', 4, 'baik', 2023, 'Lemari Storage', 'MT190X Professional Tripod, Max Height 146cm', 'Camera mounting'),
('Webcam 4K Logitech BRIO', 'Hardware', 'Logitech', 3, 'baik', 2024, 'Rak A1', 'BRIO 4K Ultra HD, HDR, Auto Light Correction', 'High resolution capture');

-- ========================================
-- 9. TABEL SYSTEM_SETTINGS
-- ========================================
-- Untuk menyimpan konfigurasi sistem lab
CREATE TABLE IF NOT EXISTS system_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type VARCHAR(50) DEFAULT 'string',
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INTEGER REFERENCES users(id)
);

-- Index
CREATE INDEX idx_system_settings_key ON system_settings(setting_key);

-- Insert default system settings
INSERT INTO system_settings (setting_key, setting_value, setting_type, description) VALUES
('site_name', 'Lab IVSS - Politeknik Negeri Malang', 'string', 'Nama website/lab'),
('site_description', 'Image & Vision System Smart Laboratory', 'string', 'Deskripsi lab'),
('contact_email', 'ivss@polinema.ac.id', 'email', 'Email kontak lab'),
('contact_phone', '(0341) 404424', 'string', 'Nomor telepon lab'),
('allow_registration', 'true', 'boolean', 'Ijinkan pendaftaran member baru'),
('max_upload_size', '2', 'number', 'Maksimal ukuran upload file (MB)')
ON CONFLICT (setting_key) DO NOTHING;

-- ========================================
-- 10. TABEL PUBLICATIONS
-- ========================================
-- Untuk menyimpan data publikasi/paper/penelitian
CREATE TABLE IF NOT EXISTS publications (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    authors TEXT NOT NULL,
    year INTEGER NOT NULL,
    journal VARCHAR(255),
    conference VARCHAR(255),
    doi VARCHAR(255),
    url VARCHAR(255),
    abstract TEXT,
    citations INTEGER DEFAULT 0,
    keywords TEXT,
    type VARCHAR(50) DEFAULT 'journal',  -- 'journal', 'conference', 'book', 'thesis'
    status VARCHAR(50) DEFAULT 'published',  -- 'published', 'accepted', 'submitted'
    featured BOOLEAN DEFAULT FALSE,  -- untuk ditampilkan di home page
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_publications_year ON publications(year DESC);
CREATE INDEX idx_publications_featured ON publications(featured);
CREATE INDEX idx_publications_type ON publications(type);

-- Insert sample data publikasi
INSERT INTO publications (title, authors, year, journal, doi, abstract, citations, keywords, type, status, featured) VALUES
('Pemanfaatan Wireshark untuk Sniffing Komunikasi MQTT pada Sistem IoT', 
'Dr. Ulla Delfana Rosiani, Ahmad Fauzi, Rina Kartika', 
2021, 
'Jurnal Teknologi Informasi dan Ilmu Komputer (JTIIK)', 
'10.25126/jtiik.2021xxxx',
'Penelitian tentang analisis keamanan protokol MQTT dalam sistem IoT menggunakan Wireshark untuk monitoring dan analisis paket data komunikasi antar device IoT.',
10,
'IoT, MQTT, Network Security, Wireshark',
'journal',
'published',
TRUE),

('Klasifikasi Jenis Kelamin Dari Citra Wajah Menggunakan Metode Naive Bayes', 
'Mamluatul Hani''ah, Budi Santoso, Siti Nurhaliza', 
2020, 
'Jurnal Pengembangan Teknologi Informasi dan Ilmu Komputer', 
'10.25126/jptiik.2020xxxx',
'Menggunakan metode Naive Bayes untuk klasifikasi gender berbasis Computer Vision dengan akurasi mencapai 92% pada dataset testing.',
30,
'Computer Vision, Gender Classification, Naive Bayes, Machine Learning',
'journal',
'published',
TRUE),

('Sistem Pengambil Keputusan Rekomendasi Lokasi Wisata Menggunakan Metode MOORA', 
'Mungki Astiningrum, Dedi Kurniawan, Ahmad Fauzi', 
2021, 
'Jurnal Sistem Informasi Bisnis', 
'10.25126/jsib.2021xxxx',
'Implementasi metode MOORA untuk sistem rekomendasi destinasi wisata Malang Raya berdasarkan multiple criteria decision making.',
26,
'Decision Support System, MOORA, Tourism, Recommendation System',
'journal',
'published',
TRUE),

('Deep Learning untuk Face Recognition pada Sistem Absensi Kampus', 
'Prof. Dr. Eng. Rosa Andrie Asmara, Ahmad Fauzi, Rina Kartika', 
2023, 
'IEEE Transactions on Pattern Analysis and Machine Intelligence', 
'10.1109/TPAMI.2023.xxxx',
'Implementasi CNN (Convolutional Neural Network) untuk sistem face recognition pada aplikasi absensi kampus dengan tingkat akurasi 97.5%.',
45,
'Deep Learning, Face Recognition, CNN, Attendance System',
'journal',
'published',
TRUE),

('Object Detection menggunakan YOLO untuk Smart Surveillance', 
'Dr. Ulla Delfana Rosiani, Budi Santoso', 
2023, 
NULL,
NULL,
'Pengembangan sistem deteksi objek real-time menggunakan YOLOv8 untuk aplikasi surveillance pintar di lingkungan kampus.',
15,
'Object Detection, YOLO, Computer Vision, Surveillance',
'conference',
'published',
TRUE),

('Micro-Expression Recognition untuk Analisis Emosi', 
'Mamluatul Hani''ah, Siti Nurhaliza', 
2024, 
'Pattern Recognition Letters', 
'10.1016/j.patrec.2024.xxxx',
'Riset pengenalan ekspresi mikro pada wajah manusia menggunakan deep learning untuk aplikasi analisis emosi dan lie detection.',
5,
'Emotion Recognition, Micro-Expression, Deep Learning, Facial Analysis',
'journal',
'published',
FALSE),

('Hand Gesture Recognition untuk Human-Computer Interaction', 
'Mungki Astiningrum, Dedi Kurniawan', 
2024, 
NULL,
NULL,
'Sistem pengenalan gesture tangan untuk kontrol perangkat tanpa sentuhan menggunakan computer vision dan machine learning.',
8,
'Gesture Recognition, HCI, Computer Vision, Contactless Control',
'conference',
'accepted',
FALSE),

('Human Pose Estimation untuk Monitoring Aktivitas Fisik', 
'Prof. Dr. Eng. Rosa Andrie Asmara, Ahmad Fauzi', 
2023, 
'Jurnal Teknologi dan Sistem Komputer', 
'10.14710/jtsiskom.2023.xxxx',
'Riset estimasi pose manusia untuk aplikasi monitoring aktivitas fisik dan deteksi fall detection pada lansia menggunakan MediaPipe.',
18,
'Pose Estimation, Activity Monitoring, Fall Detection, MediaPipe',
'journal',
'published',
FALSE);

-- ========================================
-- 11. TABEL NOTIFICATIONS
-- ========================================
-- Untuk menyimpan notifikasi yang ditargetkan ke role atau user tertentu
CREATE TABLE IF NOT EXISTS notifications (
    id SERIAL PRIMARY KEY,
    target_role VARCHAR(20) NOT NULL,           -- 'admin', 'ketua_lab', 'dosen', 'mahasiswa', 'all'
    target_user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,  -- NULL = untuk semua di role, INT = spesifik user
    title VARCHAR(255) NOT NULL,
    message TEXT,
    type VARCHAR(50) NOT NULL,                  -- 'pendaftar', 'approval', 'system', 'riset', 'meeting', 'deadline'
    reference_type VARCHAR(50),                 -- 'registration', 'research', 'publication', 'user'
    reference_id INTEGER,                       -- ID dari tabel lain
    icon VARCHAR(50) DEFAULT 'bell',            -- 'bell', 'user', 'check', 'alert', 'calendar'
    priority VARCHAR(20) DEFAULT 'normal',      -- 'low', 'normal', 'high', 'urgent'
    is_read BOOLEAN DEFAULT false,
    read_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP                        -- Notifikasi bisa auto-expire
);

-- Index untuk performa
CREATE INDEX idx_notifications_target_role ON notifications(target_role);
CREATE INDEX idx_notifications_target_user ON notifications(target_user_id);
CREATE INDEX idx_notifications_is_read ON notifications(is_read);
CREATE INDEX idx_notifications_created ON notifications(created_at DESC);

-- Insert sample notifications untuk testing
INSERT INTO notifications (target_role, target_user_id, title, message, type, reference_type, reference_id, icon, priority, is_read) VALUES

-- Notifikasi untuk Admin
('admin', NULL, 'Sistem Berhasil Diinstal', 'Database Lab IVSS telah berhasil disetup dengan struktur yang baru. Semua tabel dan data sample telah dibuat.', 'system', NULL, NULL, 'check', 'high', false),
('admin', 1, 'Backup Database Scheduled', 'Backup database otomatis akan dilakukan setiap hari pukul 02:00 WIB.', 'system', NULL, NULL, 'alert', 'normal', false),

-- Notifikasi untuk Ketua Lab
('ketua_lab', NULL, 'Pendaftar Menunggu Approval', '1 pendaftar baru telah disetujui oleh dosen dan menunggu approval final dari Anda.', 'approval', 'registration', 6, 'user', 'high', false),
('ketua_lab', 2, 'Laporan Bulanan Ready', 'Laporan aktivitas lab bulan ini sudah siap untuk direview.', 'system', NULL, NULL, 'calendar', 'normal', false),
('ketua_lab', NULL, 'Riset Baru Dimulai', 'Dr. Budi Santoso telah memulai riset baru: Face Recognition dengan Deep Learning', 'riset', 'research', 1, 'bell', 'normal', false),

-- Notifikasi untuk Dosen (Dr. Budi - id=3)
('dosen', 3, 'Pendaftar Baru Memilih Anda', 'Budi Santoso telah mendaftar dan memilih Anda sebagai dosen pembimbing untuk riset Pengenalan Emosi dengan Deep Learning.', 'pendaftar', 'registration', 1, 'user', 'high', false),
('dosen', 3, 'Pendaftar Baru Memilih Anda', 'Yusuf Rahman telah mendaftar dan memilih Anda sebagai dosen pembimbing untuk riset Smart Parking System.', 'pendaftar', 'registration', 2, 'user', 'high', false),
('dosen', 3, 'Deadline Riset Mendekat', 'Riset Face Recognition dengan Deep Learning akan berakhir dalam 30 hari.', 'deadline', 'research', 1, 'alert', 'normal', false),

-- Notifikasi untuk Dosen (Dr. Andi - id=4)
('dosen', 4, 'Pendaftar Baru Memilih Anda', 'Siti Aminah telah mendaftar dan memilih Anda sebagai dosen pembimbing untuk riset Object Detection untuk Smart City.', 'pendaftar', 'registration', 3, 'user', 'high', false),
('dosen', 4, 'Pendaftar Baru Memilih Anda', 'Fitri Handayani telah mendaftar dan memilih Anda sebagai dosen pembimbing untuk riset IoT-based Smart Room Monitoring.', 'pendaftar', 'registration', 4, 'user', 'high', false),
('dosen', 4, 'Request Meeting', 'Mahasiswa bimbingan meminta jadwal meeting untuk diskusi progress riset minggu ini.', 'meeting', NULL, NULL, 'calendar', 'normal', false),

-- Notifikasi untuk Dosen (Dr. Siti - id=5)
('dosen', 5, 'Pendaftar Baru Memilih Anda', 'Rudi Hermawan telah mendaftar dan memilih Anda sebagai dosen pembimbing untuk riset Natural Language Processing untuk Bahasa Indonesia.', 'pendaftar', 'registration', 5, 'user', 'high', false),
('dosen', 5, 'Riset Update Required', 'Progress riset NLP untuk Bahasa Indonesia perlu diupdate. Sudah 2 minggu tidak ada update.', 'riset', 'research', 3, 'alert', 'normal', false),

-- Notifikasi umum untuk semua dosen
('dosen', NULL, 'Rapat Dosen Lab IVSS', 'Rapat koordinasi dosen Lab IVSS akan dilaksanakan Jumat, 15 November 2024 pukul 13:00 WIB di Ruang Lab.', 'meeting', NULL, NULL, 'calendar', 'normal', false);

-- ========================================
-- 12. TABEL RESEARCH_MEMBERS
-- ========================================
-- Untuk relasi many-to-many antara mahasiswa dan research
CREATE TABLE IF NOT EXISTS research_members (
    id SERIAL PRIMARY KEY,
    research_id INTEGER NOT NULL REFERENCES research(id) ON DELETE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    role VARCHAR(50) DEFAULT 'member',  -- 'leader', 'member', 'contributor'
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'active',  -- 'active', 'inactive', 'completed'
    UNIQUE(research_id, user_id)
);

-- Index
CREATE INDEX idx_research_members_research ON research_members(research_id);
CREATE INDEX idx_research_members_user ON research_members(user_id);
CREATE INDEX idx_research_members_status ON research_members(status);

-- Insert sample data: relasi mahasiswa dengan research
INSERT INTO research_members (research_id, user_id, role, status) VALUES
-- Ahmad Fauzi (user_id=6) ikut 4 riset
(1, 6, 'member', 'active'),       -- Face Recognition dengan Deep Learning
(2, 6, 'contributor', 'active'),  -- Object Detection untuk Smart Surveillance
(3, 6, 'contributor', 'active'),  -- NLP untuk Bahasa Indonesia
(4, 6, 'member', 'active');       -- IoT-based Smart Room Monitoring

-- ========================================
-- 13. TABEL RESEARCH_DOCUMENTS
-- ========================================
-- Untuk upload dokumen/laporan riset oleh mahasiswa
CREATE TABLE IF NOT EXISTS research_documents (
    id SERIAL PRIMARY KEY,
    research_id INTEGER NOT NULL REFERENCES research(id) ON DELETE CASCADE,
    uploaded_by INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_size BIGINT,  -- in bytes
    file_type VARCHAR(50),  -- 'pdf', 'docx', 'xlsx', etc
    document_type VARCHAR(50) DEFAULT 'report',  -- 'proposal', 'report', 'presentation', 'data', 'other'
    version VARCHAR(20) DEFAULT '1.0',
    status VARCHAR(50) DEFAULT 'submitted',  -- 'draft', 'submitted', 'approved', 'rejected'
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_documents_research ON research_documents(research_id);
CREATE INDEX idx_documents_uploader ON research_documents(uploaded_by);
CREATE INDEX idx_documents_type ON research_documents(document_type);
CREATE INDEX idx_documents_status ON research_documents(status);

-- Insert sample data: dokumen yang sudah diupload
INSERT INTO research_documents (research_id, uploaded_by, title, description, file_name, file_path, file_size, file_type, document_type, status) VALUES
-- Dokumen untuk riset Face Recognition (id=1)
(1, 6, 'Proposal Penelitian - Face Recognition', 'Proposal lengkap penelitian face recognition dengan CNN', 'proposal_face_recognition.pdf', '/uploads/documents/proposal_face_recognition.pdf', 2457600, 'pdf', 'proposal', 'approved'),
(1, 6, 'Laporan Progress Bulan 1', 'Progress penelitian bulan pertama', 'progress_month_1.pdf', '/uploads/documents/progress_month_1.pdf', 1843200, 'pdf', 'report', 'approved'),
(1, 6, 'Dataset Training Model', 'Dataset wajah untuk training CNN model', 'dataset_faces.zip', '/uploads/documents/dataset_faces.zip', 52428800, 'zip', 'data', 'approved'),

-- Dokumen untuk riset IoT (id=4)
(4, 6, 'Proposal IoT Smart Room', 'Proposal sistem monitoring ruangan pintar', 'proposal_iot_smart_room.pdf', '/uploads/documents/proposal_iot_smart_room.pdf', 1920000, 'pdf', 'proposal', 'approved'),
(4, 6, 'Presentasi Desain Sistem', 'Slide presentasi desain sistem IoT', 'presentasi_design.pptx', '/uploads/documents/presentasi_design.pptx', 3145728, 'pptx', 'presentation', 'approved');

-- ========================================
-- 14. TABEL MEMBER_PUBLICATIONS
-- ========================================
-- Untuk publikasi personal mahasiswa (paper/jurnal yang mereka tulis)
CREATE TABLE IF NOT EXISTS member_publications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    authors TEXT NOT NULL,
    year INTEGER NOT NULL,
    journal VARCHAR(255),
    conference VARCHAR(255),
    doi VARCHAR(255),
    url VARCHAR(255),
    abstract TEXT,
    citation_count INTEGER DEFAULT 0,
    keywords TEXT,
    publication_type VARCHAR(50) DEFAULT 'journal',  -- 'journal', 'conference', 'book_chapter', 'thesis'
    status VARCHAR(50) DEFAULT 'draft',  -- 'draft', 'submitted', 'under_review', 'published'
    file_path VARCHAR(255),
    research_id INTEGER REFERENCES research(id) ON DELETE SET NULL,  -- link ke riset jika ada
    published_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_member_pubs_user ON member_publications(user_id);
CREATE INDEX idx_member_pubs_year ON member_publications(year DESC);
CREATE INDEX idx_member_pubs_status ON member_publications(status);
CREATE INDEX idx_member_pubs_type ON member_publications(publication_type);

-- Insert sample data: publikasi personal mahasiswa
INSERT INTO member_publications (user_id, title, authors, year, journal, doi, citation_count, keywords, publication_type, status, research_id, published_date) VALUES
-- Publikasi Ahmad Fauzi (user_id=6)
(6, 'Deep Learning for Face Recognition: A Comprehensive Study', 
'Ahmad Fauzi, Dr. Budi Santoso, Siti Aminah', 
2024, 
'IEEE Transactions on Pattern Analysis and Machine Intelligence', 
'10.1109/TPAMI.2024.1234567',
15,
'Deep Learning, Face Recognition, CNN, Computer Vision',
'journal',
'published',
1,  -- linked to research Face Recognition
'2024-03-15'),

(6, 'Optimization Techniques in Neural Networks for Real-time Applications', 
'Ahmad Fauzi, Budi Santoso', 
2024, 
'Journal of Machine Learning Research', 
NULL,
0,
'Neural Networks, Optimization, Real-time Processing',
'journal',
'draft',
1,
NULL),

(6, 'IoT-based Smart Room Monitoring System using Computer Vision', 
'Ahmad Fauzi, Dr. Budi Santoso', 
2024, 
NULL,
NULL,
3,
'IoT, Smart Room, Computer Vision, Energy Efficiency',
'conference',
'published',
4,  -- linked to research IoT
'2024-05-20');

-- ========================================
-- FUNCTIONS & STORED PROCEDURES
-- ========================================

-- ========================================
-- TRIGGERS: Auto Update Timestamp
-- ========================================

-- Function untuk auto update timestamp
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger untuk tabel users
CREATE TRIGGER trigger_users_updated_at
    BEFORE UPDATE ON users
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- Trigger untuk tabel dosen
CREATE TRIGGER trigger_dosen_updated_at
    BEFORE UPDATE ON dosen
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- Trigger untuk tabel mahasiswa
CREATE TRIGGER trigger_mahasiswa_updated_at
    BEFORE UPDATE ON mahasiswa
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- Trigger untuk tabel research
CREATE TRIGGER trigger_research_updated_at
    BEFORE UPDATE ON research
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- Trigger untuk tabel news
CREATE TRIGGER trigger_news_updated_at
    BEFORE UPDATE ON news
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- ========================================
-- FUNCTIONS: Helper Functions
-- ========================================

-- Function: Get user info lengkap (dengan role name)
CREATE OR REPLACE FUNCTION get_user_details(p_user_id INTEGER)
RETURNS TABLE (
    user_id INTEGER,
    username VARCHAR,
    email VARCHAR,
    role_name VARCHAR,
    status VARCHAR,
    photo VARCHAR,
    bio TEXT,
    created_at TIMESTAMP,
    last_login TIMESTAMP
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id,
        u.username,
        u.email,
        r.role_name,
        u.status,
        u.photo,
        u.bio,
        u.created_at,
        u.last_login
    FROM users u
    JOIN roles r ON u.role_id = r.id
    WHERE u.id = p_user_id;
END;
$$ LANGUAGE plpgsql;

-- Function: Get info lengkap dosen
CREATE OR REPLACE FUNCTION get_dosen_details(p_user_id INTEGER)
RETURNS TABLE (
    user_id INTEGER,
    username VARCHAR,
    email VARCHAR,
    dosen_id INTEGER,
    nip VARCHAR,
    nama VARCHAR,
    origin VARCHAR,
    no_hp VARCHAR,
    status VARCHAR
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id,
        u.username,
        u.email,
        d.id,
        d.nip,
        d.nama,
        d.origin,
        d.no_hp,
        u.status
    FROM users u
    JOIN dosen d ON u.id = d.user_id
    WHERE u.id = p_user_id;
END;
$$ LANGUAGE plpgsql;

-- Function: Get info lengkap mahasiswa
CREATE OR REPLACE FUNCTION get_mahasiswa_details(p_user_id INTEGER)
RETURNS TABLE (
    user_id INTEGER,
    username VARCHAR,
    email VARCHAR,
    mahasiswa_id INTEGER,
    nim VARCHAR,
    nama VARCHAR,
    angkatan VARCHAR,
    research_title VARCHAR,
    no_phone VARCHAR,
    supervisor_id INTEGER,
    supervisor_nama VARCHAR,
    status VARCHAR
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id,
        u.username,
        u.email,
        m.id,
        m.nim,
        m.nama,
        m.angkatan,
        m.research_title,
        m.no_phone,
        m.supervisor_id,
        d.nama,
        u.status
    FROM users u
    JOIN mahasiswa m ON u.id = m.user_id
    LEFT JOIN dosen d ON m.supervisor_id = d.id
    WHERE u.id = p_user_id;
END;
$$ LANGUAGE plpgsql;

-- Function: Count mahasiswa per dosen
CREATE OR REPLACE FUNCTION count_mahasiswa_by_dosen(p_dosen_id INTEGER)
RETURNS INTEGER AS $$
DECLARE
    total_mahasiswa INTEGER;
BEGIN
    SELECT COUNT(*) INTO total_mahasiswa
    FROM mahasiswa
    WHERE supervisor_id = p_dosen_id;
    
    RETURN total_mahasiswa;
END;
$$ LANGUAGE plpgsql;

-- Function: Get research members
CREATE OR REPLACE FUNCTION get_research_members(p_research_id INTEGER)
RETURNS TABLE (
    user_id INTEGER,
    username VARCHAR,
    nama VARCHAR,
    role_member VARCHAR,
    status VARCHAR
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        u.id,
        u.username,
        COALESCE(m.nama, d.nama) as nama,
        rm.role,
        rm.status
    FROM research_members rm
    JOIN users u ON rm.user_id = u.id
    LEFT JOIN mahasiswa m ON u.id = m.user_id
    LEFT JOIN dosen d ON u.id = d.user_id
    WHERE rm.research_id = p_research_id
    ORDER BY rm.joined_at;
END;
$$ LANGUAGE plpgsql;

-- Function: Get pending registrations by supervisor
CREATE OR REPLACE FUNCTION get_pending_registrations_by_supervisor(p_supervisor_user_id INTEGER)
RETURNS TABLE (
    registration_id INTEGER,
    nama VARCHAR,
    email VARCHAR,
    nim VARCHAR,
    research_title VARCHAR,
    motivation TEXT,
    created_at TIMESTAMP
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        mr.id,
        mr.name,
        mr.email,
        mr.nim,
        mr.research_title,
        mr.motivation,
        mr.created_at
    FROM member_registrations mr
    WHERE mr.supervisor_id = p_supervisor_user_id
    AND mr.status = 'pending_supervisor'
    ORDER BY mr.created_at DESC;
END;
$$ LANGUAGE plpgsql;

-- ========================================
-- STORED PROCEDURES: Business Logic
-- ========================================

-- Procedure: Update last login
CREATE OR REPLACE PROCEDURE update_last_login(p_user_id INTEGER)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE users
    SET last_login = CURRENT_TIMESTAMP
    WHERE id = p_user_id;
END;
$$;

-- Procedure: Approve registration by supervisor
CREATE OR REPLACE PROCEDURE approve_registration_supervisor(
    p_registration_id INTEGER,
    p_notes TEXT DEFAULT NULL
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE member_registrations
    SET 
        status = 'pending_lab_head',
        supervisor_approved_at = CURRENT_TIMESTAMP,
        supervisor_notes = p_notes,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_registration_id
    AND status = 'pending_supervisor';
    
    -- Log notification untuk ketua lab
    INSERT INTO notifications (target_role, title, message, type, reference_type, reference_id, priority)
    SELECT 
        'ketua_lab',
        'Pendaftar Baru Menunggu Approval',
        CONCAT('Pendaftar ', name, ' telah disetujui oleh dosen dan menunggu approval Anda.'),
        'approval',
        'registration',
        id,
        'high'
    FROM member_registrations
    WHERE id = p_registration_id;
END;
$$;

-- Procedure: Reject registration by supervisor
CREATE OR REPLACE PROCEDURE reject_registration_supervisor(
    p_registration_id INTEGER,
    p_notes TEXT
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE member_registrations
    SET 
        status = 'rejected_supervisor',
        supervisor_notes = p_notes,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_registration_id
    AND status = 'pending_supervisor';
END;
$$;

-- Procedure: Approve registration by lab head (create user + mahasiswa)
CREATE OR REPLACE PROCEDURE approve_registration_lab_head(
    p_registration_id INTEGER,
    p_notes TEXT DEFAULT NULL
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_user_id INTEGER;
    v_dosen_id INTEGER;
    v_registration RECORD;
BEGIN
    -- Get registration data
    SELECT * INTO v_registration
    FROM member_registrations
    WHERE id = p_registration_id
    AND status = 'pending_lab_head';
    
    IF NOT FOUND THEN
        RAISE EXCEPTION 'Registration not found or not in pending_lab_head status';
    END IF;
    
    -- Get dosen_id from supervisor_id
    SELECT d.id INTO v_dosen_id
    FROM dosen d
    WHERE d.user_id = v_registration.supervisor_id;
    
    -- Create user
    INSERT INTO users (username, email, password, role_id, status)
    VALUES (
        LOWER(REPLACE(v_registration.name, ' ', '_')),
        v_registration.email,
        v_registration.password,
        4, -- role_id untuk mahasiswa
        'active'
    )
    RETURNING id INTO v_user_id;
    
    -- Create mahasiswa
    INSERT INTO mahasiswa (user_id, nim, nama, angkatan, research_title, no_phone, supervisor_id)
    VALUES (
        v_user_id,
        v_registration.nim,
        v_registration.name,
        v_registration.angkatan,
        v_registration.research_title,
        v_registration.phone,
        v_dosen_id
    );
    
    -- Update registration status
    UPDATE member_registrations
    SET 
        status = 'approved',
        lab_head_approved_at = CURRENT_TIMESTAMP,
        lab_head_notes = p_notes,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_registration_id;
    
    -- Notify dosen
    INSERT INTO notifications (target_user_id, target_role, title, message, type, priority)
    VALUES (
        v_registration.supervisor_id,
        'dosen',
        'Mahasiswa Bimbingan Baru',
        CONCAT('Mahasiswa baru ', v_registration.name, ' telah disetujui dan menjadi mahasiswa bimbingan Anda.'),
        'approval',
        'normal'
    );
END;
$$;

-- Procedure: Reject registration by lab head
CREATE OR REPLACE PROCEDURE reject_registration_lab_head(
    p_registration_id INTEGER,
    p_notes TEXT
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE member_registrations
    SET 
        status = 'rejected_lab_head',
        lab_head_notes = p_notes,
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_registration_id
    AND status = 'pending_lab_head';
END;
$$;

-- Procedure: Add member to research
CREATE OR REPLACE PROCEDURE add_member_to_research(
    p_research_id INTEGER,
    p_user_id INTEGER,
    p_role VARCHAR DEFAULT 'member'
)
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO research_members (research_id, user_id, role, status)
    VALUES (p_research_id, p_user_id, p_role, 'active')
    ON CONFLICT (research_id, user_id) DO NOTHING;
END;
$$;

-- Procedure: Remove member from research
CREATE OR REPLACE PROCEDURE remove_member_from_research(
    p_research_id INTEGER,
    p_user_id INTEGER
)
LANGUAGE plpgsql
AS $$
BEGIN
    DELETE FROM research_members
    WHERE research_id = p_research_id
    AND user_id = p_user_id;
END;
$$;

-- Procedure: Mark notification as read
CREATE OR REPLACE PROCEDURE mark_notification_read(p_notification_id INTEGER)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE notifications
    SET 
        is_read = TRUE,
        read_at = CURRENT_TIMESTAMP
    WHERE id = p_notification_id;
END;
$$;

-- Procedure: Mark all notifications as read for user
CREATE OR REPLACE PROCEDURE mark_all_notifications_read(p_user_id INTEGER)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE notifications
    SET 
        is_read = TRUE,
        read_at = CURRENT_TIMESTAMP
    WHERE target_user_id = p_user_id
    AND is_read = FALSE;
END;
$$;

-- Procedure: Clean expired notifications
CREATE OR REPLACE PROCEDURE clean_expired_notifications()
LANGUAGE plpgsql
AS $$
BEGIN
    DELETE FROM notifications
    WHERE expires_at IS NOT NULL
    AND expires_at < CURRENT_TIMESTAMP;
END;
$$;

-- Procedure: Update equipment condition
CREATE OR REPLACE PROCEDURE update_equipment_condition(
    p_equipment_id INTEGER,
    p_condition VARCHAR,
    p_notes TEXT DEFAULT NULL
)
LANGUAGE plpgsql
AS $$
BEGIN
    UPDATE equipment
    SET 
        condition = p_condition,
        notes = COALESCE(p_notes, notes),
        updated_at = CURRENT_TIMESTAMP
    WHERE id = p_equipment_id;
END;
$$;

-- ========================================
-- UTILITY FUNCTIONS: Statistics & Reports
-- ========================================

-- Function: Get total active users by role
CREATE OR REPLACE FUNCTION get_active_users_by_role()
RETURNS TABLE (
    role_name VARCHAR,
    total_users BIGINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        r.role_name,
        COUNT(u.id)
    FROM roles r
    LEFT JOIN users u ON r.id = u.role_id AND u.status = 'active'
    GROUP BY r.role_name
    ORDER BY r.id;
END;
$$ LANGUAGE plpgsql;

-- Function: Get research statistics
CREATE OR REPLACE FUNCTION get_research_statistics()
RETURNS TABLE (
    total_research BIGINT,
    active_research BIGINT,
    completed_research BIGINT,
    total_members BIGINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        COUNT(*),
        COUNT(*) FILTER (WHERE status = 'active'),
        COUNT(*) FILTER (WHERE status = 'completed'),
        (SELECT COUNT(*) FROM research_members WHERE status = 'active')
    FROM research;
END;
$$ LANGUAGE plpgsql;

-- Function: Get pending registrations count
CREATE OR REPLACE FUNCTION get_pending_registrations_count()
RETURNS TABLE (
    pending_supervisor BIGINT,
    pending_lab_head BIGINT,
    total_pending BIGINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        COUNT(*) FILTER (WHERE status = 'pending_supervisor'),
        COUNT(*) FILTER (WHERE status = 'pending_lab_head'),
        COUNT(*) FILTER (WHERE status IN ('pending_supervisor', 'pending_lab_head'))
    FROM member_registrations;
END;
$$ LANGUAGE plpgsql;

-- Function: Get dosen performance
CREATE OR REPLACE FUNCTION get_dosen_performance()
RETURNS TABLE (
    dosen_id INTEGER,
    nama VARCHAR,
    jumlah_mahasiswa BIGINT,
    jumlah_research BIGINT,
    jumlah_publikasi BIGINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        d.id,
        d.nama,
        COUNT(DISTINCT m.id) as jumlah_mahasiswa,
        COUNT(DISTINCT r.id) as jumlah_research,
        COUNT(DISTINCT p.id) as jumlah_publikasi
    FROM dosen d
    LEFT JOIN mahasiswa m ON m.supervisor_id = d.id AND m.user_id IN (SELECT id FROM users WHERE status = 'active')
    LEFT JOIN research r ON r.leader_id = d.user_id AND r.status = 'active'
    LEFT JOIN member_publications p ON p.user_id IN (SELECT m2.user_id FROM mahasiswa m2 WHERE m2.supervisor_id = d.id)
    GROUP BY d.id, d.nama
    ORDER BY jumlah_mahasiswa DESC, jumlah_research DESC;
END;
$$ LANGUAGE plpgsql;

-- ========================================
-- VIEWS: Unified Data Views
-- ========================================

-- View: Unified Publications (Lab + Member)
CREATE OR REPLACE VIEW all_publications_view AS
SELECT 
    id,
    title,
    authors,
    year,
    journal,
    conference,
    doi,
    url,
    abstract,
    citations,
    keywords,
    type,
    status,
    featured,
    created_at,
    'lab' as source,
    NULL::INTEGER as user_id
FROM publications
WHERE status = 'published'

UNION ALL

SELECT 
    id,
    title,
    authors,
    year,
    journal,
    conference,
    doi,
    url,
    abstract,
    citation_count as citations,
    keywords,
    publication_type as type,
    status,
    FALSE as featured, -- Member publications default not featured unless logic added
    created_at,
    'member' as source,
    user_id
FROM member_publications
WHERE status = 'published';


-- ========================================
-- Selesai! Semua tabel, functions, dan procedures berhasil dibuat
-- ========================================
-- Total 14 tabel:
-- 1. roles (BARU)
-- 2. users (RESTRUCTURED)
-- 3. dosen (BARU)
-- 4. mahasiswa (BARU)
-- 5. research (OPTIMIZED - hapus team_members & publications)
-- 6. member_registrations
-- 7. news
-- 8. equipment
-- 9. system_settings
-- 10. publications
-- 11. notifications
-- 12. research_members
-- 13. research_documents
-- 14. member_publications
--
-- Total 6 Triggers (Auto Update Timestamp):
-- - users, dosen, mahasiswa, research, news
--
-- Total 11 Functions:
-- 1. get_user_details() - Get user info lengkap
-- 2. get_dosen_details() - Get dosen info lengkap
-- 3. get_mahasiswa_details() - Get mahasiswa info lengkap
-- 4. count_mahasiswa_by_dosen() - Hitung mahasiswa per dosen
-- 5. get_research_members() - Get members dari research
-- 6. get_pending_registrations_by_supervisor() - Get pendaftar pending per dosen
-- 7. get_active_users_by_role() - Statistik user aktif per role
-- 8. get_research_statistics() - Statistik research
-- 9. get_pending_registrations_count() - Hitung pendaftar pending
-- 10. get_dosen_performance() - Performance dosen
-- 11. update_updated_at_column() - Helper untuk trigger
--
-- Total 11 Stored Procedures:
-- 1. update_last_login() - Update last login user
-- 2. approve_registration_supervisor() - Approve pendaftar oleh dosen
-- 3. reject_registration_supervisor() - Reject pendaftar oleh dosen
-- 4. approve_registration_lab_head() - Approve & create user+mahasiswa
-- 5. reject_registration_lab_head() - Reject pendaftar oleh ketua lab
-- 6. add_member_to_research() - Tambah member ke research
-- 7. remove_member_from_research() - Hapus member dari research
-- 8. mark_notification_read() - Mark 1 notifikasi sebagai read
-- 9. mark_all_notifications_read() - Mark semua notifikasi user sebagai read
-- 10. clean_expired_notifications() - Hapus notifikasi expired
-- 11. update_equipment_condition() - Update kondisi peralatan
--
-- PERUBAHAN DARI VERSI LAMA:
-- ✅ Tabel users dipecah jadi users, dosen, dan mahasiswa
-- ✅ Tambah tabel roles untuk master data
-- ✅ Hapus kolom redundan: team_members dan publications dari research
-- ✅ Hapus kolom nim, nip, angkatan dari users (pindah ke tabel spesifik)
-- ✅ Hapus kolom origin, research_title, motivation dari users
-- ✅ Tambah kolom username di users
-- ✅ role diganti jadi role_id dengan FK ke tabel roles
-- ✅ supervisor_id di mahasiswa mengacu ke dosen(id)
-- ✅ Tambah 6 triggers untuk auto update timestamp
-- ✅ Tambah 11 functions untuk helper dan statistics
-- ✅ Tambah 11 stored procedures untuk business logic
--
-- PASSWORD SEMUA USER: admin123
--
-- DATA SAMPLE:
-- - 2 Users (Admin & Ketua Lab)
-- - 3 Dosen (Dr. Budi, Dr. Andi, Dr. Siti)
-- - 2 Mahasiswa (Ahmad aktif, Agus alumni)
-- - 6 Pendaftar (pending approval)
-- - 5 Riset
-- - 5 Berita
-- - 14 Peralatan
-- - 8 Publikasi lab
-- - 15 Notifikasi
-- - 4 Relasi research_members
-- - 5 Dokumen riset
-- - 3 Publikasi mahasiswa
-- ========================================

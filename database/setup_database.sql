-- ========================================
-- Lab IVSS Database Setup - Complete
-- Run this script in your SQL Editor
-- ========================================

-- 1. TABEL USERS
-- Untuk menyimpan data user (admin, ketua_lab, dosen, member)
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'member',  -- 'admin', 'ketua_lab', 'dosen', 'member'
    status VARCHAR(50) DEFAULT 'active',          -- 'pending', 'active', 'inactive', 'rejected'
    nim VARCHAR(50),
    nip VARCHAR(50),
    phone VARCHAR(20),
    angkatan VARCHAR(10),
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP
);

-- Index untuk performa
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);

-- Insert data user default (admin, ketua lab, dosen, member)
-- Password untuk semua user: admin123
INSERT INTO users (name, email, password, role, status, nim, angkatan) VALUES
-- Admin
('Admin IVSS', 'admin@ivss.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'admin', 'active', NULL, NULL),

-- Ketua Lab
('Dr. Muhammad Hasan', 'ketualab@ivss.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'ketua_lab', 'active', NULL, NULL),

-- Dosen
('Dr. Budi Santoso', 'budi.dosen@polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'dosen', 'active', NULL, NULL),
('Dr. Andi Wijaya', 'andi.dosen@polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'dosen', 'active', NULL, NULL),
('Dr. Siti Nurhaliza', 'siti.dosen@polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'dosen', 'active', NULL, NULL),

-- Member (sudah approved, bisa langsung login)
('Ahmad Fauzi', 'ahmad@student.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'member', 'active', '2141720010', '2024'),

-- Member Alumni (inactive)
('Agus Prasetyo', 'agus@alumni.polinema.ac.id', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'member', 'inactive', '2131720001', '2021');

-- ========================================

-- 2. TABEL RESEARCH
-- Untuk menyimpan data riset/penelitian
CREATE TABLE IF NOT EXISTS research (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100) DEFAULT 'Riset Lainnya',
    image VARCHAR(255),
    leader_id INTEGER REFERENCES users(id),
    team_members TEXT,
    status VARCHAR(50) DEFAULT 'active',
    start_date DATE,
    end_date DATE,
    funding VARCHAR(255),
    publications TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_research_status ON research(status);
CREATE INDEX idx_research_category ON research(category);

-- Insert sample data riset
INSERT INTO research (title, description, category, leader_id, team_members, status, start_date, funding, publications) VALUES
('Face Recognition dengan Deep Learning', 
'Riset pengembangan sistem face recognition menggunakan Convolutional Neural Network (CNN) untuk aplikasi keamanan dan absensi.', 
'Riset Utama', 3, 'Ahmad, Budi, Siti', 'active', '2024-01-15', 'Hibah Dikti 2024', 'IEEE Trans. 2024'),

('Object Detection untuk Smart Surveillance', 
'Pengembangan sistem deteksi objek real-time menggunakan YOLO untuk aplikasi surveillance pintar di kampus.', 
'Riset Utama', 4, 'Dedi, Rina, Andi', 'active', '2024-02-01', 'Hibah Internal', 'Conference ICAICTA 2024'),

('Natural Language Processing untuk Bahasa Indonesia', 
'Riset pengembangan model NLP untuk pemrosesan bahasa Indonesia dalam aplikasi chatbot dan text analysis.', 
'Riset Utama', 5, 'Rudi, Sari', 'active', '2024-02-20', 'Hibah Dikti 2024', NULL),

('IoT-based Smart Room Monitoring', 
'Sistem monitoring ruangan pintar menggunakan sensor IoT dan computer vision untuk efisiensi energi.', 
'Riset Pendukung', 3, 'Yusuf, Fitri', 'active', '2024-03-10', 'Mandiri', NULL),

('Emotion Recognition dari Facial Expression', 
'Riset pengenalan emosi berdasarkan ekspresi wajah menggunakan deep learning untuk aplikasi HCI.', 
'Riset Pendukung', 4, 'Siti, Andi', 'completed', '2023-06-01', 'Hibah Dikti 2023', 'Jurnal IJCCS 2024');

-- ========================================

-- 3. TABEL MEMBER_REGISTRATIONS
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
    
    role_wanted VARCHAR(50) DEFAULT 'member',
    motivation TEXT,
    status VARCHAR(50) DEFAULT 'pending_supervisor',  -- 'pending_supervisor', 'pending_lab_head', 'approved', 'rejected_supervisor', 'rejected_lab_head'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_registrations_status ON member_registrations(status);
CREATE INDEX idx_registrations_supervisor ON member_registrations(supervisor_id);

-- Insert sample data pendaftar (masih pending, belum jadi member)
-- Password untuk semua pendaftar: admin123
-- Dibagi ke 3 dosen berbeda untuk testing role-based filtering
INSERT INTO member_registrations (name, email, nim, phone, angkatan, origin, password, research_title, supervisor_id, motivation, status, supervisor_approved_at) VALUES
-- Pendaftar yang pilih Dr. Budi Santoso (id=3)
('Budi Santoso', 'budi.santoso@student.polinema.ac.id', '2141720020', '081234567890', '2024', 'TI 3A - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Pengenalan Emosi dengan Deep Learning', 3, 'Saya tertarik dengan computer vision dan ingin belajar lebih dalam tentang AI. Ingin mengembangkan skill di bidang emotion recognition untuk aplikasi HCI.', 'pending_supervisor', NULL),
('Yusuf Rahman', 'yusuf@student.polinema.ac.id', '2141720023', '081234567893', '2024', 'TI 3C - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Smart Parking System', 3, 'Ingin belajar machine learning dan AI untuk aplikasi real-world seperti smart parking system.', 'pending_supervisor', NULL),

-- Pendaftar yang pilih Dr. Andi Wijaya (id=4)
('Siti Aminah', 'siti.aminah@student.polinema.ac.id', '2141720021', '081234567891', '2024', 'TI 3B - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Object Detection untuk Smart City', 4, 'Ingin mengembangkan skill di bidang image processing dan computer vision. Tertarik dengan aplikasi AI untuk smart city.', 'pending_supervisor', NULL),
('Fitri Handayani', 'fitri@student.polinema.ac.id', '2141720024', '081234567894', '2024', 'TI 3B - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'IoT-based Smart Room Monitoring', 4, 'Tertarik dengan IoT dan smart systems. Ingin mengembangkan sistem monitoring yang efisien untuk gedung kampus.', 'pending_supervisor', NULL),

-- Pendaftar yang pilih Dr. Siti Nurhaliza (id=5)
('Rudi Hermawan', 'rudi@student.polinema.ac.id', '2141720025', '081234567895', '2024', 'TI 3A - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Natural Language Processing untuk Bahasa Indonesia', 5, 'Tertarik dengan NLP dan ingin berkontribusi dalam pengembangan aplikasi AI untuk bahasa Indonesia.', 'pending_supervisor', NULL),

-- Pendaftar yang sudah lolos approval dosen (untuk testing Ketua Lab)
('Andi Pratama', 'andi.pratama@student.polinema.ac.id', '2141720022', '081234567892', '2023', 'TI 3A - Politeknik Negeri Malang', '$2y$10$ZIRh2/RXxMUbL/RFBLkDaODTPtZwf1Mb5XznEmWN2iLSoKFbxVZLq', 'Face Recognition dengan CNN', 3, 'Tertarik dengan riset face recognition dan ingin berkontribusi dalam pengembangan sistem keamanan berbasis AI.', 'pending_lab_head', CURRENT_TIMESTAMP);

-- ========================================

-- 4. TABEL NEWS
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

-- 5. TABEL EQUIPMENT
-- Untuk menyimpan inventaris peralatan lab
CREATE TABLE IF NOT EXISTS equipment (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    brand VARCHAR(100),
    model VARCHAR(100),
    quantity INTEGER DEFAULT 1,
    condition VARCHAR(50) DEFAULT 'baik',
    location VARCHAR(255),
    purchase_date DATE,
    price DECIMAL(15,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index
CREATE INDEX idx_equipment_category ON equipment(category);
CREATE INDEX idx_equipment_condition ON equipment(condition);

-- Insert sample data peralatan
INSERT INTO equipment (name, category, brand, model, quantity, condition, location, purchase_date, price, notes) VALUES
('Camera Logitech C920', 'Hardware', 'Logitech', 'C920 HD Pro', 5, 'baik', 'Rak A1', '2023-08-15', 1500000, 'Untuk riset face recognition'),
('Raspberry Pi 4 Model B', 'Hardware', 'Raspberry Pi', '4B 8GB RAM', 10, 'baik', 'Rak A2', '2023-09-20', 1200000, 'IoT dan edge computing'),
('Arduino Uno R3', 'Hardware', 'Arduino', 'Uno R3', 15, 'baik', 'Rak A3', '2023-07-10', 250000, 'Prototyping IoT'),
('Laptop Dell Precision', 'Hardware', 'Dell', 'Precision 5540', 3, 'baik', 'Meja Lab', '2024-01-05', 25000000, 'Deep learning workstation'),
('GPU NVIDIA RTX 3080', 'Hardware', 'NVIDIA', 'RTX 3080 10GB', 2, 'baik', 'Server Room', '2024-02-10', 15000000, 'Training model AI'),
('Sensor HC-SR04', 'Hardware', 'Generic', 'HC-SR04', 20, 'baik', 'Laci B1', '2023-06-15', 25000, 'Sensor ultrasonik'),
('ESP32 DevKit', 'Hardware', 'Espressif', 'ESP32-WROOM', 12, 'baik', 'Rak A3', '2023-10-01', 85000, 'WiFi & Bluetooth module'),
('Webcam 4K Logitech BRIO', 'Hardware', 'Logitech', 'BRIO 4K', 3, 'baik', 'Rak A1', '2024-03-20', 3500000, 'High resolution capture'),
('Tripod Manfrotto', 'Aksesoris', 'Manfrotto', 'MT190X', 4, 'baik', 'Lemari Storage', '2023-08-25', 2000000, 'Camera mounting'),
('LED Ring Light', 'Aksesoris', 'Godox', 'LR180', 3, 'baik', 'Lemari Storage', '2023-09-10', 800000, 'Lighting untuk capture'),

('Python Deep Learning', 'Software', 'PyTorch', 'v2.0', 1, 'baik', 'Server', '2024-01-15', 0, 'Framework deep learning'),
('MATLAB R2023', 'Software', 'MathWorks', 'R2023b', 5, 'baik', 'Komputer Lab', '2023-11-01', 50000000, 'License untuk 5 user'),
('OpenCV Library', 'Software', 'OpenCV', '4.8.0', 1, 'baik', 'Server', '2023-12-01', 0, 'Computer vision library'),

('Camera Canon EOS M50', 'Hardware', 'Canon', 'EOS M50', 1, 'maintenance', 'Service Center', '2023-05-10', 9000000, 'Sedang maintenance'),
('Laptop Asus ROG', 'Hardware', 'Asus', 'ROG Strix G15', 1, 'rusak', 'Gudang', '2023-03-15', 18000000, 'LCD rusak, perlu perbaikan');

-- ========================================

-- 6. UPDATE USERS TABLE - Tambah kolom bio untuk settings profile
ALTER TABLE users ADD COLUMN IF NOT EXISTS bio TEXT;

-- ========================================

-- 7. TABEL SYSTEM_SETTINGS
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
CREATE INDEX IF NOT EXISTS idx_system_settings_key ON system_settings(setting_key);

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

-- 8. TABEL PUBLICATIONS
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

-- 9. TABEL NOTIFICATIONS
-- Untuk menyimpan notifikasi yang ditargetkan ke role atau user tertentu
CREATE TABLE IF NOT EXISTS notifications (
    id SERIAL PRIMARY KEY,
    target_role VARCHAR(20) NOT NULL,           -- 'admin', 'ketua_lab', 'dosen', 'all'
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
('admin', NULL, 'Sistem Berhasil Diinstal', 'Database Lab IVSS telah berhasil disetup. Semua tabel dan data sample telah dibuat.', 'system', NULL, NULL, 'check', 'high', false),
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

-- Selesai! Semua tabel berhasil dibuat
-- Total 9 tabel: users, member_registrations, news, research, equipment, system_settings, publications, notifications
--
-- DATA YANG SUDAH DITAMBAHKAN:
-- 1. Users (7 user):
--    - 1 Admin: admin@ivss.polinema.ac.id
--    - 2 Dosen: budi.dosen & siti.dosen@polinema.ac.id
--    - 3 Member Aktif: ahmad, rina, dedi@student.polinema.ac.id
--    - 1 Member Alumni: agus@alumni.polinema.ac.id
--    PASSWORD SEMUA USER: admin123
--
-- 2. Member Registrations: 6 pendaftar (status pending)
-- 3. News: 5 berita (4 published, 1 draft)
-- 4. Research: 6 riset (5 active, 1 completed)
-- 5. Equipment: 15 peralatan lab
-- 6. Users: Kolom bio ditambahkan
-- 7. System Settings: 6 default settings
-- 8. Publications: 8 publikasi (5 featured untuk home page)
-- 9. Notifications: 15 notifikasi sample (targeted per role dan user)
--    - 2 untuk Admin
--    - 3 untuk Ketua Lab
--    - 3 untuk Dr. Budi (dosen)
--    - 3 untuk Dr. Andi (dosen)
--    - 2 untuk Dr. Siti (dosen)
--    - 1 untuk semua dosen (broadcast)
--

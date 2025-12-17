<?php
/**
 * Layout Utama Panel Admin
 * 
 * Layout ini digunakan sebagai pembungkus utama seluruh halaman dashboard admin.
 * Menangani pengecekan sesi, koneksi database, notifikasi, dan struktur HTML dasar.
 * Memuat sidebar dan header secara dinamis.
 * 
 * @package View
 * @subpackage Layouts
 */

// Pastikan sesi sudah dimulai di index.php, namun cek sebagai fallback
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek autentikasi user
if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php?page=login');
    exit;
}

// Cek otorisasi akses admin (admin, ketua_lab, dosen)
// Member biasa tidak boleh masuk ke area ini
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'dosen' && $_SESSION['role'] !== 'ketua_lab') {
    header('Location: ./index.php?page=home');
    exit;
}

// Koneksi Database untuk Data Real-time (Notifikasi)
 require_once __DIR__ . '/../../app/config/database.php';
$db = getDb(); 

// Ambil data user untuk keperluan tampilan layout
$userRole = $_SESSION['user']['role'] ?? $_SESSION['role'] ?? 'member';
$userId   = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? 0;

// Inisialisasi variabel notifikasi
$notificationCount = 0;
$notifications = [];

// Logika Notifikasi Berdasarkan Role
try {
    if ($userRole === 'dosen') {
        // Dosen: Hitung pendaftar yang memilih dia sebagai supervisor (pending)
        $result = pg_query_params($db, "
            SELECT COUNT(*) AS count
            FROM member_registrations
            WHERE status = 'pending_supervisor' AND supervisor_id = $1
        ", [$userId]);
        $row = $result ? pg_fetch_assoc($result) : null;
        $notificationCount = (int)($row['count'] ?? 0);

        // Ambil data notifikasi terbaru (limit 3)
        $result = pg_query_params($db, "
            SELECT mr.*, u.username AS supervisor_name
            FROM member_registrations mr
            LEFT JOIN users u ON mr.supervisor_id = u.id
            WHERE mr.status = 'pending_supervisor' AND mr.supervisor_id = $1
            ORDER BY mr.created_at DESC
            LIMIT 3
        ", [$userId]);
        
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }

    } elseif ($userRole === 'ketua_lab') {
        // Ketua Lab: Hitung yang sudah approve dosen, menunggu final approval ketua lab
        $result = pg_query($db, "
            SELECT COUNT(*) AS count
            FROM member_registrations
            WHERE status = 'pending_lab_head'
        ");
        $row = $result ? pg_fetch_assoc($result) : null;
        $notificationCount = (int)($row['count'] ?? 0);

        // Ambil data notifikasi terbaru (limit 3)
        $result = pg_query($db, "
            SELECT mr.*, u.username AS supervisor_name
            FROM member_registrations mr
            LEFT JOIN users u ON mr.supervisor_id = u.id
            WHERE mr.status = 'pending_lab_head'
            ORDER BY mr.created_at DESC
            LIMIT 3
        ");
        
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }

    } elseif ($userRole === 'admin') {
        // Admin: Melihat semua yang pending (supervisor atau lab head)
        $result = pg_query($db, "
            SELECT COUNT(*) AS count
            FROM member_registrations
            WHERE status IN ('pending_supervisor', 'pending_lab_head')
        ");
        $row = $result ? pg_fetch_assoc($result) : null;
        $notificationCount = (int)($row['count'] ?? 0);

        // Ambil data notifikasi terbaru (limit 3)
        $result = pg_query($db, "
            SELECT mr.*, u.username AS supervisor_name
            FROM member_registrations mr
            LEFT JOIN users u ON mr.supervisor_id = u.id
            WHERE mr.status IN ('pending_supervisor', 'pending_lab_head')
            ORDER BY mr.created_at DESC
            LIMIT 3
        ");
        
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }
    }
} catch (Exception $e) {
    // Fail-safe jika terjadi error query
    $notificationCount = 0;
    $notifications = [];
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin' ?> - Lab IVSS</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="./assets/images/logo1.png">

    <!-- Custom Style -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Scrollbar Halus */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen text-slate-800 antialiased overflow-x-hidden">

    <!-- Sidebar Layout -->
    <?php include __DIR__ . '/../admin/partials/sidebar.php'; ?>

    <!-- Wrapper Konten Utama -->
    <div class="flex flex-col lg:ml-60 min-h-screen transition-all duration-300">

        <!-- Header / Topbar Layout -->
        <?php include __DIR__ . '/../admin/partials/header.php'; ?>

        <!-- Konten Halaman Dinamis -->
        <main class="p-4 md:p-6 lg:p-8 flex-1 w-full max-w-7xl mx-auto">
            <?= $content ?? '' ?>
        </main>
        
        <!-- Footer Sederhana (Opsional) -->
        <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center lg:text-left text-xs text-slate-500">
            &copy; <?= date('Y') ?> Laboratorium IVSS Polinema. All rights reserved.
        </footer>

    </div>

    <!-- Script: Sidebar Interaction for Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Fungsi Toggle Sidebar
            function toggleSidebar() {
                const isHidden = sidebar.classList.contains('-translate-x-full');

                if (isHidden) {
                    // Buka Sidebar
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Kunci scroll body

                    // Efek Fade-in Overlay
                    setTimeout(() => {
                        sidebarOverlay.style.opacity = '1';
                    }, 10);
                } else {
                    // Tutup Sidebar
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.style.opacity = '0';
                    document.body.style.overflow = ''; // Lepas kunci scroll

                    // Tunggu transisi selesai sebelum hidden
                    setTimeout(() => {
                        sidebarOverlay.classList.add('hidden');
                    }, 300);
                }
            }

            // Event Listener Hamburger Menu
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Event Listener Klik Overlay (Tutup Sidebar)
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                }, true);
            }

            // Event Listener Tombol ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            });

            // Reset Tampilan saat Resize ke Desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    document.body.style.overflow = '';
                } else {
                    // Saat resize ke mobile, pastikan sidebar tertutup default jika user tidak sedang membukanya
                    if (sidebarOverlay.classList.contains('hidden')) {
                         sidebar.classList.add('-translate-x-full');
                    }
                }
            });
        });
    </script>

</body>
</html>
<?php
// Ensure session is started (index.php normally starts it)
if (!isset($_SESSION)) session_start();

// DEBUG: write session and cookie snapshot for diagnostics (remove in production)
try {
    $logDir = __DIR__ . '/../../app/logs';
    if (!is_dir($logDir)) @mkdir($logDir, 0755, true);
    $logPath = $logDir . '/session_debug.log';
    $data = [
        'ts' => date('c'),
        'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
        'session_keys' => array_keys($_SESSION ?? []),
        'session' => $_SESSION ?? [],
        'cookies' => $_COOKIE ?? [],
        'php_sess_name' => session_name(),
    ];
    @file_put_contents($logPath, var_export($data, true) . "\n----\n", FILE_APPEND | LOCK_EX);
} catch (Exception $e) {
    // ignore diagnostics failures
}

// Normalize login check (support nested and flat session shapes)
$userId = $_SESSION['user_id'] ?? $_SESSION['user']['id'] ?? null;
if (!$userId) {
    $_SESSION['error'] = 'You must be logged in to access the admin area.';
    header('Location: ./index.php?page=login');
    exit;
}

// Normalize role check
$allowed_roles = ['admin', 'dosen', 'ketua_lab'];
$role = $_SESSION['role'] ?? $_SESSION['user']['role'] ?? null;
if (!in_array($role, $allowed_roles)) {
    header('Location: ./index.php?page=home');
    exit;
}

// Get database connection untuk notification data
require_once __DIR__ . '/../../app/config/database.php';
$db = getDb();

// Get notification count based on role
$userRole = $_SESSION['user']['role'] ?? $_SESSION['role'] ?? 'member';
$userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? 0;

$notificationCount = 0;
$notifications = [];

try {
    if ($userRole === 'dosen') {
        // Dosen: count pendaftar yang memilih dia sebagai supervisor
        $query = "SELECT COUNT(*) as count FROM member_registrations 
                  WHERE status = 'pending_supervisor' AND supervisor_id = $1";
        $result = @pg_query_params($db, $query, [$userId]);
        if ($result) {
            $row = pg_fetch_assoc($result);
            $notificationCount = (int)($row['count'] ?? 0);
        }
        
        // Get latest notifications
        $result = pg_query_params($db, "
            SELECT mr.*, u.name AS supervisor_name
            FROM member_registrations mr
            LEFT JOIN users u ON mr.supervisor_id = u.id
            WHERE mr.status = 'pending_supervisor' AND mr.supervisor_id = $1
            ORDER BY mr.created_at DESC
            LIMIT 3
        ", [$userId]);
        $notifications = [];
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }

    } elseif ($userRole === 'ketua_lab') {
        // Ketua Lab: count yang sudah approve dosen
        $query = "SELECT COUNT(*) as count FROM member_registrations 
                  WHERE status = 'pending_lab_head'";
        $result = @pg_query($db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            $notificationCount = (int)($row['count'] ?? 0);
        }
        
        // Get latest notifications
        $result = pg_query($db, "
            SELECT mr.*, u.name AS supervisor_name
            FROM member_registrations mr
            LEFT JOIN users u ON mr.supervisor_id = u.id
            WHERE mr.status = 'pending_lab_head'
            ORDER BY mr.created_at DESC
            LIMIT 3
        ");
        $notifications = [];
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }

    } elseif ($userRole === 'admin') {
        // Admin: count all pending registrations
        $query = "SELECT COUNT(*) as count FROM member_registrations 
                  WHERE status IN ('pending_supervisor', 'pending_lab_head')";
        $result = @pg_query($db, $query);
        if ($result) {
            $row = pg_fetch_assoc($result);
            $notificationCount = (int)($row['count'] ?? 0);
        }
        
        // Get latest notifications
        $result = pg_query($db, "
            SELECT mr.*, u.name AS supervisor_name
            FROM member_registrations mr
            LEFT JOIN users u ON mr.supervisor_id = u.id
            WHERE mr.status IN ('pending_supervisor', 'pending_lab_head')
            ORDER BY mr.created_at DESC
            LIMIT 3
        ");
        $notifications = [];
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $notifications[] = $row;
            }
        }
    }
} catch (Exception $e) {
    // Silent fail - notifikasi tidak krusial
    $notificationCount = 0;
    $notifications = [];
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin' ?> - IVSS Lab</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="./assets/images/logo1.png">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen">

    <!-- Sidebar -->
    <?php include __DIR__ . '/../admin/partials/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="flex flex-col lg:ml-60 min-h-screen transition-all duration-300">

        <!-- Header/Topbar -->
        <?php include __DIR__ . '/../admin/partials/header.php'; ?>

        <!-- Main Content -->
        <main class="p-4 md:p-6 flex-1">
            <?= $content ?? '' ?>
        </main>

    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar on mobile
            function toggleSidebar() {
                const isHidden = sidebar.classList.contains('-translate-x-full');

                if (isHidden) {
                    // Open sidebar
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';

                    // Force reflow untuk smooth transition
                    setTimeout(() => {
                        sidebarOverlay.style.opacity = '1';
                    }, 10);
                } else {
                    // Close sidebar
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.style.opacity = '0';
                    document.body.style.overflow = '';

                    // Tunggu transition selesai baru hide
                    setTimeout(() => {
                        sidebarOverlay.classList.add('hidden');
                    }, 300);
                }
            }

            // Open sidebar when hamburger clicked
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    toggleSidebar();
                });
            }

            // Close sidebar when overlay clicked
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Overlay clicked - closing sidebar');
                    toggleSidebar();
                }, true);

                // Juga tambahkan touch event untuk mobile
                sidebarOverlay.addEventListener('touchstart', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Overlay touched - closing sidebar');
                    toggleSidebar();
                }, {
                    passive: false
                });
            }

            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            });

            // Close sidebar when clicking menu link on mobile
            const menuLinks = sidebar.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) { // lg breakpoint
                        toggleSidebar();
                    }
                });
            });

            // Reset on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    // Desktop view - reset everything
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>

</body>

</html>
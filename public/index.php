<?php
// Start output buffering untuk prevent "headers already sent" error
ob_start();

// Start session untuk semua halaman
session_start();

require_once __DIR__ . '/../app/config/database.php';
$pg = getDb(); // dari database.php

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        require __DIR__ . '/../app/controllers/HomeController.php';
        (new HomeController($pg))->index();
        break;
    case 'research':
        require __DIR__ . '/../app/controllers/ResearchController.php';
        (new ResearchController($pg))->index();
        break;
    case 'news':
        require __DIR__ . '/../app/controllers/NewsController.php';
        (new NewsController($pg))->index();
        break;
    case 'login':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pg))->login();
        break;
    case 'register':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pg))->register();
        break;
    case 'forgot-password':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pg))->forgotPassword();
        break;
    case 'logout':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pg))->logout();
        break;
    
    // Admin Routes
    case 'admin':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->dashboard();
        break;
    case 'admin-registrations':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->registrations();
        break;
    case 'admin-news':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->news();
        break;
    case 'admin-research':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->research();
        break;
    case 'admin-members':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->members();
        break;
    case 'admin-equip':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->equipment();
        break;
    case 'admin-settings':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->settings();
        break;
    
    // Member Routes
    case 'member':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->dashboard();
        break;
    case 'member-upload':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->upload();
        break;
    case 'member-attendance':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->attendance();
        break;
    case 'member-profile':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->profile();
        break;
    case 'member-profile-edit':
    case 'member-change-password':
        echo "<div style='padding: 2rem; text-align: center;'>";
        echo "<h2>Halaman " . ucfirst(str_replace('member-', '', $page)) . "</h2>";
        echo "<p>Halaman ini masih dalam pengembangan.</p>";
        echo "<a href='index.php?page=member' style='color: blue;'>← Kembali ke Dashboard</a>";
        echo "</div>";
        break;
    
    default:
        http_response_code(404);
        echo "404 Not Found";
}

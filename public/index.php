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
    case 'admin-users':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->index();
        break;
    
    // User AJAX Actions
    case 'user-store':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->store();
        break;
    case 'user-show':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->show();
        break;
    case 'user-update':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->update();
        break;
    case 'user-delete':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->delete();
        break;
    case 'user-reset-password':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->resetPassword();
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
    
    // Member Research Routes
    case 'member-research':
        require __DIR__ . '/../view/member/research/index.php';
        break;
    case 'member-research-detail':
        require __DIR__ . '/../view/member/research/detail.php';
        break;
    
    // Member Publications
    case 'member-publications':
        require __DIR__ . '/../view/member/publications/index.php';
        break;
    
    // Member Profile
    case 'member-profile':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->profile();
        break;
    
    // Member News & Events
    case 'member-news':
        require __DIR__ . '/../view/member/news.php';
        break;
    
    // Legacy routes (will be deprecated)
    case 'member-upload':
    case 'member-attendance':
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

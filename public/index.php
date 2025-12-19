<?php
// Start output buffering untuk prevent "headers already sent" error
ob_start();

// Start session untuk semua halaman
session_start();

// Set timezone to Asia/Jakarta (WIB - GMT+7)
date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/../app/config/database.php';
$pg = getDb(); // PgSql\Connection

// Make database connection available globally for layouts and partials
$GLOBALS['db'] = $pg;

require_once __DIR__ . '/../app/controllers/HomeController.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        (new HomeController($pg))->index();
        break;

    case 'login':
        require __DIR__ . '/../app/controllers/AuthController.php';
        (new AuthController($pg))->login();
        break;

    case 'admin-visimisi':
         require __DIR__ . '/../app/controllers/AdminController.php';
         (new AdminController($pg))->visimisi();
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
    case 'admin-perkuliahan-list':
        // List tampilan utama perkuliahan
        include __DIR__ . '/../view/admin/perkuliahanTerkait/index.php';
        break;
    case 'admin-perkuliahan-edit':
        // Edit/Add form untuk perkuliahan
        include __DIR__ . '/../view/admin/perkuliahanTerkait/edit.php';
        break;
    case 'admin-perkuliahan':
        // Backward compatibility - redirect to list
        header('Location: index.php?page=admin-perkuliahan-list');
        exit;
        break;
    case 'admin-users':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->index();
        break;
    case 'admin-footer':
        require __DIR__ . '/../app/controllers/FooterController.php';
        $controller = new FooterController($pg);

        $action = $_GET['action'] ?? 'index';

        if ($action === 'edit') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->update();
            } else {
                $controller->edit();
            }
        } else {
            $controller->index();
        }
        break;

    case 'admin-navbar':
        include __DIR__ . '/../view/admin/navbar/index.php';
        break;
    
    case 'admin-profile-settings':
        include __DIR__ . '/../view/admin/profile/index.php';
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

    // Dosen Management Routes
    case 'admin-dosen':
        require __DIR__ . '/../app/controllers/DosenController.php';
        (new DosenController($pg))->index();
        break;
    case 'admin-dosen-create':
        require __DIR__ . '/../app/controllers/DosenController.php';
        (new DosenController($pg))->create();
        break;
    case 'admin-dosen-store':
        require __DIR__ . '/../app/controllers/DosenController.php';
        (new DosenController($pg))->store();
        break;
    case 'admin-dosen-detail':
        require __DIR__ . '/../app/controllers/DosenController.php';
        (new DosenController($pg))->show();
        break;
    case 'admin-dosen-edit':
        require __DIR__ . '/../app/controllers/DosenController.php';
        (new DosenController($pg))->edit();
        break;
    case 'admin-dosen-update':
        require __DIR__ . '/../app/controllers/DosenController.php';
        (new DosenController($pg))->update();
        break;
    case 'admin-dosen-delete':
        require __DIR__ . '/../app/controllers/DosenController.php';
        (new DosenController($pg))->destroy();
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
        require_once __DIR__ . '/../app/controllers/EquipmentController.php';
        $controller = new EquipmentController($pg);

        $action = $_GET['action'] ?? 'index';

        if ($action === 'create') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->store();
            } else {
                $controller->create();
            }
        } elseif ($action === 'edit') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->update();
            } else {
                $controller->edit();
            }
        } elseif ($action === 'delete') {
            $controller->delete();
        } else {
            $controller->index();
        }
        break;
    case 'admin-settings':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->settings();
        break;

    // Team Members Management
    case 'admin-team':
        require __DIR__ . '/../app/controllers/TeamMemberController.php';
        (new TeamMemberController($pg))->index();
        break;
    case 'admin-team-show':
        require __DIR__ . '/../app/controllers/TeamMemberController.php';
        (new TeamMemberController($pg))->show();
        break;
    case 'admin-team-store':
        require __DIR__ . '/../app/controllers/TeamMemberController.php';
        (new TeamMemberController($pg))->store();
        break;
    case 'admin-team-update':
        require __DIR__ . '/../app/controllers/TeamMemberController.php';
        (new TeamMemberController($pg))->update();
        break;
    case 'admin-team-delete':
        require __DIR__ . '/../app/controllers/TeamMemberController.php';
        (new TeamMemberController($pg))->delete();
        break;
    case 'admin-team-toggle':
        require __DIR__ . '/../app/controllers/TeamMemberController.php';
        (new TeamMemberController($pg))->toggleActive();
        break;

    // Dosen Routes (Publications & Students)
    case 'admin-publications':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->publications();
        break;
    case 'admin-students':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->students();
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

    // Member Profile & Settings
    case 'member-profile':
    case 'member-settings':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->profile();
        break;

    case 'member-settings-edit':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->editProfile();
        break;

    case 'member-settings-update':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->updateProfile();
        break;

    case 'member-change-password':
    case 'member-settings-change-password':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->changePassword();
        break;

    case 'member-settings-change-password-submit':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->submitChangePassword();
        break;

    // Facilities Routes
    case 'admin-facilities':
        require __DIR__ . '/../app/controllers/FacilityController.php';
        (new FacilityController($pg))->index();
        break;
    case 'admin-facilities-create':
        require __DIR__ . '/../app/controllers/FacilityController.php';
        (new FacilityController($pg))->create();
        break;
    case 'admin-facilities-store':
        require __DIR__ . '/../app/controllers/FacilityController.php';
        (new FacilityController($pg))->store();
        break;
    case 'admin-facilities-edit':
        require __DIR__ . '/../app/controllers/FacilityController.php';
        (new FacilityController($pg))->edit();
        break;
    case 'admin-facilities-update':
        require __DIR__ . '/../app/controllers/FacilityController.php';
        (new FacilityController($pg))->update();
        break;
    case 'admin-facilities-delete':
        require __DIR__ . '/../app/controllers/FacilityController.php';
        (new FacilityController($pg))->delete();
        break;

    // Gallery Routes
    case 'admin-gallery':
        require __DIR__ . '/../app/controllers/GalleryController.php';
        (new GalleryController($pg))->index();
        break;
    case 'admin-gallery-create':
        require __DIR__ . '/../app/controllers/GalleryController.php';
        (new GalleryController($pg))->create();
        break;
    case 'admin-gallery-store':
        require __DIR__ . '/../app/controllers/GalleryController.php';
        (new GalleryController($pg))->store();
        break;
    case 'admin-gallery-edit':
        require __DIR__ . '/../app/controllers/GalleryController.php';
        (new GalleryController($pg))->edit();
        break;
    case 'admin-gallery-update':
        require __DIR__ . '/../app/controllers/GalleryController.php';
        (new GalleryController($pg))->update();
        break;
    case 'admin-gallery-delete':
        require __DIR__ . '/../app/controllers/GalleryController.php';
        (new GalleryController($pg))->delete();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
}

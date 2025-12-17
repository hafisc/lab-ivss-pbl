<?php
/**
 * Main Router (Front Controller)
 * 
 * File ini berfungsi sebagai entry point utama aplikasi.
 * Menangani semua request yang masuk dan mengarahkannya ke Controller yang sesuai
 * berdasarkan parameter 'page' di URL.
 * 
 * @package Public
 */

// Mulai output buffering untuk mencegah error "headers already sent"
ob_start();

// Mulai session untuk manajemen autentikasi user
session_start();

// Atur zona waktu default ke WIB (Asia/Jakarta)
date_default_timezone_set('Asia/Jakarta');

// Muat konfigurasi database
require_once __DIR__ . '/../app/config/database.php';

// Inisialisasi koneksi database
$pg = getDb(); // Koneksi legacy (resource)

// Simpan koneksi di global agar bisa diakses di view/layout jika diperlukan
$GLOBALS['db'] = $pg;

// Muat Controller Utama
require_once __DIR__ . '/../app/controllers/HomeController.php';

// Tentukan halaman yang diminta, default ke 'home'
$page = $_GET['page'] ?? 'home';

// Routing Switch
switch ($page) {
    
    // --- Halaman Publik ---
    
    case 'home':
        (new HomeController($pg))->index();
        break;

    case 'news':
        (new HomeController($pg))->news();
        break;

    // --- Autentikasi ---
    
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

    // --- Admin Routes ---
    
    case 'admin':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->dashboard();
        break;

    case 'admin-users':
        require __DIR__ . '/../app/controllers/UserController.php';
        $controller = new UserController();
        $controller->index();
        break;
        
    case 'admin-registrations':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->registrations();
        break;

    // --- Manajemen Dosen (Admin) ---
    
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

    // --- Manajemen Konten Web (Admin) ---
    
    case 'admin-news':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->news();
        break;
        
    case 'admin-research':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->research();
        break;
        
    case 'admin-publications':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->publications();
        break;
        
    case 'admin-students':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->students();
        break;

    case 'admin-visimisi':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->visimisi();
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
        
    case 'admin-settings':
        require __DIR__ . '/../app/controllers/AdminController.php';
        (new AdminController($pg))->settings();
        break;

    // --- Manajemen Tim & Perkuliahan ---

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

    case 'admin-perkuliahan-list':
        include __DIR__ . '/../view/admin/perkuliahanTerkait/index.php';
        break;
    case 'admin-perkuliahan-edit':
        include __DIR__ . '/../view/admin/perkuliahanTerkait/edit.php';
        break;
    case 'admin-perkuliahan':
        header('Location: index.php?page=admin-perkuliahan-list');
        exit;
        break;

    // --- Manajemen Inventaris & Galeri ---

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

    // --- Member Area Routes ---

    case 'member':
        require __DIR__ . '/../app/controllers/MemberController.php';
        (new MemberController($pg))->dashboard();
        break;

    case 'member-research':
        require __DIR__ . '/../view/member/research/index.php';
        break;
    case 'member-research-detail':
        require __DIR__ . '/../view/member/research/detail.php';
        break;

    case 'member-publications':
        require __DIR__ . '/../view/member/publications/index.php';
        break;

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

    // --- AJAX User Actions ---
    
    case 'user-store':
        require __DIR__ . '/../app/controllers/UserController.php';
        (new UserController())->store();
        break;
    case 'user-show':
        require __DIR__ . '/../app/controllers/UserController.php';
        (new UserController())->show();
        break;
    case 'user-update':
        require __DIR__ . '/../app/controllers/UserController.php';
        (new UserController())->update();
        break;
    case 'user-delete':
        require __DIR__ . '/../app/controllers/UserController.php';
        (new UserController())->delete();
        break;
    case 'user-reset-password':
        require __DIR__ . '/../app/controllers/UserController.php';
        (new UserController())->resetPassword();
        break;

    // --- 404 Route ---
    
    default:
        http_response_code(404);
        echo "404 Halaman Tidak Ditemukan";
}

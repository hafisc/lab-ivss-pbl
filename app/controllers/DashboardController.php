<?php

require_once __DIR__ . '/../models/research.php';
require_once __DIR__ . '/../models/member.php';
require_once __DIR__ . '/../models/dosen.php';
require_once __DIR__ . '/../models/user.php';

class DashboardController {
    private $db;
    private $researchModel;
    private $memberModel;
    private $dosenModel;
    private $userModel;
    private $visimisiModel;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->researchModel = new Research($this->db);
        $this->memberModel = new Member($this->db);
        $this->dosenModel = new Dosen($this->db);
        $this->userModel = new User($this->db);
    }

    public function index() {
        $stats = [
            'research' => $this->researchModel->getStats(),
            'pending_registrations' => $this->memberModel->getPendingCount(),
            'dosen_performance' => $this->dosenModel->getPerformance()
        ];
        
        // Get user specific data if logged in
        if (isset($_SESSION['user_id'])) {
            $stats['notifications'] = $this->userModel->getNotifications($_SESSION['user_id']);
        }

        return $stats;
    }
}

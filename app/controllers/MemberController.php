<?php

require_once __DIR__ . '/../models/member.php';

class MemberController {
    private $memberModel;
    private $db;

    public function __construct($db = null) {
        if ($db) {
            $this->db = $db;
        } else {
            $this->db = Database::getInstance()->getConnection();
        }
        $this->memberModel = new Member($this->db);
    }

    public function dashboard() {
        // Member dashboard view
        require_once __DIR__ . '/../../view/member/dashboard.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'nim' => $_POST['nim'],
                'phone' => $_POST['phone'],
                'angkatan' => $_POST['angkatan'],
                'origin' => $_POST['origin'],
                'password' => $_POST['password'],
                'research_title' => $_POST['research_title'],
                'supervisor_id' => $_POST['supervisor_id'],
                'motivation' => $_POST['motivation']
            ];

            $id = $this->memberModel->register($data);

            if ($id) {
                // Redirect to success page
                header('Location: /index.php?page=registration_success');
                exit;
            } else {
                return "Registration failed";
            }
        }
    }

    public function getPendingRegistrations($supervisor_id) {
        return $this->memberModel->getPendingBySupervisor($supervisor_id);
    }

    public function approveRegistration($id, $role, $notes = null) {
        if ($role === 'dosen') {
            return $this->memberModel->approveBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->approveByLabHead($id, $notes);
        }
        return false;
    }

    public function rejectRegistration($id, $role, $notes) {
        if ($role === 'dosen') {
            return $this->memberModel->rejectBySupervisor($id, $notes);
        } elseif ($role === 'ketua_lab') {
            return $this->memberModel->rejectByLabHead($id, $notes);
        }
        return false;
    }
}

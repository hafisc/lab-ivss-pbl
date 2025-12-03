<?php

require_once __DIR__ . '/../models/research.php';

class ResearchController {
    private $researchModel;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->researchModel = new Research($this->db);
    }

    public function index() {
        $researches = $this->researchModel->getAll();
        return $researches;
    }

    public function show($id) {
        $research = $this->researchModel->getById($id);
        $members = $this->researchModel->getMembers($id);
        
        return [
            'research' => $research,
            'members' => $members
        ];
    }

    public function addMember($research_id, $user_id, $role) {
        // Check if user has permission (e.g. is leader or admin)
        // For now, assume permission check is done in view or middleware
        
        return $this->researchModel->addMember($research_id, $user_id, $role);
    }

    public function removeMember($research_id, $user_id) {
        return $this->researchModel->removeMember($research_id, $user_id);
    }
}

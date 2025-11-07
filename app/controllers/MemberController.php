<?php

class MemberController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function dashboard() {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Dashboard Member';
        
        // Ambil statistik member
        $totalMyResearch = $this->getTotalMyResearch($userId);
        $totalMyUploads = $this->getTotalMyUploads($userId);
        $currentMemberStatus = $this->getMemberStatus($userId);
        
        // Ambil daftar riset untuk member ini
        $myResearches = $this->getMyResearches($userId);
        
        // Kirim data ke view
        include __DIR__ . '/../../view/member/dashboard.php';
    }
    
    public function upload() {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Upload Dokumen';
        
        // Tangani submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // TODO: Implementasi logic upload file
            $_SESSION['success'] = 'File berhasil di-upload!';
            header('Location: index.php?page=member-upload');
            exit;
        }
        
        // Ambil daftar riset untuk member ini
        $myResearches = $this->getMyResearches($userId);
        
        // Kirim data ke view
        include __DIR__ . '/../../view/member/upload.php';
    }
    
    public function attendance() {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Absensi Saya';
        
        // Ambil riwayat absensi
        $myAttendances = $this->getMyAttendances($userId);
        
        // Kirim data ke view
        include __DIR__ . '/../../view/member/attendance.php';
    }
    
    public function profile() {
        // Session sudah di-start di index.php
        $userId = $_SESSION['user_id'] ?? null;
        $title = 'Profil Saya';
        
        // Ambil data profil member
        $me = $this->getMemberProfile($userId);
        
        // Kirim data ke view
        include __DIR__ . '/../../view/member/profile.php';
    }
    
    // Method pembantu
    private function getTotalMyResearch($userId) {
        // TODO: Hitung riset dimana user adalah member
        // Untuk saat ini, return data sample
        return 2;
    }
    
    private function getTotalMyUploads($userId) {
        // TODO: Hitung upload oleh user
        // Untuk saat ini, return data sample
        return 5;
    }
    
    private function getMemberStatus($userId) {
        $query = "SELECT status FROM users WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$userId]);
        
        if ($result && pg_num_rows($result) > 0) {
            $row = pg_fetch_assoc($result);
            return $row['status'] ?? 'aktif';
        }
        
        return 'aktif';
    }
    
    private function getMyResearches($userId) {
        // TODO: Ambil riset dimana user adalah anggota tim
        // Untuk saat ini, return data sample dari tabel research
        $query = "SELECT r.*, u.name as leader_name 
                  FROM research r 
                  LEFT JOIN users u ON r.leader_id = u.id 
                  WHERE r.status = 'active' 
                  LIMIT 3";
        $result = @pg_query($this->db, $query);
        $researches = [];
        
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $researches[] = $row;
            }
        }
        
        return $researches;
    }
    
    private function getMyAttendances($userId) {
        // TODO: Ambil record absensi untuk user
        // Untuk saat ini, return data sample
        return [
            [
                'date' => date('Y-m-d'),
                'time' => '09:30',
                'method' => 'QR Code',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-2 days')),
                'time' => '14:15',
                'method' => 'Manual',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-5 days')),
                'time' => '10:00',
                'method' => 'QR Code',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-7 days')),
                'time' => '13:45',
                'method' => 'QR Code',
                'room' => 'Lab IVSS'
            ],
            [
                'date' => date('Y-m-d', strtotime('-10 days')),
                'time' => '08:30',
                'method' => 'Manual',
                'room' => 'Lab IVSS'
            ]
        ];
    }
    
    private function getMemberProfile($userId) {
        $query = "SELECT * FROM users WHERE id = $1";
        $result = @pg_query_params($this->db, $query, [$userId]);
        
        if ($result && pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);
            return [
                'name' => $user['name'],
                'email' => $user['email'],
                'nim' => $user['nim'] ?? '-',
                'angkatan' => $user['angkatan'] ?? '2024',
                'status_lab' => $user['status'] === 'active' ? 'aktif' : 'alumni'
            ];
        }
        
        return [
            'name' => $_SESSION['name'] ?? 'Member',
            'email' => $_SESSION['email'] ?? '-',
            'nim' => '-',
            'angkatan' => '2024',
            'status_lab' => 'aktif'
        ];
    }
}

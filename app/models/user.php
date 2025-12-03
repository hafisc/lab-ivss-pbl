<?php

class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $role_name;
    public $status;
    public $photo;
    public $bio;
    public $created_at;
    public $last_login;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get user details using function get_user_details()
    public function getDetails($id) {
        $query = "SELECT * FROM get_user_details($1)";
        
        $result = pg_query_params($this->conn, $query, array($id));
        
        if (!$result) {
            return false;
        }
        
        return pg_fetch_assoc($result);
    }

    // Update last login using procedure update_last_login()
    public function updateLastLogin($id) {
        $query = "CALL update_last_login($1)";
        
        $result = pg_query_params($this->conn, $query, array($id));
        
        return $result !== false;
    }

    // Get notifications for user
    public function getNotifications($user_id, $role = null) {
        $query = "SELECT * FROM notifications 
                  WHERE (target_user_id = $1 OR (target_role = $2 AND target_user_id IS NULL))
                  AND expires_at IS NULL OR expires_at > CURRENT_TIMESTAMP
                  ORDER BY created_at DESC";
        
        $params = array($user_id);
        if ($role) {
            $params[] = $role;
        } else {
            // If role not provided, we might miss role-based notifs, 
            // but usually we pass role from session
            $query = "SELECT * FROM notifications 
                      WHERE target_user_id = $1 
                      ORDER BY created_at DESC";
        }

        $result = pg_query_params($this->conn, $query, $params);
        
        if (!$result) {
            return [];
        }

        $notifications = array();
        while ($row = pg_fetch_assoc($result)) {
            $notifications[] = $row;
        }
        return $notifications;
    }

    // Mark notification as read
    public function markNotificationRead($id) {
        $query = "CALL mark_notification_read($1)";
        $result = pg_query_params($this->conn, $query, array($id));
        return $result !== false;
    }

    // Mark all notifications as read
    public function markAllNotificationsRead($user_id) {
        $query = "CALL mark_all_notifications_read($1)";
        $result = pg_query_params($this->conn, $query, array($user_id));
        return $result !== false;
    }
}

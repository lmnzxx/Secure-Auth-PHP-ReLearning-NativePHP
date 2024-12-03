<?php

namespace Herya\SecureAuth\Service;

use PDO;

class LogService {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fungsi untuk mencatat log tindakan
    public function logAction($userId, $action) {
        $stmt = $this->pdo->prepare('INSERT INTO audit_logs (user_id, action) VALUES (:user_id, :action)');
        $stmt->execute([
            ':user_id' => $userId,
            ':action' => $action,
        ]);
    }
}

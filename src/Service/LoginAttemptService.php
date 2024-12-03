<?php

namespace Herya\SecureAuth\Service;

use PDO;

class LoginAttemptService {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fungsi untuk memeriksa percobaan login
    public function checkLoginAttempt($username) {
        $stmt = $this->pdo->prepare('SELECT * FROM login_attempts WHERE username = :username');
        $stmt->execute( [':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk meningkatkan jumlah percobaan login
    public function incrementLoginAttempt($username, $lockDuration) {
        $stmt = $this->pdo->prepare(
            'INSERT INTO login_attempts (username, attempts, locked_until) 
             VALUES (:username, 1, NULL)
             ON DUPLICATE KEY UPDATE 
                attempts = attempts + 1,
                last_attempt = NOW(),
                locked_until = CASE 
                    WHEN attempts >= 4 THEN DATE_ADD(NOW(), INTERVAL :lock_duration SECOND)
                    ELSE locked_until END'
        );
        $stmt->execute([':username' => $username, ':lock_duration' => $lockDuration]);
    }

    // Fungsi untuk mereset percobaan login
    public function resetLoginAttempt($username) {
        $stmt = $this->pdo->prepare('DELETE FROM login_attempts WHERE username = :username');
        $stmt->execute([':username' => $username]);
    }
}

<?php

namespace Herya\SecureAuth\Model;

use PDO;
use PDOException;

date_default_timezone_set('Asia/Singapore');

class UserModel {
    private $pdo;

    public function __construct(PDO $pdo)
    {
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

    public function checkCredentials($username, $password) {
        $loginAttempt = $this->checkLoginAttempt($username);

        if ($loginAttempt && !empty($loginAttempt['locked_until']) && strtotime($loginAttempt['locked_until']) > time()) {
            $remaining = strtotime( $loginAttempt['locked_until']) - time();
            throw new \Exception("Akun terkunci. Silakan coba lagi dalam {$remaining} detik.");
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $this->resetLoginAttempt($username);

            $this->logAction($user['id'], 'Login sukses');

            return true;
        } else {
            $lockDuration = $loginAttempt ? (pow(3, $loginAttempt['attempts'])) * 60 : 300; 
            $this->incrementLoginAttempt($username, $lockDuration);

            if ($user) {
                $this->logAction($user['id'], 'Percobaan login gagal');
            }

            throw new \Exception('Username atau password salah.');
        }
    }

    public function createUser($username, $email, $password, $role) {
        try {
            $sql = 'INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
                ':role' => $role,
            ]);

            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                if (strpos($e->getMessage(), 'username') !== false) {
                    throw new \Exception("Username tersebut sudah digunakan. Silakan pilih username lain.");
                }
                if (strpos($e->getMessage(), 'email') !== false) {
                    throw new \Exception("Email tersebut sudah terdaftar. Silakan gunakan email lain.");
                }
            }
            throw new \Exception("Terjadi kesalahan saat mendaftarkan pengguna. Silakan coba lagi.");
        }
    }
}
?>

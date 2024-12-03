<?php

namespace Herya\SecureAuth\Model;

use PDO;
use PDOException;
use Herya\SecureAuth\Service\LoginAttemptService;
use Herya\SecureAuth\Service\LogService;

date_default_timezone_set('Asia/Singapore');

class UserModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function checkCredentials($username, $password, LoginAttemptService $loginAttemptService, LogService $logService) {
        // Memeriksa percobaan login
        $loginAttempt = $loginAttemptService->checkLoginAttempt($username);

        if ($loginAttempt && !empty($loginAttempt['locked_until']) && strtotime($loginAttempt['locked_until']) > time()) {
            $remaining = strtotime($loginAttempt['locked_until']) - time();
            throw new \Exception("Akun terkunci. Silakan coba lagi dalam {$remaining} detik.");
        }

        // Memeriksa kredensial
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $loginAttemptService->resetLoginAttempt($username);  // Reset percobaan login
            $logService->logAction($user['id'], 'Login sukses');  // Log login sukses
            return true;
        } else {
            $lockDuration = $loginAttempt ? (pow(3, $loginAttempt['attempts'])) * 60 : 300;
            $loginAttemptService->incrementLoginAttempt($username, $lockDuration); // Increment percobaan login
            if ($user) {
                $logService->logAction($user['id'], 'Percobaan login gagal');  // Log login gagal
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

    public function userExists($email){
        $email = trim(strtolower($email));
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menyimpan token reset password ke database
    public function savePasswordResetToken($email, $token){
        $stmt = $this->pdo->prepare("INSERT INTO password_resets (email, token) VALUES (:email, :token)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    // Validasi token
    public function validateToken($email, $token){
        $stmt = $this->pdo->prepare("SELECT * FROM password_resets WHERE email = :email AND token = :token AND created_at > NOW() - INTERVAL 1 HOUR");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update password user
    public function updatePassword($email, $newPassword){
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    // Generate token reset password 6 digit
    public function generateToken(){
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
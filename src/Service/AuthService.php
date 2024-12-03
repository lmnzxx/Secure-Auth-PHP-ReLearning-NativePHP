<?php

namespace Herya\SecureAuth\Service;

use Herya\SecureAuth\Model\UserModel;
use Herya\SecureAuth\Service\LoginAttemptService;
use Herya\SecureAuth\Service\LogService;

class AuthService {
    private $pdo;
    private $loginAttemptService;
    private $logService;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->loginAttemptService = new LoginAttemptService($pdo);
        $this->logService = new LogService($pdo);
    }

    public function login($username, $password) {
        $userModel = new UserModel($this->pdo);
        return $userModel->checkCredentials($username, $password, $this->loginAttemptService, $this->logService);
    }

    public function register($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $userModel = new UserModel($this->pdo);
        return $userModel->createUser($username, $email, $hashedPassword, 'user');
    }

    public function sendPasswordResetToken($email) {
        $userModel = new UserModel($this->pdo);

        if ($userModel->userExists($email)) {
            $token = $userModel->generateToken(); 
            $userModel->savePasswordResetToken($email, $token); 
        }
        throw new \Exception("Email tidak ditemukan.");
    }

    public function resetPassword($email, $token, $newPassword) {
        $userModel = new UserModel($this->pdo);

        // Validasi token
        if ($userModel->validateToken($email, $token)) {
            // Token valid, update password
            $userModel->updatePassword($email, $newPassword);
            return true;
        }

        throw new \Exception("Token tidak valid atau sudah kadaluarsa.");
    }
}

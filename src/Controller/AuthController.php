<?php

namespace Herya\SecureAuth\Controller;

use Herya\SecureAuth\Service\AuthService;

class AuthController {
    private $authService;
    private $pdo;

    public function __construct() {
        // Memuat file db.php dan mengambil koneksi PDO
        require_once __DIR__ . '/../../config/db.php'; 
        
        global $pdo;  
        $this->pdo = $pdo;  // Menyimpan PDO ke dalam properti objek

        // Menginisialisasi authService dengan PDO yang telah disiapkan
        $this->authService = new AuthService($this->pdo);
    }

    public function login() {
        $errorMessage = ''; 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            try {
                // Menggunakan AuthService untuk menangani login
                if ($this->authService->login($username, $password)) {
                    header("Location: dashboard.php");
                    exit;
                }
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
            }
        }
    
        return $errorMessage;
    }    

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            try {
                // Menggunakan AuthService untuk menangani pendaftaran
                $this->authService->register($username, $email, $password);
                header('Location: index.php');
                exit;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return null;
    }   

    public function sendPasswordResetToken() {        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            
            try {
                // Menggunakan AuthService untuk mengirim token reset password
                if ($this->authService->sendPasswordResetToken($email)) {
                    return 'Token reset password telah dikirim ke email Anda.';
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return null;
    }

    public function resetPassword() {
        $errorMessage = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $token = $_POST['token'];
            $newPassword = $_POST['new_password'];
            
            try {
                // Menggunakan AuthService untuk mereset password
                if ($this->authService->resetPassword($email, $token, $newPassword)) {
                    return 'Password berhasil direset.';
                }
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
            }
        }

        return $errorMessage;
    }
}

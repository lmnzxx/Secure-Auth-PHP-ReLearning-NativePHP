<?php

namespace Herya\SecureAuth\Controller;

use Herya\SecureAuth\Model\UserModel;

class AuthController {
    private $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../../config/db.php'; 
        
        global $pdo;  
        $this->pdo = $pdo;  
    }

    public function login() {
        $errorMessage = ''; 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $userModel = new UserModel($this->pdo); 
            try {
                if ($userModel->checkCredentials($username, $password)) {
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
            $role = 'user';
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            try {
                $userModel = new UserModel($this->pdo);
                $userModel->createUser($username, $email, $hashedPassword, $role);
                header('Location: index.php');
                exit;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return null;
    }   
}
?>

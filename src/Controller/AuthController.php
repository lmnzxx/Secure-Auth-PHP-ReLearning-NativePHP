<?php

namespace Herya\SecureAuth\Controller;

use Herya\SecureAuth\Model\UserModel;

class AuthController {
    private $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../../config/db.php'; // Ensure the path is correct
        
        global $pdo;  // Access the global $pdo variable set in db.php
        $this->pdo = $pdo;  // Set the $pdo for the controller
    }

    public function login() {
        $errorMessage = ''; // Default error message is empty
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $userModel = new UserModel($this->pdo); // Pass PDO object to UserModel
            if ($userModel->checkCredentials($username, $password)) {
                header("Location: dashboard.php");
                exit;
            } else {
                $errorMessage = "Invalid credentials. Please try again!";
            }
        }

        return $errorMessage;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = 'user'; // Default role
            
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

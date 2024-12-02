<?php

namespace Herya\SecureAuth\Controller;

use Herya\SecureAuth\Model\UserModel;

class AuthController {
    private $pdo;

    // Constructor to initialize PDO and pass to UserModel
    public function __construct()
    {
        // Include the database connection
        require_once __DIR__ . '/../../config/db.php'; // Ensure the path is correct
        
        global $pdo;  // Access the global $pdo variable set in db.php
        $this->pdo = $pdo;  // Set the $pdo for the controller
    }

    public function login() {
        $errorMessage = ''; // Default error message is empty
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve login form data
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $userModel = new UserModel($this->pdo); // Pass PDO object to UserModel
            if ($userModel->checkCredentials($username, $password)) {
                // Redirect to the dashboard if credentials are correct
                header("Location: dashboard.php");
                exit;
            } else {
                // Set error message if credentials are invalid
                $errorMessage = "Invalid credentials. Please try again!";
            }
        }

        // Return the error message to be used in the view
        return $errorMessage;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = 'user'; // Default role
    
            try {
                // Coba membuat user
                $userModel = new UserModel($this->pdo);
                $userModel->createUser($username, $email, $password, $role);
    
                // Jika berhasil, arahkan ke halaman login
                header('Location: index.php');
                exit;
            } catch (\Exception $e) {
                // Tangkap exception dan tampilkan pesan error
                return $e->getMessage();
            }
        }
    
        return null;
    }    
}
?>

<?php

namespace Herya\SecureAuth\Model;

use PDO;

class UserModel {
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo; // Assign PDO to the instance
    }

    public function checkCredentials($username, $password) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && password_verify($password, $user['password']);
    }

    public function createUser($username, $email, $password, $role) {
        // Periksa apakah username sudah ada
        $checkStmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
        $checkStmt->execute([':username' => $username]);
        $exists = $checkStmt->fetchColumn();
    
        if ($exists > 0) {
            // Jika username sudah ada, lempar exception atau kembalikan pesan error
            throw new \Exception("Username sudah terdaftar.");
        }
    
        // Lanjutkan dengan proses insert jika username belum ada
        $sql = 'INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role,
        ]);
    }    
}
?>

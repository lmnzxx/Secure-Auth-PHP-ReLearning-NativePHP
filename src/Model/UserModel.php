<?php

namespace Herya\SecureAuth\Model;

use PDO;
use PDOException;

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
        try {
            // Insert data pengguna ke database
            $sql = 'INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
                ':role' => $role,
            ]);

            return true; // Berhasil
        } catch (PDOException $e) {
            // Tangani error duplicate entry berdasarkan constraint UNIQUE
            if ($e->getCode() == '23000') { // Kode error SQL untuk pelanggaran constraint
                if (strpos($e->getMessage(), 'username') !== false) {
                    throw new \Exception("Username tersebut sudah digunakan. Silakan pilih username lain.");
                }
                if (strpos($e->getMessage(), 'email') !== false) {
                    throw new \Exception("Email tersebut sudah terdaftar. Silakan gunakan email lain.");
                }
            }

            // Lempar error generik jika penyebabnya bukan duplicate entry
            throw new \Exception("Terjadi kesalahan saat mendaftarkan pengguna. Silakan coba lagi.");
        }
    }
}
?>

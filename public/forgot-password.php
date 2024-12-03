<?php
require_once __DIR__ . '/../src/Controller/AuthController.php';

use Herya\SecureAuth\Controller\AuthController;

$pdo = require __DIR__ . '/../config/db.php'; 
$authController = new AuthController();
$errorMessage = $authController->sendPasswordResetToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container" id="forgotPass">
        <h2 class="tittleForgot">Lupa Password</h2>
        
        <?php if ($errorMessage): ?>
            <div class="error">
                <p id="error-m"><?php echo htmlspecialchars($errorMessage); ?></p>
            </div>
        <?php endif; ?>

        <form action="forgot-password.php" method="POST">
            <div class="formForgot">
                <label for="email">Masukkan Email Anda</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Request Token Reset</button>
            </div>
        </form>

        <p>Sudah ingat password? <a href="index.php">Masuk di sini</a></p>
    </div>
</body>
</html>

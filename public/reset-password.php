<?php
require_once __DIR__ . '/../src/Controller/AuthController.php';

use Herya\SecureAuth\Controller\AuthController;

$pdo = require __DIR__ . '/../config/db.php'; 
$authController = new AuthController();
$errorMessage = $authController->resetPassword();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="public/assets/css/style.css">
</head>
<body>
    <div class="container" id="resetPass">
        <h2 class="tittleReset">Reset Password</h2>
        
        <?php if ($errorMessage): ?>
            <div class="error">
                <p class="error-m"><?php echo htmlspecialchars($errorMessage); ?></p>
            </div>
        <?php endif; ?>

        <form action="reset-password.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="token">Token Reset</label>
            <input type="text" id="token" name="token" required>

            <label for="new_password">Password Baru</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit">Reset Password</button>
        </form>

        <p>Kembali ke halaman <a href="index.php">Masuk</a></p>
    </div>
</body>
</html>

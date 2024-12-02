<?php
require_once __DIR__ . '/../src/Controller/AuthController.php';

use Herya\SecureAuth\Controller\AuthController;

$authController = new AuthController();
$errorMessage = $authController->login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<style>
    <?php
    include 'assets/css/styles.css';
    ?>
</style>
<body>
    <div id="login">
        <h2 class="tittle-login">Login</h2>

        <?php if ($errorMessage): ?>
            <div class="error-message" id="login-error">
                <p id="error-m"><?php echo $errorMessage; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <script src="assets/js/main.js"></script>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>

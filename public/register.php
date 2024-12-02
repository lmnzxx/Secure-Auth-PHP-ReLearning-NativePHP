<?php
require_once __DIR__ . '/../src/Controller/AuthController.php';

use Herya\SecureAuth\Controller\AuthController;

// Create an instance of the AuthController
$authController = new AuthController();
$errorMessage = $authController->register();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container" id="register">
        <h2 class="tittle-reg">Register</h2>

        <?php if ($errorMessage): ?>
            <div class="error-message">
                <p id="error-m"><?php echo htmlspecialchars($errorMessage); ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>
</body>
</html>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $adminUser = $_ENV['ADMIN_USER'];
    $adminPassword = $_ENV['ADMIN_PASSWORD'];
    // CSRF token generation
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CSRF token validation
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            echo '<div class="error">Invalid CSRF token.</div>';
        } else {
            // Dummy credentials for demonstration
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Use password_hash() and password_verify() in production
            if (hash_equals($adminUser, $username) && hash_equals($adminPassword, $password)) {
                require_once 'includes/JWT.php';
                $key = 'your-very-secret-key'; // Store securely
                $payload = [
                    'iss' => 'http://localhost',
                    'aud' => 'http://localhost',
                    'iat' => time(),
                    'exp' => time() + 3600,
                    'username' => $username
                ];
                $jwt = \Firebase\JWT\JWT::encode($payload, $key, 'HS256');
                setcookie('auth_token', $jwt, [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => true, // Set true if using HTTPS
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
                $_SESSION['user'] = $username;
                $_SESSION['auth_token'] = $jwt;
                header('Location: index.php');
                exit();
            } else {
                echo '<div class="error">Invalid username or password.</div>';
            }
        }
    }
    // CSRF token for form
    $csrf_token = $_SESSION['csrf_token'];
    ?>

    <style>
    body {
        background: linear-gradient(135deg, #6dd5ed, #2193b0);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-container {
        background: #fff;
        padding: 2rem 2.5rem;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(33,147,176,0.2);
        width: 350px;
    }
    .login-container h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #2193b0;
    }
    .login-container label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
    }
    .login-container input[type="text"],
    .login-container input[type="password"] {
        width: 100%;
        padding: 0.7rem;
        margin-bottom: 1rem;
        border: 1px solid #b2ebf2;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }
    .login-container input[type="text"]:focus,
    .login-container input[type="password"]:focus {
        border-color: #2193b0;
        outline: none;
    }
    .login-container button {
        width: 100%;
        padding: 0.7rem;
        background: #2193b0;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .login-container button:hover {
        background: #176a8c;
    }
    .error {
        background: #ffdddd;
        color: #d8000c;
        padding: 0.7rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        text-align: center;
    }
    .success {
        background: #ddffdd;
        color: #4f8a10;
        padding: 0.7rem;
        border-radius: 6px;
        margin-bottom: 1rem;
        text-align: center;
    }
    </style>

    <div class="login-container">
        <h2>Login</h2>
        <form method="post" autocomplete="off">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autofocus>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
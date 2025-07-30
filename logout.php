<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Unset CSRF token if set
if (isset($_COOKIE['csrf_token'])) {
    setcookie('csrf_token', '', time() - 3600, '/');
}

// Redirect to login page
header("Location: login.php");
exit();
?>

<?php
/**
 * Logout functionality - Securely terminates user session
 * Implements proper session cleanup to prevent session fixation attacks
 */

// Start session to access session variables
session_start();

// Clear all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect to home page after logout
header('Location: index.php');
exit();
?>
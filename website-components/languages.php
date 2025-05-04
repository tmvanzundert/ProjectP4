<?php
// Define available languages with their codes and names
$available_languages = [
    'nl' => 'Nederlands',
    'en' => 'English',
];

// Set default language
$default_language = 'nl';

// Initialize language from session or set default
session_start();
if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = $default_language;
}

// Handle language switching
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $available_languages)) {
    $_SESSION['language'] = $_GET['lang'];
    
    // Redirect back to the same page without the query parameter
    $redirect_url = strtok($_SERVER['REQUEST_URI'], '?');
    header("Location: $redirect_url");
    exit();
}

// Current language
$current_language = $_SESSION['language'];
?>
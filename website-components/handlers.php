<?php

session_start();

// Include the language configuration
require_once 'languages.php';

// Load language file
$lang_file = "languages/{$current_language}.php";
if (file_exists($lang_file)) {
    include_once $lang_file;
} else {
    include_once "languages/{$default_language}.php";
}

// Translation function
function __($key) {
    global $translations;
    
    if (isset($translations[$key])) {
        return $translations[$key];
    }
    
    // Return the key if translation is not found
    return $key;
}


// require_once 'scripts\php\importcsv.php';

// PDO Database connection
// require_once 'scripts/php/databaseconnection.php';
// $connection = new DatabaseConnection("localhost", "dbuser", "LkC9STj5n6bztQ", "plugandplay");
// $conn = $connection->connect();
?>
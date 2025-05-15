<?php
// Include the language configuration
require_once 'website-components/languages.php';

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
?>
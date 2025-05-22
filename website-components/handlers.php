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

// Function to handle CSV import
function importCSV($filename) {
    // Get a secure database connection
    $conn = getConnection();

    // Open the CSV file and skip the first line
    $file = fopen($filename, "r");
    fgetcsv($file, 10000, ",");

    // Prepare the SQL query
    $sql = "INSERT INTO Product (ProductName, Availability) VALUES (?, 1)
            ON DUPLICATE KEY UPDATE Availability = Availability + 1";
    $stmt = $conn->prepare($sql);
    // check if statement was prepared successfully
    $stmt->bind_param("s", $productName);
    // Loop through each row in the CSV and execute the statement
    while (($row = fgetcsv($file, 10000, ",")) !== false) {
        $productName = $row[0];
        $stmt->execute();
        if ($stmt->error) {
            echo "<script type=\"text/javascript\">
                    alert(\"Error importing data: " . $stmt->error . "\");
                    window.location = \"../admin-pagina.php\"
                  </script>";
            return;
        }
    }

    // Close the statement and connection
    $stmt->close();
    fclose($file);
    $conn->close();
    
    // Echo success message
    echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"../admin-pagina.php\"
          </script>";
}

// Database connection function
// Ik wil dit aanpassen dat er nog een locale gebruiker connectie maakt met de database of een specifieke gebruiker die enkel toegang heeft tot import rechten
function getConnection(): mysqli {
    $servername = $_ENV["DB_HOST"] ?? "localhost"; 
    $username = $_ENV["DB_USER"] ?? "dbuser";               
    $password = $_ENV["DB_PASSWORD"] ?? "LkC9STj5n6bztQ";
    $dbname = $_ENV["DB_NAME"] ?? "plugandplay";
    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    } catch (Exception $e) {
        echo "<script type=\"text/javascript\">alert(\"Failed to connect to the database. Check your configuration.\");
              window.location = \"../admin-pagina.php\"
              </script>";
    }
}

// Handle the form submission
if (isset($_POST["import"])) {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $filename = $_FILES["file"]["tmp_name"];
        importCSV($filename);
    } else {
        echo "<script type=\"text/javascript\">
                alert(\"Please upload a valid CSV file.\");
                window.location = \"../admin-pagina.php\"
              </script>";
    }
}
?>
<?php
function importCSV($filename) {
    // Get a secure database connection
    $conn = getConnection();
    
    // Open the CSV file
    $file = fopen($filename, "r");
    
    // Skip the header row (if it exists)
    fgetcsv($file, 10000, ",");
    
    // Prepare the SQL query
    $sql = "INSERT INTO Product (ProductName, Availability) VALUES (?, 1)
            ON DUPLICATE KEY UPDATE Availability = Availability + 1";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error); // Handle prepare error
    }
    
    // Bind parameters
    $stmt->bind_param("s", $productName);
    
    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
        // Validate data (example validation)
        if (count($getData) < 1) {
            error_log("Invalid CSV row: " . implode(",", $getData));
            continue; // Skip to the next row
        }
        
        // Assign values
        $productName = $getData[0]; // Assuming the first column contains the product name
        
        // Execute the query
        if (!$stmt->execute()) {
            error_log("Error inserting/updating row: " . $stmt->error);
        }
    }
    
    // Close the statement and connection
    $stmt->close();
    fclose($file);
    $conn->close();
    
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
        error_log("Database connection error: " . $e->getMessage()); // Log the error
        die("Failed to connect to the database. Check your configuration."); // Fatal error, stop execution
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
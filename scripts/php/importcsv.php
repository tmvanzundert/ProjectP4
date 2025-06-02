<?php require_once 'databaseconnection.php';

class importcsv extends DatabaseConnection
{


    // Function to handle CSV import
    public function importCSV($filename)
    {

        // Get a secure database connection
        // Set database connection parameters before connecting
        $conn = $this->connect();

        // Open the CSV file and skip the first line
        $file = fopen($filename, "r");
        fgetcsv($file, 10000, ",");

        // Prepare the SQL query
        $sql = "INSERT INTO Product (ProductName, Availability) VALUES (?, 1)
            ON DUPLICATE KEY UPDATE Availability = Availability + 1";
        $stmt = $conn->prepare($sql);

        // Loop through each row in the CSV and execute the statement
        while (($row = fgetcsv($file, 10000, ",")) !== false) {
            $productName = $row[0];
            if (!$stmt->execute([$productName])) {
                $errorInfo = $stmt->errorInfo();
                echo "<script type=\"text/javascript\">
                    alert(\"Error importing data: " . addslashes($errorInfo[2]) . "\");
                    window.location = \"../admin-pagina.php\"
                  </script>";
                fclose($file);
                return;
            }
        }

        // Close the file
        fclose($file);

        // Echo success message
        echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"../admin-pagina.php\"
          </script>";
    }
    
     // Handle the form submission
    public function formsubmission(): void
    {

        if ($this->isSubmitted() && isset($_POST["import"])) {
            if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
                $filename = $_FILES["file"]["tmp_name"];
                $this->importCSV($filename);
            } else {
                echo "<script type=\"text/javascript\">
                        alert(\"Please upload a valid CSV file.\");
                        window.location = \"../admin-pagina.php\"
                    </script>";
            }
        }

    }

    // Checks if the form is submitted
    public function isSubmitted(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
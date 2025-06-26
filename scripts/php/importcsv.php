-<?php
require_once 'framework/connector.php';

class importcsv
{

    public function importCSV($filename): string
    {

        try {
            $conn = new Connector();
        } 
        catch (Exception $e) {
            return "Connection failed";
        }


        // Open the CSV file and skip the first line
        $file = fopen($filename, "r");
        fgetcsv($file, 10000, ",");

        // Prepare the SQL query
        $sql = "UPDATE Product SET Availability = Availability + 1 WHERE ProductName = ?";
        $stmt = $conn->prepare($sql);

        // Loop through each row in the CSV and execute the statement
        while (($row = fgetcsv($file, 10000, ",")) !== false) {
            $productName = $row[0];
            if (!$stmt->execute([$productName])) {
                fclose($file);
                return "Error importing data: "  . addslashes($stmt->errorInfo()[2]);
            }
        }

        // Close the file
        fclose($file);
        return "CSV File has been successfully Imported.";
    }
    
    // Handle the form submission
    public function formsubmission(): void
    {

        if ($this->isSubmitted() && isset($_POST["import"])) {
            if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
                $filename = $_FILES["file"]["tmp_name"];
                $importCSV = $this->importCSV($filename);    
            } 
            else {
                $importCSV = "Please upload a valid CSV file.";
            }
            echo "<script type=\"text/javascript\">
                        alert(\"$importCSV\");
                        window.location = \"?view=admin-pagina\"
                    </script>";
        }

    }

    // Checks if the form is submitted
    private function isSubmitted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
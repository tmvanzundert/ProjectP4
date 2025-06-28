<?php
require_once 'framework/connector.php';

class CSV
{

    private array $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Imports CSV data and updates product availability
     * @param string $filename Path to uploaded CSV file
     * @return string Success or error message
     */
    public function Import($filename): string
    {
        // Establish database connection
        try {
            $conn = new Connector();
        } catch (Exception $e) {
            return "Connection failed";
        }

        // Open CSV file and skip header row
        $file = fopen($filename, "r");
        fgetcsv($file, 10000, ",");

        // Prepare the SQL query
        $sql = "UPDATE Product SET Availability = Availability + 1 WHERE ProductName = ?";
        $stmt = $conn->prepare($sql);

        // Loop through each row in the CSV and execute the statement
        while (($row = fgetcsv($file, 10000, ",")) !== false) {
            $productName = $row[0]; // Assuming first column contains product name
            
            // Execute update for each product
            if (!$stmt->execute([$productName])) {
                fclose($file);
                return "Error importing data: " . addslashes($stmt->errorInfo()[2]);
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
            if (isset($this->filename) && $this->filename["error"] == 0) {
                $filename = $this->filename["tmp_name"];
                $importCSV = $this->Import($filename);
            } else {
                $importCSV = "Please upload a valid CSV file.";
            }
            
            // Display result and redirect
            echo "<script type=\"text/javascript\">
                        alert(\"$importCSV\");
                        window.location = \"?view=admin-pagina\"
                    </script>";
        }
    }

    /**
     * Checks if form was submitted via POST method
     * @return bool True if POST request
     */
    private function isSubmitted(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
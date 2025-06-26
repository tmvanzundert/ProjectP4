<?php

require_once './scripts/php/importcsv.php';

use PHPUnit\Framework\TestCase;

class Importcsvtest extends TestCase {
    
    public function testimportcsv()  {
        // 1. Create a temporary CSV file
        $csvContent = "ProductName\nTestProduct";
        $tmpFile = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($tmpFile, $csvContent);

        // 2. Instantiate importcsv and call importCSV
        $this->assertFileExists('testdata/importcsvtestdata.csv',"given filename doesn't exists"); 
        $importCSV = new importcsv('testdata/importcsvtestdata.csv');
        $result = $importCSV->importCSV($tmpFile);

        // 3. Assert the result
        $this->assertEquals('CSV File has been successfully Imported.', $result);

        // 4. Clean up
        unlink($tmpFile);
    }
}
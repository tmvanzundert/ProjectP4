<?php

require_once './scripts/php/importcsv.php';

use PHPUnit\Framework\TestCase;

class Importcsvtest extends TestCase
{

    public function testimportcsv()
    {

        // 1. Instantiate importcsv and call importCSV
        $file = 'tests/testdata/importcsvtestdata.csv';
        $this->assertFileExists($file, "given filename doesn't exists");
        $importCSV = new importcsv($file);
        $result = $importCSV->importCSV($file);

        // 2. Assert the result
        $this->assertEquals('CSV File has been successfully Imported.', $result);

        // 3. Clean up
        unlink($file);
    }
}
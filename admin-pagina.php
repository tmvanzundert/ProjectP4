<?php require_once 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<?php include_once 'website-components/head.php'; ?>

<body>

    <?php include_once 'website-components/header.php'; ?>

    <?php

        // Create a new instance of the importcsv class and call the formsubmission method
        require_once 'scripts/php/importcsv.php';
        $env = parse_ini_file('./.env');
        $importCSV = new importcsv($env['db_servername'], $env['db_username'], $env['db_password'], $env['db_name']);
        $importCSV->formsubmission();

    ?>

    <div Class="csv-upload">
    <form action="" method="post" name="frmCSVImport" id="frmCSVImport"
        enctype="multipart/form-data" onsubmit="return validateFile()">
        <div Class="input-row">
            <label>Choose your file. <a href="website-components/import-template.csv" download>Download
                    template</a></label> 
            <input type="file" name="file" id="file" class="file" accept=".csv,.xls,.xlsx">
            <div class="import">
                <button type="submit" id="submit" name="import" class="btn-submit">Import
                    CSV and Save Data</button>
            </div>
        </div>
    </form>
    </div>


    <?php include_once 'website-components/footer.php'; ?>

</body>

</html>
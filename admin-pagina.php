<?php require 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>

    <div Class="csv-upload">
    <form action="website-components/handlers.php" method="post" name="frmCSVImport" id="frmCSVImport"
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


    <?php include 'website-components/footer.php'; ?>

</body>

</html>
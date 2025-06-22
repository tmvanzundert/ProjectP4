<?php

class Beheerder extends View
{

    public function show()
    {

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: ?view=login');
            exit;
        }

        ?>
        <div class="button-container">
            <button class="logout-button content-btn active"
                data-target="content1"><?php echo __('csv_import_btn'); ?></button>
            <button class="logout-button content-btn"
                data-target="content2"><?php echo __('search_management_btn'); ?></button>
            <button class="logout-button content-btn" data-target="content3"><?php echo __('upload_image_btn'); ?></button>
        </div>

        <div id="content1" class="content-block active">
            <?php
            // Create a new instance of the importcsv class and call the formsubmission method
            require_once 'scripts/php/importcsv.php';
            $env = parse_ini_file('.env');
            $importCSV = new importcsv($env['db_servername'], $env['db_username'], $env['db_password'], $env['db_name']);
            $importCSV->formsubmission();
            ?>

            <div Class="csv-upload">
                <form action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data"
                    onsubmit="return validateFile()">
                    <div Class="input-row">
                        <label><?php echo __('select_csv_label'); ?><a href="website-components/import-template.csv" download><?php echo __('select_csv_label_download'); ?></a></label>
                        <input type="file" name="file" id="file" class="file" accept=".csv,.xls,.xlsx">
                        <div class="import">
                            <button type="submit" id="submit" name="import" class="btn-submit"><?php echo __('csv_upload_button'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="content2" class="content-block">
            <h2>Content Block 2</h2>
        </div>

        <div id="content3" class="content-block">
            <?php
            require_once 'scripts/php/imageupload.php';
            $imageUpload = new ImageUpload();
            $imageUpload->formSubmission();
            $folders = $imageUpload->getImageFolders();
            ?>

            <div class="csv-upload">
                <form action="" method="post" name="frmImageUpload" id="frmImageUpload" enctype="multipart/form-data">
                    <div class="input-row">
                        <label><?php echo __('select_image_label'); ?></label>
                        <input type="file" name="imageFile" id="imageFile" class="file" accept=".jpg,.jpeg,.png,.gif">
                    </div>

                    <div class="input-row">
                        <label><?php echo __('select_folder_label'); ?></label>
                        <select name="targetFolder" class="textbox">
                            <?php foreach ($folders as $folder): ?>
                                <option value="<?php echo $folder; ?>"><?php echo $folder; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="import">
                        <button type="submit" id="upload" name="upload" class="btn-submit">
                            <?php echo __('upload_button'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('.content-btn');
                const contentBlocks = document.querySelectorAll('.content-block');

                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        buttons.forEach(btn => btn.classList.remove('active'));

                        // Add active class to clicked button
                        this.classList.add('active');

                        // Hide all content blocks
                        contentBlocks.forEach(block => block.classList.remove('active'));

                        // Show the target content block
                        const targetId = this.getAttribute('data-target');
                        document.getElementById(targetId).classList.add('active');
                    });
                });
            });
        </script>
        <?php
    }
}

new Beheerder();
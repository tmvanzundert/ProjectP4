<?php

require_once 'scripts/php/productdatasource.php';

class Beheerder extends View
{
    public function show()
    {
        // Ensure user is logged in and has admin privileges
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true && !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?view=login');
            exit;
        }

        if (isset($_POST['delete_product'])) {
            $productName = $_POST['delete_product'];
            $productDataSource = new ProductDataSource();
            $productDataSource->deleteProductLog($productName);
            header('Location: ?view=admin-pagina');
            exit;
        }

        ?>
        <!-- Admin dashboard navigation tabs -->
        <div class="button-container">
            <button class="logout-button content-btn active" data-target="content1"><?php echo __('csv_import_btn'); ?></button>
            <button class="logout-button content-btn" data-target="content2"><?php echo __('search_management_btn'); ?></button>
            <button class="logout-button content-btn" data-target="content3"><?php echo __('upload_image_btn'); ?></button>
        </div>
        
        <!-- CSV Import functionality tab -->
        <div id="content1" class="content-block active">
            <?php
            // Handle CSV file import for product updates
            require_once 'scripts/php/csv.php';
            if (isset($_FILES['file'])) {
                $importCSV = new CSV($_FILES['file']);
                $importCSV->formsubmission();
            }
            ?>

            <div Class="admin-pagina">
                <!-- CSV upload form with file validation -->
                <form action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data"
                    onsubmit="return validateFile()">
                    <div Class="input-row">
                        <label><?php echo __('select_csv_label'); ?><a href="website-components/import-template.csv"
                                download><?php echo __('select_csv_label_download'); ?></a></label>
                        <input type="file" name="file" id="file" class="file" accept=".csv,.xls,.xlsx">
                        <div class="import">
                            <button type="submit" id="submit" name="import"
                                class="btn-submit"><?php echo __('csv_upload_button'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Management functionality tab -->
        <div id="content2" class="content-block">
            <?php
            // Display logged search queries that returned no results
            $productDataSource = new ProductDataSource();
            $productLog = $productDataSource->getProductLog();
            
            if (empty($productLog)) {
                echo "<p>" . __('no_products_found') . "</p>";
            } else {
                // Display search log in table format with delete options
                echo "<table class='product-log-table admin-pagina'>";
                echo "<tr><th>" . __('product_name') . "</th><th>" . __('count') . "</th><th>" . __('timestamp') . "</th></tr>";
                foreach ($productLog as $logEntry) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($logEntry['ProductName']) . "</td>";
                    echo "<td>" . htmlspecialchars($logEntry['Count']) . "</td>";
                    echo "<td>" . htmlspecialchars($logEntry['Timestamp']) . "</td>";
                    // Individual delete form for each logged search
                    echo "<td>
                                <form method='post' action=''>
                                    <input type='hidden' name='delete_product' value='" . htmlspecialchars($logEntry['ProductName'], ENT_QUOTES) . "'>
                                    <button type='submit' class='btn-delete'>" . __('delete_button') . "</button>
                                </form>
                                </td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>

        <!-- Image Upload functionality tab -->
        <div id="content3" class="content-block">
            <?php
            // Handle image uploads to organized folders
            require_once 'scripts/php/imageupload.php';
            $imageUpload = new ImageUpload();
            $imageUpload->formSubmission();
            $folders = $imageUpload->getImageFolders();
            ?>

            <div class="admin-pagina">
                <!-- Image upload form with folder selection -->
                <form action="" method="post" name="frmImageUpload" id="frmImageUpload" enctype="multipart/form-data">
                    <div class="input-row">
                        <label><?php echo __('select_image_label'); ?></label>
                        <input type="file" name="imageFile" id="imageFile" class="file" accept=".jpg,.jpeg,.png,.gif">
                    </div>

                    <div class="input-row">
                        <label><?php echo __('select_folder_label'); ?></label>
                        <!-- Dynamic folder selection dropdown -->
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

        <!-- JavaScript for tab switching functionality -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.content-btn');
                const contentBlocks = document.querySelectorAll('.content-block');

                // Handle tab switching between admin functions
                buttons.forEach(button => {
                    button.addEventListener('click', function () {
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
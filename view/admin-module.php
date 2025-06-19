<?php

class AdminModule extends View
{

    public function show()
    {
        ?>
        <link rel="stylesheet" href="styles.css">
        <style>
            .content-block {
                display: none;
                padding: 20px;
                margin-top: 10px;
            }

            .content-block.active {
                display: block;
            }

            .button-container {
                margin-bottom: 20px;
                /* Center align the buttons */
                display: flex;
                justify-content: center;
                text-align: center;
            }

            /* Add some spacing between buttons */
            .content-btn {
                margin: 0 10px;
            }

            .content-btn.active {
                opacity: 0.8;
            }
        </style>
        </head>

        <body>
            <div class="button-container">
                <button class="logout-button content-btn active"
                    data-target="content1"><?php echo __('csv_import_btn'); ?></button>
                <button class="logout-button content-btn"
                    data-target="content2"><?php echo __('search_management_btn'); ?></button>
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
            </div>

            <div id="content2" class="content-block">
                <h2>Content Block 2</h2>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const buttons = document.querySelectorAll('.content-btn');
                    const contentBlocks = document.querySelectorAll('.content-block');

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

new AdminModule();
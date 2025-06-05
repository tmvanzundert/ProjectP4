<?php

    require 'website-components/handlers.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['search'] == "" ) ) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    
?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>
    <form class="search-form" action="" method="post">
        <div class="search">
            <input required type="search" name="search" placeholder="Search..." oninput="setErrorEmptyInputbox('search')">
            <button type="reset"></button>
            <a href="producten.php" class="reset-button" onclick="document.getElementsByName('search')[0].value = '';">Reset</a>
        </div>
        <button type="submit">Search</button>
    </form>
    <section class="section-producten">
        <div class="product-container">
            <?php
            
                require_once 'scripts/php/product.php';
                require_once 'scripts/php/productdatasource.php';

                $products = new ProductDataSource();
                if (isset($_POST['search'])) {
                    $products->searchProducts($_POST['search']);
                }
                else {
                    $products->getProducts();
                }

            ?>
        </div>
    </section>

    <?php include 'website-components/footer.php'; ?>

</body>

</html>
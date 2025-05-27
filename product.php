<?php require 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>

    <?php
            
        require_once 'scripts/php/product.php';
        require_once 'scripts/php/productdatasource.php';

        $products = new ProductDataSource();
        echo $products->defineProducts()[$_GET['product']]->createProduct(true);

    ?>

    <?php include 'website-components/footer.php'; ?>

</body>

</html>
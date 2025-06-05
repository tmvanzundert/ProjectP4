<?php require_once 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<?php include_once 'website-components/head.php'; ?>

<body>

    <?php include_once 'website-components/header.php'; ?>

    <?php
            
        require_once 'scripts/php/product.php';
        require_once 'scripts/php/productdatasource.php';

        $products = new ProductDataSource();
        echo $products->defineProducts()[$_GET['product']]->createProduct(true);

    ?>

    <?php include_once 'website-components/footer.php'; ?>

</body>

</html>
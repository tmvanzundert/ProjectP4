<?php

class ProductPage extends View
{
    public function show()
    {

        require_once 'scripts/php/product.php';
        require_once 'scripts/php/productdatasource.php';

        $products = new ProductDataSource();

        isset($_GET['product']) ? print ($products->defineProducts()[$_GET['product']]->createProductView(true)) : header("Location: ?view=producten");

    }
}

new ProductPage();
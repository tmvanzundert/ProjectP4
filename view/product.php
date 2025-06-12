<?php

class ProductPage extends View
{
    public function show()
    {

        require_once 'scripts/php/product.php';
        require_once 'scripts/php/productdatasource.php';

        $products = new ProductDataSource();
        echo $products->defineProducts()[$_GET['product']]->createProduct(true);

    }
}

new ProductPage();
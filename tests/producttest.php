<?php

    require_once 'scripts/php/product.php';
    require_once 'scripts/php/productdatasource.php';

    class ProductTest extends PHPUnit\Framework\TestCase {

        public function testCreatedProduct() {
            
            $productDataSource = new ProductDataSource();
            $product = $productDataSource->defineProducts()['playgreen_1'];

            $this->assertInstanceOf(Product::class, $product);
            $this->assertEquals('PlayGreen 1', $product->getName());
            $this->assertEquals('De PlayGreen 1, is een kleine powerbank die zijn kenmerken heeft in het snel laden en het zijn van een licht gewicht. Met deze powerbank laat jij snel je telefoon op als je die snel nodig heb! Is jouw telefoon bijna leeg? Huur dan snel de PlayGreen 1.', $product->getDescription());
            $this->assertEquals(8, $product->getPrice());
            $this->assertEquals('images/producten/PlayGreen-1.jpg', $product->getImagePath());

            $this->assertEquals('playgreen_1', $product->getSimpleName());
            $this->assertEquals('playgreen 1', $product->getSearchableName());
            
        }

    }

?>
<?php

    class ProductDataSource {

        public function defineProducts(): array {
            return [
                'playgreen_1' => new Product(
                    __('playgreen1_heading'),
                    __('playgreen1_intro'),
                    8,
                    'images/producten/PlayGreen-1.jpg',
                    explode(', ', __('playgreen1_gebruik')),
                    explode(', ', __('playgreen1_kenmerken')),
                    __('playgreen1_kosten')
                ),
                'playgreen_2' => new Product(
                    __('playgreen2_heading'),
                    __('playgreen2_intro'),
                    8,
                    'images/producten/PlayGreen-2.jpg',
                    explode(', ', __('playgreen2_gebruik')),
                    explode(', ', __('playgreen2_kenmerken')),
                    __('playgreen2_kosten')
                ),
                'playgreen_3' => new Product(
                    __('playgreen3_heading'),
                    __('playgreen3_intro'),
                    8,
                    'images/producten/PlayGreen-3.jpg',
                    explode(', ', __('playgreen3_gebruik')),
                    explode(', ', __('playgreen3_kenmerken')),
                    __('playgreen3_kosten')
                ),
            ];
        }

        public function getProducts(bool $FullPage = false): void {

            $products = self::defineProducts();
            foreach ($products as $product) {
                echo $product->createProductView($FullPage);
            }
        }

        private function logMissingProduct(string $productName): void {
            $db = new Connector();
            $string = "INSERT INTO LogProduct (ProductName) VALUES ('$productName')";
            $db->execute($string);
        }

        public function searchProducts(string $Search): void {
            $products = self::defineProducts();
            $count = 0;
            foreach ($products as $product) {
                if (strpos($product->getSearchableName(), strtolower($Search)) !== false) {
                    echo $product->createProductView();
                    $count++;
                }
            }

            if ($count === 0) {
                $this->logMissingProduct($Search);
            }
        }
    }

?>
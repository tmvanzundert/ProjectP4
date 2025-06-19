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

            $products = $this->defineProducts();
            foreach ($products as $product) {
                echo $product->createProductView($FullPage);
            }
        }

        private function getProductLog() {
            $db = new Connector();
            $string = "SELECT ProductName, Count FROM LogProduct";
            $result = $db->fetchAll($string);
            return $result;
        }

        private function logMissingProduct(string $productName): void {

            $db = new Connector();
            $loggedProducts = $this->getProductLog();
            if (is_iterable($loggedProducts)) {
                foreach ($loggedProducts as $loggedProduct) {
                    if ($loggedProduct['ProductName'] === $productName) {
                        // If the product is already logged, increment the count
                        $string = "UPDATE LogProduct SET Count = Count + 1 WHERE ProductName = '$productName'";
                        $db->execute($string);
                        return;
                    }
                }
            }

            $string = "INSERT INTO LogProduct (ProductName) VALUES ('$productName')";
            $db->execute($string);
        }

        public function searchProducts(string $Search): void {
            $products = $this->defineProducts();
            $count = 0;
            foreach ($products as $product) {
                if (strpos($product->getSearchableName(), strtolower($Search)) !== false) {
                    echo $product->createProductView();
                    $count++;
                }
            }

            if ($count === 0) {
                $this->logMissingProduct($Search);
                echo "<p class='error-message'>" . __('productNotFound') . "</p>";
            }
        }
    }

?>
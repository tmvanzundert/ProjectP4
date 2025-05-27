<?php

    class ProductDataSource {

        public static function defineProducts() {
            return [
                'playgreen_1' => new Product(
                    'PlayGreen 1',
                    'De PlayGreen 1, is een kleine powerbank die zijn kenmerken heeft in het snel laden en het zijn van een licht gewicht. Met deze powerbank laat jij snel je telefoon op als je die snel nodig heb! Is jouw telefoon bijna leeg? Huur dan snel de PlayGreen 1.',
                    8,
                    'images/producten/PlayGreen-1.jpg',
                    ['Smartphone'],
                    [
                        'Snellader',
                        'Licht in gewicht',
                        'Zakformaat',
                        '5.000 mAh'
                    ],
                    "Te huren voor 8 euro!
                     De powerbank mag je vier dagen houden voor deze prijs.
                     Hierna geldt een bedrag van 2 euro per dag dat je extra moet betalen.
                     Is je powerbank leeg en wil je een volle? Dit kan, dit kost 2 euro extra.
                     Inleveren na maximaal 30 dagen!! Hierna moet de powerbank overgekocht worden."
                ),
                'playgreen_2' => new Product(
                    'PlayGreen 2',
                    'De PlayGreen 2, is een powerbank die zijn kenmerken heeft in het snel en draadloos laden en kan een dag mee.
                     Met deze powerbank laat jij snel je telefoon, tablet of andere mobiele apparaat op als je die snel nodig heb!<br>
                     Is jouw mobiele apparaat bijna leeg? Huur dan snel de PlayGreen 2.',
                    8,
                    'images/producten/PlayGreen-2.jpg',
                    ['Smartphone', 'Tablet', 'Ander mobiel apparaat'],
                    [
                        'Snel en draadloos laden',
                        'Past in een broekzak of kleine tas',
                        'Gaat een dag mee',
                        '10.000 mAh'
                    ],
                    "Te huren voor 8 euro!
                     De powerbank mag je vier dagen houden voor deze prijs.
                     Hierna geldt een bedrag van 2 euro per dag dat je extra moet betalen.
                     Is je powerbank leeg en wil je een volle? Dit kan, dit kost 2 euro extra.
                     Inleveren na maximaal 30 dagen!! Hierna moet de powerbank overgekocht worden."
                ),
                'playgreen_3' => new Product(
                    'PlayGreen 3',
                    'De PlayGreen 3, is een powerbank die zijn kenmerken heeft in het snel en draadloos laden en kan een dag mee.
                     Met deze powerbank laat jij snel je telefoon, tablet of andere mobiele apparaat op als je die snel nodig heb!<br>
                     Is jouw mobiele apparaat bijna leeg? Huur dan snel de PlayGreen 3.',
                    8,
                    'images/producten/PlayGreen-3.jpg',
                    ['Smartphone', 'Tablet', 'Ander mobiel apparaat', 'Jump start voor auto of scooter'],
                    [
                        'USB-C',
                        'Formaat kan wijzigen',
                        'Gaat meerdere dagen mee',
                        '27.000 mAh'
                    ],
                    "Te huren voor 8 euro!
                     De powerbank mag je vier dagen houden voor deze prijs.
                     Hierna geldt een bedrag van 2 euro per dag dat je extra moet betalen.
                     Is je powerbank leeg en wil je een volle? Dit kan, dit kost 2 euro extra.
                     Inleveren na maximaal 30 dagen!! Hierna moet de powerbank overgekocht worden."
                ),
            ];
        }
        
        public function getProducts(bool $FullPage = false) {
        
            $products = self::defineProducts();
            foreach ($products as $product) {
                echo $product->createProduct($FullPage);
            }
        }

        public function searchProducts(string $Search) {
            $products = self::defineProducts();
            foreach ($products as $product) {
                if (strpos($product->getSearchableName(), strtolower($Search)) !== false) {
                    echo $product->createProduct();
                }
            }
        }
    }

?>
<?php

class Producten extends View
{
    public function show()
    {

        require_once 'website-components/handlers.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['search'] == "")) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

        ?>

        <form class="search-form" action="" method="post">
            <div class="search">
                <input required type="search" name="search" placeholder="Search..." oninput="setErrorEmptyInputbox('search')">
                <button type="reset"></button>
                <button type="submit">Search</button>
                <a href="?view=producten" class="reset-button"
                    onclick="document.getElementsByName('search')[0].value = '';">Reset</a>
            </div>
        </form>
        <section class="section-producten">
            <div class="product-container">
                <?php

                require_once 'scripts/php/product.php';
                require_once 'scripts/php/productdatasource.php';

                $products = new ProductDataSource();
                if (isset($_POST['search'])) {
                    $products->searchProducts($_POST['search']);
                } else {
                    $products->getProducts();
                }

                ?>
            </div>
        </section>

        <?php
    }
}

new Producten();
<?php

require_once 'scripts/php/productdatasource.php';
require_once 'scripts/php/product.php';
require_once 'scripts/php/mail.php';
require_once 'scripts/php/User.php';

class Winkelwagen extends View
{

    public function show()
    {

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: ?view=login');
            exit;
        }
        
        ?>
        <?php
        // Initialize basket if not set
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        // Handle add, subtract, and delete actions
        if (isset($_GET['action']) && isset($_GET['product'])) {
            $product = $_GET['product'];
            switch ($_GET['action']) {
            case 'add':
                // Only allow increment via plus button
                if (isset($_SESSION['basket'][$product])) {
                    $_SESSION['basket'][$product]++;
                }
                break;
            case 'subtract':
                if (isset($_SESSION['basket'][$product])) {
                    $_SESSION['basket'][$product]--;
                    if ($_SESSION['basket'][$product] <= 0) {
                        unset($_SESSION['basket'][$product]);
                    }
                }
                break;
            case 'delete':
                unset($_SESSION['basket'][$product]);
                break;
            }
        }

        // Add product immediately if "product" param is present and not already in basket
        if (isset($_GET['product']) && $_GET['product'] !== '' && !isset($_GET['action'])) {
            $product = $_GET['product'];
            if (!isset($_SESSION['basket'][$product])) {
                $_SESSION['basket'][$product] = 1;
            }
        }

        $productDataSource = new ProductDataSource();

        ?>

        <h2><?= __('bk_title') ?></h2>
        <?php if ($_SESSION['orderSuccess']): ?>
            <p><?= __('bk_order_success') ?></p>
            <?php $_SESSION['orderSuccess'] = null; ?>
        <?php elseif ($_SESSION['orderSuccess'] === false): ?>
            <p><?= __('bk_order_failed') ?></p>
        <?php elseif (empty($_SESSION['basket'])): ?>
            <p><?= __('bk_empty') ?></p>
        <?php else: ?>
            <?php
            // Handle checkout POST request here if needed
            if (!isset($_POST['checkout']) && $_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
            <form method="post" action="">
                <table>
                <tr>
                    <th><?= __('bk_product') ?></th>
                    <th><?= __('bk_quantity') ?></th>
                    <th><?= __('bk_actions') ?></th>
                </tr>
                <?php foreach ($_SESSION['basket'] as $product => $aantal): ?>
                    <tr>
                        <td><?= $productDataSource->getName($product) ?></td>
                        <td><?= $aantal ?></td>
                        <td>
                            <a href="?view=winkelwagen&action=add&product=<?= urlencode($product) ?>">+</a>
                            <a href="?view=winkelwagen&action=subtract&product=<?= urlencode($product) ?>">-</a>
                            <a href="?view=winkelwagen&action=delete&product=<?= urlencode($product) ?>"><?= __('bk_delete') ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>
                <button type="submit" name="checkout"><?= __('bk_checkout') ?></button>
            </form>
            <?php else: ?>

                <?php

                    $user = new User($_SESSION['username'], '', '');
                    $name = $user->getName();

                    $message = "
                        <h2>Nieuwe bestelling van " . $name . "</h2>
                        <p>Hieronder de producten die " . $name . " besteld heeft:</p>
                        <table>
                            <tr>
                                <th>Product</th>
                                <th>Aantal</th>
                            </tr>";
                    foreach ($_SESSION['basket'] as $product => $aantal) {
                        $message .= "
                            <tr>
                                <td>" . $productDataSource->getName($product) . "</td>
                                <td>" . $aantal . "</td>
                            </tr>";
                    }
                    $message .= "
                        </table>
                    ";
                    $mail = new Mail($name, "New order from " . $_SESSION['username'], $message);
                    if ($mail->SendMail()) {
                        $_SESSION['orderSuccess'] = true;
                        unset($_SESSION['basket']); // Clear basket after successful order
                        if ($user->isSubmitted()) {
                            header("Location: ?view=winkelwagen");
                            exit;
                        }
                    } else {
                        $_SESSION['orderSuccess'] = false;
                    }
                ?>

            <?php endif; ?>
        <?php endif; ?>
        <?php
    }
}

new Winkelwagen();
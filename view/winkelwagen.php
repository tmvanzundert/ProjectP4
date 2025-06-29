<?php

require_once 'scripts/php/productdatasource.php';
require_once 'scripts/php/product.php';
require_once 'scripts/php/mail.php';
require_once 'scripts/php/User.php';

/**
 * Winkelwagen (Shopping Cart) class - Handles shopping cart operations
 * Manages cart items, quantities, and order processing with email notifications
 */
class Winkelwagen extends View
{
    public function show()
    {

        if (!isset($_SESSION['orderSuccess'])) {
            $_SESSION['orderSuccess'] = null; // Initialize order success status
        }

        // Security check: Ensure user is logged in before accessing cart
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: ?view=login');
            exit;
        }

        ?>
        <?php
        // Initialize shopping cart session if not already set
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        // Handle cart item quantity modifications and deletions
        if (isset($_GET['action']) && isset($_GET['product'])) {
            $product = $_GET['product'];
            switch ($_GET['action']) {
                case 'add':
                    // Increment quantity via plus button
                    if (isset($_SESSION['basket'][$product])) {
                        $_SESSION['basket'][$product]++;
                    }
                    break;
                case 'subtract':
                    // Decrement quantity, remove if reaches zero
                    if (isset($_SESSION['basket'][$product])) {
                        $_SESSION['basket'][$product]--;
                        if ($_SESSION['basket'][$product] <= 0) {
                            unset($_SESSION['basket'][$product]);
                        }
                    }
                    break;
                case 'delete':
                    // Remove item completely from cart
                    unset($_SESSION['basket'][$product]);
                    break;
            }
        }

        // Add product immediately if "product" param is present and not already in basket
        if (isset($_GET['product']) && $_GET['product'] !== '' && !isset($_GET['action'])) {
            $product = $_GET['product'];
            // Only add if not already in cart to prevent duplicates
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
                                    <!-- Quantity control buttons -->
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
                
                // Add each cart item to email
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
                
                // Send order confirmation email
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
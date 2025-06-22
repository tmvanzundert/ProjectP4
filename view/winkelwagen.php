<?php

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

        // Show basket contents (always show)
        echo '<h2>Winkelwagen</h2>';
        if (empty($_SESSION['basket'])) {
            echo '<p>Je winkelwagen is leeg.</p>';
        } else {
            echo '<table>';
            echo '<tr><th>Product</th><th>Aantal</th><th>Acties</th></tr>';
            foreach ($_SESSION['basket'] as $product => $aantal) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($product) . '</td>';
                echo '<td>' . $aantal . '</td>';
                echo '<td>
                    <a href="?view=winkelwagen&action=add&product=' . urlencode($product) . '">+</a>
                    <a href="?view=winkelwagen&action=subtract&product=' . urlencode($product) . '">-</a>
                    <a href="?view=winkelwagen&action=delete&product=' . urlencode($product) . '">Verwijder</a>
                </td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        ?>
        <?php
    }
}

new Winkelwagen();
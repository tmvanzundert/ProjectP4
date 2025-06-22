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
    }
}

new Winkelwagen();
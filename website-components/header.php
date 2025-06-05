<header>
    <!-- Display the logo and the navbar at the top of the website -->
    <img src="./images/header/logo.png" alt="Logo Plug & Play">
    <nav>
        <ul>
            <?php
            // Define navigation links
            $navLinks = [
                __('nav_home') => 'index.php',
                __('nav_about') => 'over-ons.php',
                __('nav_products') => 'producten.php',
                __('nav_contact') => 'contact.php',
                __('nav_Admin') => 'admin-pagina.php',
                __('nav_login') => 'login.php'
            ];

            // Render navigation links
            foreach ($navLinks as $label => $url): ?>
                <li><a href="<?= $url ?>" aria-label="<?= strtolower($label) ?>"><?= $label ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Language switcher -->
    <div id="language-switcher">
        <?php foreach ($available_languages as $code => $name): ?>
            <a href="?lang=<?= $code ?>" class="lang-option <?= $current_language === $code ? 'active' : '' ?>" title="<?= $name ?>">
                <?= $code ?>
            </a>
        <?php endforeach; ?>
    </div>
</header>
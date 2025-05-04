<header>
    <!-- Display the logo and the navbar at the top of the website -->
    <img class="header-logo" src="./images/header/logo.png" alt="Logo Plug & Play">
    <nav class="header-links">
        <ul>
            <?php 
            // Define navigation links
            $navLinks = [
                __('nav_home') => 'index.php',
                __('nav_about') => 'over-ons.php',
                __('nav_products') => 'producten.php',
                __('nav_contact') => 'contact.php'
            ];

            // Render navigation links
            foreach ($navLinks as $label => $url): ?>
                <li><a href="<?= $url ?>" aria-label="<?= strtolower($label) ?>"><?= $label ?></a></li>
            <?php endforeach; ?>
        </ul>
    </nav>
    
    <!-- Language switcher -->
    <div class="language-switcher">
        <?php foreach ($available_languages as $code => $name): ?>
            <a href="?lang=<?= $code ?>" class="lang-option <?= $current_language === $code ? 'active' : '' ?>" title="<?= $name ?>">
                <?= $code ?>
            </a>
        <?php endforeach; ?>
    </div>
</header>
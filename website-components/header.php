<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
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
            ];
            if (isset($_SESSION['username'])) {
                $navLinks[__('nav_admin')] = 'admin-pagina.php';
            }
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
        <?php if (isset($_SESSION['username'])): ?>
            <a class="log-btn" href="logout.php">Logout</a>
        <?php else: ?>
            <a class="log-btn" href="login.php"><?php echo __('nav_login'); ?></a>
        <?php endif; ?>
    </div>
</header>
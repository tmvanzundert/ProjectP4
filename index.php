<?php
// Set include path for relative imports and include required framework files
set_include_path('./' . PATH_SEPARATOR . '../');
require_once 'website-components/handlers.php';
require_once 'framework/controller.php';
require_once 'framework/connector.php';
require_once 'framework/view.php';

// Get the requested view from URL parameter, default to 'home' if not set
$view = filter_input(INPUT_GET, 'view') ?? 'home';
// Store current view in session for potential use across requests
$_SESSION['view'] = $view;

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Metadata tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Huur een powerbank bij de populairste events in Nederland. Altijd Opgeladen, Altijd Onderweg.">
    <!-- Dynamic page title based on current view -->
    <title><?= ucfirst(strtolower($view)); ?> - Plug & Play</title>

    <!-- Import the Style and JavaScript functions -->
    <link rel="stylesheet" href="css/main.css">

    <script src="scripts/js/info.js"></script>
</head>

<body>

    <header>
        <!-- Display the logo and the navbar at the top of the website -->
        <a href="?view=home" aria-label="Home">
            <img src="images/header/logo.png" alt="Logo Plug & Play" class="logo">
        </a>
        <nav>
            <ul>
                <?php
                // Define base navigation links available to all users
                $navLinks = [
                    __('nav_home') => 'home',
                    __('nav_about') => 'over-ons',
                    __('nav_products') => 'producten',
                    __('nav_contact') => 'contact',
                ];

                // Add cart link if user has items in basket
                if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
                    $navLinks[__('nav_cart')] = 'winkelwagen';
                }

                // Add account link for logged-in users
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    $navLinks[$_SESSION['username']] = 'account';
                }

                // Add admin panel link for admin users
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                    $navLinks[__('nav_admin')] = 'admin-pagina';
                }

                // Render navigation links dynamically
                foreach ($navLinks as $navLabel => $navItem): ?>
                        <li>
                            <a href="?view=<?= $navItem ?>" aria-label="<?= strtolower($navLabel) ?>"><?= $navLabel ?></a>
                        </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <!-- Language switcher and authentication controls -->
        <div id="language-switcher">
            <!-- Render available language options -->
            <?php foreach ($available_languages as $code => $name): ?>
                    <a href="?lang=<?= $code ?>" class="lang-option <?= $current_language === $code ? 'active' : '' ?>"
                        title="<?= $name ?>">
                        <?= $code ?>
                    </a>
            <?php endforeach; ?>
            
            <!-- Display logout button for authenticated users, login button for guests -->
            <?php if (isset($_SESSION['username'])): ?>
                    <a class="log-btn" href="?view=logout"><?php echo __('nav_logout'); ?></a>
            <?php else: ?>
                    <a class="log-btn" href="?view=login"><?php echo __('nav_login'); ?></a>
            <?php endif; ?>
        </div>
        </header>

    <main>
        <?php
        // Dynamically include the requested view based on URL parameter
        require_once "view/{$view}.php";
        ?>
    </main>

    <footer>
        <!-- Footer: Add copyright message and social links -->
        <p>
            <!-- Dynamic copyright year using JavaScript -->
            &copy; <span id="copyrightYear">
                <script>document.getElementById('copyrightYear').textContent = new Date().getFullYear();</script>
            </span> Plug & Play. <?= __('copyright') ?>.
        </p>
        <div class="social-icons">
            <?php
            // Define social media platform links
            $socialLinks = [
                'facebook' => 'https://www.facebook.com',
                'youtube' => 'https://www.youtube.com',
                'instagram' => 'https://www.instagram.com',
                'linkedin' => 'https://www.linkedin.com'
            ];
            // Generate social media icons with links
            foreach ($socialLinks as $platform => $url): ?>
                    <a href="<?= $url ?>" target="_blank" aria-label="<?= ucfirst($platform) ?>">
                        <img src="images/footer/<?= $platform ?>-icon.png" alt="<?= ucfirst($platform) ?>" class="social-icon">
                    </a>
            <?php endforeach; ?>
        </div>
    </footer>

</body>

</html>
<?php require 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>

    <main>

        <!-- Display the welcome banner (SECTION 3) -->
        <section class="home-banner">
            <h1><?php echo __('welcome'); ?></h1>
        </section>

        <!-- Introduction description (SECTION 3.1) -->
        <section class="section-introduction">
            <div class="introduction-box">
                <h2><?php echo __('introduction_heading'); ?></h2>
                <p><?php echo __('introduction_text1'); ?></p>
                <p><?php echo __('introduction_text2'); ?></p>
                <p><?php echo __('introduction_text3'); ?></p>
                <P><?php echo __('introduction_text4'); ?></p>
            </div>
            <div class="introduction-img" id="Slideshow">
                <img id="introImage" src="Images/Home/Powerbank2.png" alt="Achtergrond met powerbank">
            </div>
        </section>


        <!-- The salespitch of why people have to choose us (SECTION 3.2) -->
        <section class="section-feature">
            <div class="feature-box">
                <h3><?php echo __('salespitch_heading1'); ?></h3>
                <p><?php echo __('salespitch_text1'); ?></p>
            </div>
            <div class="feature-box">
                <h3><?php echo __('salespitch_heading2'); ?></h3>
                <p><?php echo __('salespitch_text2'); ?></p>
            </div>
            <div class="feature-box">
                <h3><?php echo __('salespitch_heading3'); ?></h3>
                <p><?php echo __('salespitch_text3'); ?></p>
            </div>
            <div class="feature-box">
                <h3><?php echo __('salespitch_heading4'); ?></h3>
                <p><?php echo __('salespitch_text4'); ?></p>
            </div>
        </section>

    </main>

    <?php include 'website-components/footer.php'; ?>

</body>

</html>
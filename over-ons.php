<?php require 'website-components/handlers.php'; ?>

<!DOCTYPE html>
<html>

<?php include 'website-components/head.php'; ?>

<body>

    <?php include 'website-components/header.php'; ?>

    <main>

        <!-- Describe our mission (SECTION 4) -->
        <section class="visie-banner">
            <h1><?php echo __('visie_heading'); ?></h1>
            <div class="visie-box">
                <p><?php echo __('visie_text1'); ?></p>
            </div>
        </section>

        <!-- Duurzaamheid (SECTION 4.1) -->
        <section class="section-duurzaamheid">
            <div class="duurzaamheid-box">
                <h2><?php __('duurzaamheid_heading'); ?></h2>
                <p><?php echo __('duurzaamheid_text1'); ?></p>
            </div>
            <div class="duurzaamheid-img">
                <img src="Images/Over-Ons/cube.png" alt="Achtergrond van een kubus die staat voor duurzaamheid">
            </div>
        </section>

        <!-- Over de oprichters (SECTION 4.2) -->
        <section class="section-oprichters">
            <div class="oprichters-box">
                <h2><?php echo __('oprichters_heading'); ?></h2>
                <p><?php echo __('oprichters_text1'); ?></p>
            </div>

            <div class="oprichters-img">
                <img src="Images/Over-Ons/Person1.png">
                <h2><?php echo __('lucas_heading'); ?></h2>
                <P><?php echo __('lucas_text1'); ?></P>
            </div>
            <div class="oprichters-img">
                <img src="Images/Over-Ons/Person2.png">
                <h2><?php echo __('peter_heading'); ?></h2>
                <P><?php echo __('peter_text1'); ?></P>
            </div>
            <div class="oprichters-img">
                <img src="Images/Over-Ons/Person3.png">
                <h2><?php echo __('tom_heading'); ?></h2>
                <P><?php echo __('tom_text1'); ?></P>
            </div>
            <div class="oprichters-img">
                <img src="Images/Over-Ons/Person4.png">
                <h2><?php echo __('joris_heading'); ?></h2>
                <P><?php echo __('joris_text1'); ?></P>
            </div>
        </section>

    </main>

    <?php include 'website-components/footer.php'; ?>

</body>

</html>
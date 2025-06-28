<?php

require_once 'scripts/php/User.php';

class Beheerder extends View
{
    public function show()
    {
        // Retrieve current user's details from database
        $user = new User($_SESSION['username'], '', '');
        $userDetails = $user->getUserDetails();
        ?>

        <!-- User account details table -->
        <table class="user-details-table">
            <tbody>
                <?php foreach ($userDetails as $key => $value):
                    $name = preg_replace('/(?<!\ )[A-Z]/', ' $0', $key);

                    if ($key === 'Password') {
                        ?>
                        <tr class="user-detail">
                            <td><label>Password:</label></td>
                            <td><span>********</span></td>
                        </tr>
                        <?php
                        continue;
                    }
                    ?>
                    <!-- Display other user fields -->
                    <tr class="user-detail">
                        <td><label><?php echo htmlspecialchars($name); ?>:</label></td>
                        <td><span><?php echo htmlspecialchars($value); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
    }
}

new Beheerder();
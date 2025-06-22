<?php

require_once 'scripts/php/User.php';

class Beheerder extends View
{

    public function show()
    {

        $user = new User($_SESSION['username'], '', '');
        $userDetails = $user->getUserDetails();
    ?>

        <table class="user-details-table">
            <tbody>
            <?php foreach ($userDetails as $key => $value) :
            $name = preg_replace('/(?<!\ )[A-Z]/', ' $0', $key);

            if ($key === 'Password') {
                ?>
                <tr class="user-detail">
                <td><label>Password:</label></td>
                <td><span>********</span></td>
                <!-- <td>
                    <form method="post" action="" style="display:inline;">
                    <button type="submit" name="edit_field" value="Password">Change</button>
                    </form>
                </td> -->
                </tr>
                <?php
                continue;
            }
            ?>
            <tr class="user-detail">
                <td><label><?php echo htmlspecialchars($name); ?>:</label></td>
                <td><span><?php echo htmlspecialchars($value); ?></span></td>
                <!-- <td>
                <form method="post" action="" style="display:inline;">
                    <button type="submit" name="edit_field" value="<?php echo htmlspecialchars($key); ?>">Change</button>
                </form>
                </td> -->
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php
    }
}

new Beheerder();
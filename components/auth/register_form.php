<?php

?>

<form class="column" action="index.php" method="POST" style="min-height: 100%; gap: 16px;">
    <h1>Register</h1>
    <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>">
    <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
    <input type="password" name="password" placeholder="Password" value="<?php echo $password ?>">
    <span class="text-error"> <?php echo $err ?> </span>
    <input style="width: 12rem;" type="submit" value="Register" class="btn-main">
</form>

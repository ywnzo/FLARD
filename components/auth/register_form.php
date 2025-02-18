<?php

?>

<form class="column" action="auth.php?method=register" method="POST">
    <h1>Register</h1>
    <div class="row">
        <div class="column" style="gap: 8px;">
            <input type="text" name="username" placeholder="Username" value="<?php echo $username ?>">
            <span class="text-error"> <?php echo $nameErr ?> </span>
        </div>
        <div class="column" style="gap: 8px;">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
            <span class="text-error"> <?php echo $emailErr ?> </span>
        </div>

        <div class="column" style="gap: 8px;">
            <input type="password" name="password" placeholder="Password" value="<?php echo $password ?>">
            <span class="text-error"> <?php echo $passwordErr ?> </span>
        </div>


    </div>
    <input type="submit" value="Register" class="btn-main">
    <a href="auth.php?method=login">Already have an account</a>


</form>
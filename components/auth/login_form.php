<form class="column" action="auth.php?method=login" method="POST">
    <h1>Login</h1>
    <div class="row">
        <div class="column" style="gap: 8px;">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
            <span class="text-error"> <?php echo $emailErr ?> </span>
        </div>
        <div class="column" style="gap: 8px;">
            <input type="password" name="password" placeholder="Password" value="<?php echo $password ?>">
            <span class="text-error"> <?php echo $passwordErr ?> </span>
        </div>
    </div>

    <input type="submit" value="Login" class="btn-main">
    <a href="auth.php?method=register">Create a new account</a>
</form>
<?php
include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

if(isset($_GET['url'])) {
    $id = $_GET['url'];
    $url = DB::select('original', 'urls', "short = '$id'");
    if($url) {
        $url = $url['original'];
        header("Location: $url");
    }
}

?>

<?php include('components/menu.php') ?>

<div class="site">
    <div class="column content-wrapper">
        <?php if(!$authOK): ?>
            <div style="margin-top: 4%;">
                <h1 class="title-main" style="text-align: center;">FLARD</h1>
                <!-- <h2>Create flash cards!</h2> -->
                <div class="row" style="justify-content: center;">
                    <a href="auth.php?method=login" class="btn-main">Login</a>
                    <a href="auth.php?method=register" class="btn-main">Register</a>
                </div>
            </div>
            
        <?php else: ?>
            <div class="row">
                <div class="spacer-row">
                    <div class="row">
                        <div class="heart">
                            <h1>&hearts;</h1>
                        </div>
                        <h1>Welcome back </h1>
                        <h1 style="color: var(--btn-main);"><?php echo $user['name'] ?></h1>
                    </div>
                    <a href="logout.php" class="btn-main-invert" title="Logout...">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>

                </div>
            </div>
            <?php include('organizer.php') ?>
        <?php endif ?>
    </div>
</div>

<?php include('components/footer.php') ?>
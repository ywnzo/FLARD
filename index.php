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

if(!$authOK) {
    include('auth.php');
}

?>

<?php include('components/menu.php') ?>

<div class="site">
    <div class="column content-wrapper">
        <?php if(!$authOK): ?>
            <div style="">
                <h1 class="title-main">FLARD</h1>
                <h2 style="margin-bottom: 2rem;">Create, manage and share flash cards...</h2>
                <div class="row" style="justify-content: center; height: 80%">
                    <?php include('components/auth/login_form.php'); ?>
                    <?php include('components/auth/register_form.php'); ?>
                </div>

               <!-- <div class="row" style="justify-content: center;">
                    <img class="landing-page-img" src="public/landing_page/sets.png" alt="">
                    <img class="landing-page-img" src="public/landing_page/cards.png" alt="">
                    <img class="landing-page-img" src="public/landing_page/flash.png" alt="">
                    </div> -->
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

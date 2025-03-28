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

$displayLogin = 'none';
$displayRegister = 'none';
if(isset($_GET['action'])) {
    $action = $_GET['action'] != 'register' && $_GET['action'] != 'login' ? 'login' : $_GET['action'];
    if($action === 'login') {
        $displayLogin = 'flex';
        $displayRegister = 'none';
    } elseif($action === 'register') {
        $displayLogin = 'none';
        $displayRegister = 'flex';
    }
}

?>

<?php include('components/menu.php') ?>

<div class="site">
    <div class="column content-wrapper">
        <?php if(!$authOK): ?>
            <div class="index-wrapper">
                <a href="index.php"><h1 class="title-main">FLARD</h1></a>
                <h2 style="margin-bottom: 2rem; text-align: center;">Create, manage and share flash cards...</h2>
                <div id="auth-btn-wrapper" style="display: <?php echo isset($_GET['action']) ? 'none' : 'flex'; ?>">
                    <button class="btn-main login-btn" style="min-width: 12rem;"">Login</button>
                    <button class="btn-main register-btn" style="min-width: 12rem;">Register</button>
                </div>
                <?php include('components/auth/login_form.php'); ?>
                <?php include('components/auth/register_form.php'); ?>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="spacer-row">
                    <div class="row">
                        <div class="heart">
                            <h1>&hearts;</h1>
                        </div>
                        <h1 id="screen-title">Welcome back </h1>
                        <h1 style="color: var(--btn-main);"><?php echo $user['name'] ?></h1>
                    </div>
                    <a href="logout.php" id='btn-delete' class="btn-main-invert" title="Logout...">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <?php include('organizer.php') ?>
        <?php endif ?>
    </div>
</div>

<?php include('components/footer.php') ?>

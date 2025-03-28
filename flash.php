<?php
include('config/db_connect.php');
include('config/verify_login.php');

if(!isset($_GET['set'])) {
    header('Location: index.php');
}

$setID = $_GET['set'];
$set = DB::select('name', 'cardSets', "ID = '$setID'");

?>

<?php include('components/menu.php') ?>
<div class="site">
    <div class="column content-wrapper">
        <div class="flash-info-wrapper space-between">
            <div class="row">
                <a href="cards.php?set=<?php echo $setID ?>" class="btn-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <h1 class="flash-title">Card Flashing</h1>
            </div>
            <div class="row space-between">
                <div class="row flash-set-wrapper">
                    <h2>Card Set: </h2>
                    <h2 style="color: var(--btn-main);"><?php echo $set['name'] ?></h2>
                </div>
                <button class="btn-main" id="btn-shuffle"><i class="fa fa-random" aria-hidden="true"></i></button>
            </div>
        </div>


        <template id="template-card">
            <div id="flash-wrapper">
                <div class="card-wrapper">
                    <div class="card">
                        <div class="card-front">
                            <p class="card-text card-front-p"></p>
                        </div>
                        <div class="card-back">
                            <p class="card-text card-back-p"></p>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="row" style="align-items: center; justify-content: center;">
            <div class="btn-control-wrapper" style="justify-content: end;">
                <button class="btn-main-invert btn-back" id="btn-backward"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
            </div>
            <div class="row center" id="index-btn-wrapper"></div>
            <div class="btn-control-wrapper">
                <button class="btn-main-invert btn-back" id="btn-forward"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>

<?php include('components/footer.php') ?>

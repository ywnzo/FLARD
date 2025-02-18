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
        <div class="row">
            <a href="cards.php?set=<?php echo $setID ?>" class="btn-back">&larr;</a>
            <h1>Card Flashing</h1>
        </div>
        <div class="row spacer-row">
            <div class="row">
                <h2>Card Set: </h2>
                <h2 style="color: var(--btn-main);"><?php echo $set['name'] ?></h2>
            </div>
            <button class="btn-main" id="btn-shuffle"><i class="fa fa-random" aria-hidden="true"></i></button>
        </div>

        <template id="template-card">
            <div id="flash-wrapper">
                <div class="card-wrapper">
                    <div class="card">
                        <div class="card-front">
                            <p class="card-front-p"></p>
                        </div>
                        <div class="card-back">
                            <p class="card-back-p"></p>
                        </div>
                    </div>
                </div>
            </div>
        </template>


        <div class="column" id="flash-column" style="flex-direction: column-reverse;">
            <div class="column" style="align-items: center;">
                <div class="row center" id="index-btn-wrapper"></div>
                <div class="row center">
                    <div class="btn-control-wrapper">
                        <button class="btn-main-invert btn-back" id="btn-backward">&larr;</button>
                    </div>
                    <div class="btn-control-wrapper">
                        <button class="btn-main-invert btn-back" id="btn-forward">&rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('components/footer.php') ?>

<script src="js/card_flipping.js"></script>
<script type="module" src="js/flash.js"></script>
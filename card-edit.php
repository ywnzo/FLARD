<?php

include('config/db_connect.php');
include('config/verify_login.php');

if(!isset($_GET['card'])) {
    header('Location: index.php');
}

$cardID = $_GET['card'];
$card = DB::select('*', 'cards', "ID = '$cardID'");
$setID = $card['setID'];
$set = DB::select('*', 'cardSets', "ID = '$setID'");
$setUserID = $set['userID'];
$author = DB::select('name', 'users', "ID = '$setUserID'");

$canEdit = false;
if(isset($userID) && $setUserID === $userID) {
    $canEdit = true;
}

$textFront = $card['textFront'];

?>

<?php include('components/menu.php') ?>

<div class="site">
    <div class="column content-wrapper" id="card-edit-wrapper">
        <div class="row spacer-row">
            <div class="row">
                <a href="cards.php?set=<?php echo $card['setID'] ?>" class="btn-back">&larr;</a>
                <div class="row">
                    <h1>Card:</h1>
                    <h1 style="color: var(--btn-main);"><?php echo $card['textFront'] ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="row spacer-row">
                    <div style="display: flex; gap: 2rem;">
                        <?php include('components/controls/author.php') ?>
                        <div class="row" style="width: auto; font-size: larger; gap: 8px;">
                            <i class="fa fa-archive" aria-hidden="true"></i>
                            <p><?php echo $set['name'] ?></p>
                        </div>
                        <?php include('components/controls/created_at.php') ?>
                    </div>
                </div>
                <button class="btn-main-invert" id="btn-delete"><i class="fa fa-trash" aria-hidden="true"> </i></button>
            </div>
        </div>

        <div class="column" style="align-items: center; gap: 0.5rem;">
            <input style="width: 98%;" type="text" id="card-edit-front-input" placeholder="Enter front text" value="<?php echo $textFront ?>">
            <input style="width: 98%;" type="text" id="card-edit-back-input" placeholder="Enter rear text" value="<?php echo $card['textBack'] ?>">
        </div>

        <div id="flash-wrapper">
            <div class="card-wrapper" style="display: flex;">
                <div class="card">
                    <div class="card-front-edit">
                        <p class="card-front-p"></p>
                    </div>
                    <div class="card-back-edit">
                        <p class="card-back-p"></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('components/footer.php') ?>

<script src="js/card_flipping.js"></script>
<script type="module" src="js/card_edit.js"></script>
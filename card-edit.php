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
                <a href="cards.php?set=<?php echo $card['setID'] ?>" class="btn-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <div class="row">
                    <h1 id="screen-title">Card:</h1>
                    <h1 style="color: var(--btn-main); width: 100%; text-wrap: nowrap"><?php echo $card['textFront'] ?></h1>
                </div>
            </div>
            <div class="row" style="justify-content: end;">
                <div id="info">
                    <div class="row" style="width: auto; font-size: x-large; gap: 8px;">
                        <i class="fa fa-archive" aria-hidden="true"></i>
                        <p><?php echo $set['name'] ?></p>
                    </div>
                    <?php include('components/controls/author.php') ?>
                </div>
                <button class="btn-main-invert" id="btn-delete"><i class="fa fa-trash" aria-hidden="true"> </i></button>
            </div>
        </div>

        <?php if($canEdit): ?>
            <div class="column" style="align-items: center; gap: 0.5rem;">
                <div class="input-wrapper">
                    <input style="width: 100%;" type="text" id="card-edit-front-input" placeholder="Enter front text">
                </div>
                <div class="input-wrapper">
                    <input style="width: 100%;" type="text" id="card-edit-back-input" placeholder="Enter rear text">
                </div>
            </div>
        <?php endif; ?>

        <div id="flash-wrapper">
            <div class="card-wrapper" style="display: flex;">
                <div class="card">
                    <div class="card-front-edit">
                        <p class=" card-text card-front-p"><?php echo $textFront ?></p>
                    </div>
                    <div class="card-back-edit">
                        <p class=" card-text card-back-p"><?php echo $card['textBack'] ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include('components/footer.php') ?>

<script src="js/card_flipping.js"></script>
<script type="module" src="js/card_edit.js"></script>

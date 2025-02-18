<?php

include('config/db_connect.php');
include('config/verify_login.php');

include('classes/utils.php');

if(!isset($_GET['set'])) {
    header('Location: index.php');
}

$setID = $_GET['set'];
$set = DB::select('*', 'cardSets', "ID = '$setID'");
$setUserID = $set['userID'];

if(isset($_POST['text-front'])) {
    $textFront = htmlspecialchars($_POST['text-front']);
    $textBack = htmlspecialchars($_POST['text-back']);
    $result = DB::insert('cards',  'ID, userID, setID, textFront, textBack', "UUID(), '$userID', '$setID', '$textFront', '$textBack'");
    if(!$result) {
        $error = 'Unable to create card!';
    }
}

if(isset($_POST['delete-set'])) {
    $short = explode('=', $set['urlShort'])[1];
    DB::delete('cardSets', "ID = '$setID'");
    DB::delete('urls', "short = '$short'");
    DB::delete('cards', "setID = '$setID'");
    header('Location: index.php');
}

$canEdit = false;
if(isset($userID) && $setUserID === $userID) {
    $canEdit = true;
}

$author = DB::select('name', 'users', "ID = '$setUserID'");
$array = [];
$table = 'cards';
$id = "setID = '$setID'";
$orderText = 'textFront';

if(isset($_POST['add-link'])) {
    $savedSets = $user['savedSets'];
    $savedSets = !isset($savedSets) || !is_array($savedSets) ? [] : json_decode($savedSets);
    if(!in_array($setID, $savedSets)) {
        $savedSets[] = $setID;
        $savedSets = json_encode($savedSets);
        DB::update('users', "savedSets = '$savedSets'", "ID = '$userID'");
    }
}

include('components/sort.php');

?>

<?php include('components/menu.php') ?>

<div class="site">
    <div class="column content-wrapper" id="card-set-wrapper">
        <div class="column">
            <div class="spacer-row">
                <div class="row">
                    <a href="index.php" class="btn-back">&larr;</a>
                    <h1>Card set:</h1>
                    <?php if($canEdit): ?>
                        <input type="text" id="set-name-input" value="<?php echo $set['name'] ?>">
                    <?php else: ?>
                        <h1><?php echo $set['name'] ?></h1>
                    <?php endif ?>
                </div>
                
                <?php include('components/controls/author.php') ?>

                <div style="display:flex; align-items:center;">
                    <?php if($canEdit): ?>
                        <form method="post">
                            <button type="submit" class="btn-main-invert" id="btn-delete" name="delete-set" title="Delete set...">
                                <i class="fa fa-trash" aria-hidden="true"> </i>
                            </button>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <div class="row spacer-row" style="flex-direction:row-reverse">
            <?php include('components/controls/sort_cell.php') ?>
            
            <div style="display: flex; justify-content: start; align-items:center; gap:1rem;">
                <?php if(!empty($array)): ?>
                    <a style="min-width: 12rem;" href="flash.php?set=<?php echo $setID ?>" title="Start flashing!" class="btn-main" id="start-flashing-btn""> <i class="fa fa-bolt" aria-hidden="true"></i></a>
                <?php endif ?>
                <button class="btn-main" id="copy-link-btn" title="Copy link..." name="<?php echo $set['urlShort'] ?>"> <i class="fa fa-link" aria-hidden="true"></i> </button>
                <button class="btn-main" id="del-multi-btn" title="Delete multiple..."> <i class="fa fa-minus-square" aria-hidden="true"></i> </button>
                
                <?php if($canEdit): ?>
                    <form method="POST">
                        <button type="submit" class="btn-main" title="Add to account..." name="add-link">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                        </button>
                    </form>
                <?php endif ?>
            </div>

        </div>

        <?php if($canEdit): ?>
            <div class="spacer-row">
                <form method="post" class="row spacer-row">
                    <input type="text" id="text-front" name="text-front" placeholder="Enter front text...">
                    <input type="text" id="text-back" name="text-back" placeholder="Enter rear text..." autocomplete="off" list="definitions">
                    <datalist id="definitions"></datalist>
                    <button type="submit" class="btn-main" title="Create new...">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        <?php endif ?>

        <?php if(is_array($array) && Utils::has_string_keys($array)) { $item = $array; $array = [$item]; } ?>
        <div class="list-wrapper">
            <div id="card-list">
                <?php if(empty($array)): ?>
                    <p style="width: 100%;">No cards here! Create some to start learning...</p>
                <?php else: ?>
                    <?php foreach($array as $card): ?>
                        <div class="row link-wrapper">
                            <a href="<?php echo 'card-edit.php?set=' . $card['setID'] . "&card=" . $card['ID'] ?>" class="link"><?php echo $card['textFront'] ?></a>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php include('components/footer.php') ?>

<script src="js/definitions.js"></script>
<script type="module" src="js/cards.js"> </script>
<script src="js/sort.js"></script>
<script type="module" src="js/delete_multiple.js"></script>
<script src="js/search.js"></script>

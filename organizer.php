<?php

include('classes/url_shortener.php');

$error = '';

if(isset($_POST['set-name'])) {
    $setID = uniqid(''. true);
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    $currentUrl = 'http://localhost/flard/cards.php?set=' . $setID;
    $url = USHORT::shorten($currentUrl);

    $setName = $_POST['set-name'];
    $result = DB::insert('cardSets', 'ID, userID, name, urlShort', "'$setID', '$userID', '$setName', '$url'");
    if(!$result) {
        $error = 'Unable to create card set!';
    }
}

$array = [];
$table = 'cardSets';
$id = "userID = '$userID'";
$orderText = 'name';

$savedSets = $user['savedSets'];
$savedSets = !isset($savedSets) || !is_array($savedSets) ? [] : json_decode($savedSets);
foreach($savedSets as $set) {
    $set = DB::select('*', 'cardSets', "ID = '$set'");
    $array[] = $set;
}

include('components/sort.php');

?>

<div class="row spacer-row">
    <button class="btn-main" id="del-multi-btn" title="Delete multiple..."> <i class="fa fa-minus-square" aria-hidden="true"></i> </button>
    <?php include('components/controls/sort_cell.php') ?>
</div>

<div class="row spacer-row" style="width: 100%">
    <form class="row spacer-row" method="post">
        <input type="text" id="set-name" name="set-name" placeholder="Enter set name..." style="width: 100%;">
        <button type="submit" class="btn-main" title="Create new...">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
        </button>
    </form>
</div>

<?php if(is_array($array) && Utils::has_string_keys($array)) { $item = $array; $array = [$item]; } ?>
<div class="list-wrapper">
    <div id="set-list">
        <?php if(empty($array)): ?>
            <p>No card sets here! Create some to start learning...</p>
        <?php else: ?>
            <?php foreach($array as $set): ?>
                <div class="row link-wrapper">
                    <a href="cards.php?set=<?php echo $set['ID'] ?>" class="link"><?php echo $set['name'] ?></a>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

<script src="js/sort.js"></script>
<script type="module" src="js/delete_multiple.js"></script>
<script src="js/search.js"></script>

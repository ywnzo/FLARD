<?php

$error = "";

if (isset($_POST["set-name"])) {
    $setID = uniqid("" . true);
    $setName = htmlspecialchars($_POST["set-name"]);
    $result = DB::insert(
        "cardSets",
        "ID, userID, name",
        "'$setID', '$userID', '$setName'"
    );
    if (!$result) {
        $error = "Unable to create card set!";
    }
}

$array = [];
$table = "cardSets";
$id = "userID = '$userID'";
$orderText = "name";

include "components/sort.php";
include "components/get_saved_sets.php";

if (is_array($array) && Utils::has_string_keys($array)) {
    $array = [$array];
}

$arr = get_saved_sets();
$arr = is_array($arr) ? $arr : [];
$array = is_array($array) ? $array : [];
$array = array_merge($array, $arr);

?>

<div class="row spacer-row">
    <button class="btn-main" id="del-multi-btn" title="Delete multiple..."> <i class="fa fa-minus-square" aria-hidden="true"></i> </button>
    <?php include "components/controls/sort_cell.php"; ?>
</div>

<div class="row spacer-row" style="width: 100%">
    <form class="row spacer-row" method="post">
        <input type="text" id="set-name" name="set-name" placeholder="Enter set name..." style="width: 100%;">
        <button type="submit" class="btn-main" title="Create new...">
            <i class="fa fa-plus-square" aria-hidden="true"></i>
        </button>
    </form>
</div>

<div class="list-wrapper">
    <div id="link-list">
        <?php if (empty($array[0]) && empty($array[1])): ?>
            <p style="text-wrap: nowrap">No card sets here! Create some to start learning...</p>
        <?php else: ?>

            <?php foreach ($array as $set): ?>
                <?php if (is_array($arr) && is_saved($set["ID"], $arr)): ?>
                    <div class="row link-wrapper">
                        <a href="cards.php?set=<?php echo $set["ID"]; ?>" class="link"><?php echo $set["name"]; ?></a>
                    </div>
                <?php else: ?>
                    <div class="row link-wrapper-own">
                        <a href="cards.php?set=<?php echo $set["ID"]; ?>" class="link"><?php echo $set["name"]; ?></a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>

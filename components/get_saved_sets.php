<?php
    if(!isset($userID)) {
        header('Location: index.php');
    }
    $savedSets = DB::select("*", "savedCardSets", "userID = '$userID'");

    function get_saved_sets() {
        global $savedSets;
        $arr = [];
        if (isset($savedSets) && is_array($savedSets)) {
            if (Utils::has_string_keys($savedSets)) {
                $savedSets = [$savedSets];
            }
            foreach ($savedSets as $set) {
                $sid = $set["setID"];
                $set = DB::select("*", "cardSets", "ID = '$sid'");
                $arr[] = $set;
            }
        }
        return $arr;
    }

    function is_saved($setID, $savedSets){
        foreach ($savedSets as $savedSet) {
            if ($savedSet["ID"] == $setID) {
                return true;
            }
        }
        return false;
    }
?>

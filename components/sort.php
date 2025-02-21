<?php

if (isset($_GET["o"])) {
    $sort = $_GET["o"];
    $arr = [];
    if ($sort === "aA") {
        $arr = DB::select("*", $table, "$id ORDER BY $orderText ASC");
    } elseif ($sort === "aD") {
        $arr = DB::select("*", $table, "$id ORDER BY $orderText desc");
    } elseif ($sort === "dA") {
        $arr = DB::select("*", $table, "$id ORDER BY createdAt ASC");
    } elseif ($sort === "dD") {
        $arr = DB::select("*", $table, "$id ORDER BY createdAt desc");
    } else {
        $arr = DB::select("*", $table, "$id ORDER BY createdAt desc");
    }
} else {
    $arr = DB::select("*", $table, "$id ORDER BY createdAt desc");
}

if (is_array($arr) && is_array($array)) {
    $array = array_merge($arr, $array);
}

?>

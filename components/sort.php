<?php

if(isset($_GET['o'])) {
    $sort = $_GET['o'];
    if($sort === 'aA') {
        $array = DB::select('*', $table, "$id ORDER BY $orderText ASC");
    } elseif($sort === 'aD') {
        $array = DB::select('*', $table, "$id ORDER BY $orderText desc");
    } elseif($sort === 'dA') {
        $array = DB::select('*', $table, "$id ORDER BY createdAt ASC");
    } elseif($sort === 'dD') {
        $array = DB::select('*', $table, "$id ORDER BY createdAt desc");
    } else {
        $array = DB::select('*', $table, "$id ORDER BY createdAt desc");
    }
} else {
    $array = DB::select('*', $table, "$id ORDER BY createdAt desc");
}

?>



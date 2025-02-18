<?php

$authOK = false;

if(isset($_COOKIE['sessionID'])) {
    $sessionID = $_COOKIE['sessionID'];
    $user = DB::select("*", 'users', "sessionID = '$sessionID'");
    if(isset($user)) {
        $userID = $user['ID'];
        $authOK = true;
    }
} 
if(!$authOK) {
    $scriptName = basename($_SERVER['SCRIPT_NAME']);
    if($scriptName != 'index.php' && $scriptName != 'cards.php' && $scriptName != 'flash.php') {
        header('Location: index.php');
    }
}

?>
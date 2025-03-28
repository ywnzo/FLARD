<?php

class USHORT {
    public static $urlBase = 'http://localhost/flard?url=';

    public static function shorten($url) {
        global $conn;
        $userID = htmlspecialchars($_COOKIE['userID']);
        if(!$conn) {
            return false;
        }

        $id = uniqid();
        $urlShort = self::$urlBase . $id;

        $sql = "INSERT INTO urls (original, short, userID) VALUES ('$url', '$id', '$userID')";
        if(mysqli_query($conn, $sql)) {
            return $urlShort;
        } else {
            return false;
        }
    }
}

?>

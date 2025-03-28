<?php

require_once 'vendor/autoload.php';
$client = new Google_Client();
$client->setApplicationName('Flard');
$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
$client->setAuthConfig('config/credentials.json');
$analytics = new Google_Service_Analytics($client);

?>

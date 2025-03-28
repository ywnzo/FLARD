<?php

include('../config/db_connect.php');

$word = $_GET['word'];

if(!isset($word) || empty($word)) {
    die(json_encode(['error' => 'Word not provided']));
}

$url = 'https://twinword-twinword-bundle-v1.p.rapidapi.com/word_definition/?entry=' . $word;
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/flard/config/config.ini', true);
$key = $config['definitions']['x-rapidapi-key'];
$host = $config['definitions']['x-rapidapi-host'];

$cURL = curl_init($url);

curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
    'x-rapidapi-key: ' . $key,
    'x-rapidapi-host: ' . $host
));

$response = curl_exec($cURL);

if (curl_errno($cURL)) {
    echo json_encode(['error' => curl_error($cURL)]);
} else {
    echo $response;
}
curl_close($cURL);

?>

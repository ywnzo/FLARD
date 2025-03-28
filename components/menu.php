<?php
$cssFile = 'public/css/style.css';
$cssVersion = filemtime($cssFile);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/style.css?v=<?php echo $cssVersion; ?>">

    <link rel="shortcut icon" href="public/img/logo.svg" type="image/x-icon">
    <script src="https://kit.fontawesome.com/fd483a54f1.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="public/js/index.js" defer></script>
    <script src="public/js/card_flipping.js" defer></script>
    <script type="module" src="public/js/card_edit.js" defer></script>
    <script type="module" src="public/js/flash.js" defer></script>

    <script src="public/js/definitions.js" defer></script>
    <script type="module" src="public/js/cards.js" defer> </script>
    <script src="public/js/sort.js" defer></script>
    <script type="module" src="public/js/delete_multiple.js" defer></script>
    <script src="public/js/search.js" defer></script>

    <title>FLARD <?php echo isset($user) ? '- ' . $user['name'] : ''; ?></title>
</head>
<body>

<script>'.'</script>

<div class="menu">
    <a class="column" id="site-logo-wrapper" href="index.php">
        <img id="site-logo" src="public/img/logo.svg" alt="">
    </a>
    <div class="column">
    </div>
</div>

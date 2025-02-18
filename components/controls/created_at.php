<?php 

if(isset($set)) {
    $createdAt = explode(' ', $set['createdAt']);
} else {
    $createdAt = explode(' ', $card['createdAt']);
}

?>

<div class="row" style="width: auto; font-size: larger; gap: 8px;">
    <i class="fa fa-clock-o" aria-hidden="true"></i>
    <p><?php echo $createdAt[0] ?></p>
</div>
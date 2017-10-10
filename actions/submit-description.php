<?php include ("../_config.php");
$text = $_POST['text'];
$userId = $_POST['userId'];

$users = new Users();
$users->updateDescription($userId,$text);
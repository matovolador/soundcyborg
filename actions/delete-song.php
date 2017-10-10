<?php
include("../_config.php");
session_start();
if (!isset($_SESSION['id'])||!isset($_POST['id'])){

}
$songId = $_POST['id'];
$music = new Music();

$flag=$music->deleteSong($songId,$_SESSION['id']);

echo $flag;

?>
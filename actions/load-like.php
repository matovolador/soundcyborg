<?php include ("../_config.php");
error_reporting(E_ERROR);
session_start();
if (!isset($_SESSION['id'])) return false;
$songId = $_POST['songId'];
$userId = $_SESSION['id'];
$likes = new Likes();
$res = $likes->doesUserLikeSong($songId,$userId);
if (!$res){
	echo "false";
	exit();
}else{
	echo "true";
	exit();
}


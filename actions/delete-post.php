<?php
include("../_config.php");
session_start();
if ($_SESSION['admin'] == true){
	$id = $_POST['id'];
	$posts = new Posts();
	$res=$posts->deletePost($id);
}
?>


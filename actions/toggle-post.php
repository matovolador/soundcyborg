<?php
include("../_config.php");
session_start();
if ($_SESSION['admin'] == true){
	$posts = new Posts();
	$id = $_POST['id'];
	$posts->togglePost($id);
}
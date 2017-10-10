<?php include ("../_config.php");
error_reporting(E_ERROR);
session_start();
if (!isset($_SESSION['id'])) return false;
$songId = $_POST['songId'];
$userId = $_SESSION['id'];
$action = $_POST['action'];
$likes = new Likes();
if ($action=="like"){
	$res = $likes->likeSong($songId,$userId);
	if ($res){
		echo "true";
		exit();
	}else{
		echo "false";
		exit();
	}
}else{
	if ($action == "unlike"){
		$res = $likes->unlikeSong($songId,$userId);
		if ($res){
			echo "true";
			exit();
		}else{
			echo "false";
			exit();
		}
	}
}
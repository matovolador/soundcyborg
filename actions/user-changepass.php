<?php 
include("../_config.php");
session_start();
$email = $_POST['email'];
$action = $_POST['action'];
$bands = new Users();
if ($action=="request"){
	$bands->changePasswordRequest($email);
	
	header("Location: ".SITE_URL."password?msg=ok");
	exit();
}
if ($action=="change"){
	$pass=$_POST['password'];
	$passRepeat = $_POST['passwordRepeat'];
	$code = $_POST['code'];
	if ($pass!=$passRepeat){
		header("Location: ".SITE_URL."password?code=".$code."&msg=pass");	
		exit();
	}
	$result=$bands->changePassword($email,$pass,$code);
	if ($result=="ok"){
		header("Location: ".SITE_URL."password?msg=done");
		exit();
	}else{
		header("Location: ".SITE_URL."password?code=".$code."&msg=".$result);
		exit();
	}
	
}

?>
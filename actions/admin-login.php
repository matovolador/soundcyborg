<?php
include("../_config.php");
session_start();
if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"])
{
	$email = $_POST["email"];
	$pass = $_POST["password"];
	$users = new Auth();
	$args=["email"=>$email,"pass"=>$pass];
	$flag=$users->login($args);
	if (!$flag){
		header("Location: ".SITE_URL."admin?msg=baduser");
		exit();
	}else{
		header("Location: ".SITE_URL."admin");
		exit();	
	}
	
}
else{
	header("Location: ".SITE_URL."admin?msg=captcha");
}

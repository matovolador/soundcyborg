<?php
include("../_config.php");
//error_reporting(-1);
session_start();

if(!isset($_SESSION['login-failed']) || (isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"]))
{
	$email = $_POST["email"];
	$pass = $_POST["password"];
	$bands = new Users();
	$args=["email"=>$email,"pass"=>$pass];
	$msg=$bands->login($args);
	if ($msg=="ok"){
		unset($_SESSION['login-failed']);
		header("Location: ".SITE_URL."usuario/".$_SESSION['id']);

	}else{
		$_SESSION['login-failed'] = true;
		header("Location: ".SITE_URL."login?msg=".$msg);
	    
			
	}
}else{
	$msg="Error en el captcha.";
	header("Location: ".SITE_URL."login?msg=".$msg);
}


?>
<?php
include("../_config.php");
session_start();
error_reporting(-1);
if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"])
{
	if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) ){
		header("Location: ".SITE_URL."registro");
		exit();
	}
	$name = $_POST['name'];
	$email = $_POST["email"];
	$pass = $_POST["password"];
	
	$bands = new Users();
	$flag = $bands->validateUserName($name);
	$flag2 = $bands->validateEmail($email);
	$flag3 = $bands->validatePassword($pass);




	if ($flag == "ok" && $flag2 == "ok" && $flag3 == "ok"){
		$result=$bands->register(["name"=> $name,"email"=> $email,"password" => $pass]);
		if ($result == "ok"){
			$res = $bands->getUserByEmail($email);
			if (!empty($res)){
			    header("Location: ".SITE_URL."registro?msg=ok");
			    exit();
			}else{
				die("Error en $bands->getUserByEmail(".$email.");");
			}
		}else{
			header("Location: ".SITE_URL."registro?msg=".$result);
			exit();
		}
	}else{
		if ($flag=="ok") $flag = "";
		if ($flag2=="ok") $flag2 = "";
		if ($flag3=="ok") $flag3 = "";
		header("Location: ".SITE_URL."registro?msg=Errores: ". $flag ." - " . $flag2 . " - " . $flag3);
		exit();
	}
}else{
	$msg="Error en el captcha.";
	header("Location: ".SITE_URL."registro?msg=".$msg);
}
?>
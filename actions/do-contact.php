<?php
include("../_config.php");
session_start();
if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"])
{
    $content = $_POST['content'];
    $email = $_POST['email'];
	$cabeceras = 'From: '.$email . "\r\n";
	$cabeceras .= "Content-Type: text/plain; charset=ISO-8859-1"; 
    $title = 'SoundCyborg - Mensaje del formulario de contacto.';
    
    
    $flag=mail("info@soundcyborg.com",$title,$content,$cabeceras);
    if ($flag){
		header("Location: ".SITE_URL."contacto?msg=success" );
		exit();
	}
	else{
		header("Location: ".SITE_URL."contacto?msg=error" );
		exit();
	}
}
if ($_SESSION['code']!=$_POST['captcha']){
	header("Location: ".SITE_URL."contacto?msg=captcha" );	
}
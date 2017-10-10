<?php
include("../_config.php");
session_start();
if (!isset($_POST['reported'])||!isset($_POST['reporter'])||!isset($_POST['content'])){
	header("Location: ".SITE_URL."reportar?msg=error" );
	exit();
}

$reportedUser = $_POST['reported'];
$reportingUser = $_POST['reporter'];
$content = $_POST['content'];
$headers = 'From: system@soundcyborg.com' . "\r\n";
$headers .= "Content-Type: text/plain; charset=ISO-8859-1";  
$title = 'SoundCyborg - Reporte de Usuario';
	$email = "reportes@soundcyborg.com";
$content = "El usuario ".$_SESSION['id']." ha reportado al usuario ".$_SESSION['id']. "por las siguientes razones:\r\n".$content;

$flag=mail($email,utf8_decode($title),$content,$headers);
header("Location: ".SITE_URL."reportar?msg=ok" );	

?>
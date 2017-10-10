<?php
include("../_config.php");
session_start();
if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"])
{
	$posts = new Posts();
	$args = [ "title" => $_POST['title'],
			  "content" => $_POST['content'],
			  "contact" => $_POST['contact']
			];
	$posts->createPost($args);
	$cabeceras = 'From: system@soundcyborg.com' . "\r\n";
	$cabeceras .= "Content-Type: text/plain; charset=ISO-8859-1";
    $title = 'SoundCyborg - Nuevo Post';
    
    $content = "Se ha creado un nuevo aviso en SoundCyborg ".date("Y-m-d"). "\r\nVisite el panel de administración: http://SoundCyborg.com/admin ";
    
    $flag=mail("info@soundcyborg.com",$title,$content,$cabeceras);

	header("Location: ".SITE_URL."publicar?msg=success" );
}
if ($_SESSION['code']!=$_POST['captcha']){
	header("Location: ".SITE_URL."publicar?msg=captcha" );	
}
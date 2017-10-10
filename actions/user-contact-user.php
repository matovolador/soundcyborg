<?php
include("../_config.php");
session_start();
if(isset($_POST["content"])&&isset($_POST["originId"])&&isset($_POST["targetId"]))
{
    $content = $_POST['content'];
    $users = new Users();
    $origin = $users->getUserById($_SESSION['id']);
    $target = $users->getUserById($_POST['targetId']);
    if (empty($target)||empty($origin)){
    	header("Location: ".SITE_URL."contactar-usuario?id=".$targetId."&msg=error" );
		exit();
    }

	$cabeceras = "From: 'SoundCyborg' system@soundcyborg.com\r\n";
	$cabeceras .= "Content-Type: text/plain; charset=ISO-8859-1"; 
    $title = 'SoundCyborg - Un usuario del sitio se ha contactado contigo.';
    $content = "El usuario: ".$origin['name']." ID: ".$origin['id']." te ha enviado un mensaje\r\nRespóndele a ".$origin['email']."\r\n" . $content;    
    $flag=mail($target['email'],$title,$content,$cabeceras);
    if ($flag){
		header("Location: ".SITE_URL."contactar-usuario?id=".$target['id']."&msg=success" );
		exit();
	}
	else{
		header("Location: ".SITE_URL."contactar-usuario?id=".$target['id']."&msg=error" );
		exit();
	}
}else{
	header("Location: ".SITE_URL."contactar-usuario?id=".$target['id']."&msg=error" );
	exit();
}
<?php
if (isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['message'])&&isset($_POST['subject'])){
    
    //SENT EMAIL TO ALLINPARK!!!
    $msg=$_POST['message'];
    $email=$_POST['email'];
    $nombre=$_POST['name'];
    $sujeto = $_POST['subject'];
    $cabeceras = 'From: system@rufodev.com' . "\r\n";
    $title = 'RufoDev - Ha llegado un email de consulta desde el sitio';
    
    $content = "Nombre: ".$nombre."\r\nE-Mail: ".$email."\r\nMotivo: ".$sujeto."\r\nMensaje: \r\n".wordwrap($msg, 70, "\r\n");
    
    $flag=mail("contact@rufodev.com",$title,$content,$cabeceras);
    
    if ($flag) header("Location: index.php?msg=ok");
    
}else{
    header("Location: index.php?msg=wrong");
}

?>
<?php

if (isset($_POST['nombre'])&&isset($_POST['email'])&&isset($_POST['mensaje'])){
    
    //SENT EMAIL TO ALLINPARK!!!
    $msg=$_POST['mensaje'];
    $email=$_POST['email'];
    $nombre=$_POST['nombre'];
    $cabeceras = 'From: system@allinpark.com.uy' . "\r\n";
    $title = 'All In Park - Ha llegado un email de consulta desde el sitio';
    
    $content = "Nombre: ".$nombre."\r\nE-Mail: ".$email."\r\nMensaje: \r\n".wordwrap($msg, 70, "\r\n");
    
    $flag=mail("info@allinpark.com.uy",$title,$content,$cabeceras);
    
    if ($flag) header("Location: contacto.php?msg=ok");
    
}else{
    header("Location: contacto.php?msg=wrong");
}

?>
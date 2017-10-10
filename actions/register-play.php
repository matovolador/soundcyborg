<?php 
include("../_config.php");

$music = new Music();
if (!isset($_POST['songId'])) return false;
$songId = $_POST['songId'];
$res=$music->registerPlay($songId);

return $res;


?>
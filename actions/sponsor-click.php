<?php include ("../_config.php");

$id = $_POST['id'];
$db = new PDOdb();
$db->request("UPDATE sponsors SET clicks = clicks + 1 WHERE id=?","update",[$id]);


?>
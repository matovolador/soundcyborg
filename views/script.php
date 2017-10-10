<?php include("../_config.php");

session_start();
if ($_SESSION['admin']!=true) die("forbidden");



echo 'Current PHP version: ' . phpversion();


?>
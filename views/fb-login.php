<?php
include ("../_config.php");
session_start();
if ($_SESSION['admin']!=true) die("forbidden");






?>

<script>

FB.login(function(response) {
   console.log(response);
}, {scope: 'email'});
<?php



/*
//Local:
error_reporting(-1);
define("SITE_URL","http://".$_SERVER["HTTP_HOST"]."/soundcyborg/");
define('DB_HOST', "localhost");
define('DB_NAME', "soundcyborg");
define('DB_USER', "root");
define('DB_PASS', "secret");

*/





//Server:
define("SITE_URL","https://".$_SERVER["HTTP_HOST"]."/");
error_reporting(E_ERROR);
define('DB_HOST', "localhost");
define('DB_NAME', "soundcyborg");
define('DB_USER', "root");
define('DB_PASS', "secret");


define ('SITE_ROOT', realpath(dirname(__FILE__)));

include_once("classes/Routes.php");
include_once("classes/PDOdb.php");
include_once("classes/Users.php");
include_once("classes/Posts.php");
include_once("classes/FileManager.php");
include_once("classes/Auth.php");
include_once("classes/Music.php");
include_once("classes/Likes.php");
include_once("classes/Messages.php");



?>
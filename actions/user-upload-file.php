<?php
include("../_config.php");

session_start();

if (!isset($_POST['what'])) die ("No resource type was given when uploading");
	if ($_POST['what']!="music" && $_POST['what']!="image") die("Resource was invalid when uploading");
	$what = $_POST['what'];




if (!isset($_FILES['file'])){
	echo json_encode("error");
	return;
}
//init base code:

$fileManager = new FileManager();

//check for file errors:
if ($_FILES["file"]["error"]!=0) {
        echo json_encode("Return Code: " . $_FILES["file"]["error"] . "<br />");
        return;
}

//check for action to take:

if ($what == "image"){
	$file_extension=fileFilterImage();
	if ($file_extension){
		$args = $file_extension;
		

		$dir = $_SESSION['dir'];
		$dir_subida = SITE_ROOT."/bands/".$dir;
		$fichero_subido = $dir_subida . "/profile.jpg";

		if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {
			echo json_encode("ok");
			return;
		} else {
			echo json_encode("error");
			return;
		}
	}else{
		echo json_encode("badfile");
		return;
	}

}
if ($what == "music"){
	//music upload code. must be linked to class FileManager.php and User.php

	$users = new Users();
	if (!$users->canUserUploadMusic($_SESSION['id'])){
		$msg = "No puedes subir más de ".MAX_MUSIC." canciones.";
		echo json_encode($msg);
		return;
	}

	if (isset($_SESSION['id'])){
		if (!isset($_POST['name'])||empty($_POST['name'])) {
			echo json_encode("fields");
			return;
			
		}
		$name = $_POST['name'];
		if (!isset($_POST['genre'])||empty($_POST['genre'])||$_POST['genre']==null || $_POST['genre']==-1) {
			echo json_encode("fields");
			return;
			
		}
		if (!isset($_POST['explicit'])||empty($_POST['explicit'])) {
			$explicit = 0; 
		}else{
			$explicit = $_POST['explicit'];	
		}
		
		
		$file_extension=fileFilterMusic();
		if ($file_extension){
			
			
			$fileName=$fileManager->createFileName();
			$args = [ "name"=>$name, "genre"=>$_POST['genre'],"explicit"=>$explicit,"file_extension"=>$file_extension, "fileName" => $fileName];
			$dir = $_SESSION['dir'];
			$dir_subida = SITE_ROOT."/bands/".$dir."/mp3/";
			$fichero_subido = $dir_subida . $fileName;
			
			if (is_uploaded_file($_FILES['file']['tmp_name'])){
				if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {
					$users->incrementMusicCount($_SESSION['id']);
					$fileManager->createMusicFile($args);
					echo json_encode("ok");
					return;
				} else {
					echo json_encode("error");
					return;
					
				}	
			}else{
				echo json_encode($_FILES["file"]["error"]);
				return;	
			}
			
		}else{
			echo json_encode("badfile");
			return;
			
		}

	}else{
		echo json_encode("Debes iniciar sesión.");
		return;
	}


}

function fileFilterMusic(){
	$valid_extension = ['.mp3'];
	$pos = strrpos($_FILES['file']['name'],".");
	$file_extension = substr($_FILES['file']['name'],$pos);
	if(in_array($file_extension, $valid_extension) && $_FILES["file"]["size"] <=  (15 * 1024 * 1024) ){  //15MB
	    return $file_extension;
	}
	else{
	    return false;
	}
}

function fileFilterImage(){
	$valid_extension = [".jpg",".jpeg"];
	$pos = strrpos($_FILES['file']['name'],".");
	$file_extension = substr($_FILES['file']['name'],$pos);
	if(in_array($file_extension, $valid_extension)  && $_FILES["file"]["size"] <=  (2 * 1024 * 1024) ){  //2MB
	    return $file_extension;
	}
	else{
	    return false;
	}
}

?>




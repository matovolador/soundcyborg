<?php
include("../_config.php");
$fileManager = new FileManager();
$bands = new Users();
if (isset($_SESSION['id'])){
	$name = $_POST['name'];
	$file_extension=fileFilter();
	if ($file_extension){
		$args = [ $name, $_POST['genre1'],$_POST['genre2'],$_POST['explicit'],$file_extension];
		$fileName=$fileManager->createFile($args);

		$dir = $_SESSION['dir'];
		$dir_subida = SITE_URL."bands/".$bandName."/mp3/";
		$fichero_subido = $dir_subida . $fileName);

		if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {
		    header("Location : ../upload?msg=ok");
		    exit();
		} else {
		    header("Location: ../upload?msg=error");
		    exit();
		}
	}else{
		header("Location: ../upload?msg=badfile");
		exit();
	}

}else{
	die "You are not signed in as a band";
}
function fileFilter(){
		$valid_extension = ['.mp3'];
		$pos = strrpos($_FILES['file']['name'],".");
		$file_extension = substr($_FILES['file']['name'],0,$pos-1);
		if(in_array($file_extension, $valid_extension) && $_FILES["file"]["size"] <  (5 * 1024 * 1024) ){  //5MB
		    return $file_extension;
		}
		else{
		    return false;
		}
	}


?>
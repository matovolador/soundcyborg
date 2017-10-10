<?
include("../_config.php");
$fileManager = new FileManager();

$file_extension=fileFilter();
if ($file_extension){
	$args = [ $name, $_POST['genre'],$_POST['explicit'],$file_extension];
	$fileName=$fileManager->createFile($args);


	$dir_subida = SITE_URL."files/profile/";
	$fichero_subido = $dir_subida . $fileName);

	if (move_uploaded_file($_FILES['file']['tmp_name'], $fichero_subido)) {
	    header("Location : ../signup?msg=ok");
	    exit();
	} else {
	    header("Location: ../signup?msg=error");
	    exit();
	}
}else{
	header("Location: ../signup?msg=badfile");
	exit();
}


function fileFilter(){
		$valid_extension = [".jpg",".jpeg"];
		$pos = strrpos($_FILES['file']['name'],".");
		$file_extension = substr($_FILES['file']['name'],0,$pos-1);
		if(in_array($file_extension, $valid_extension)  && $_FILES["file"]["size"] <  (5 * 1024 * 1024) ){  //5MB
		    return $file_extension;
		}
		else{
		    return false;
		}
	}




?>
<?php include("../_config.php");
error_reporting(E_ERROR);

if (isset($_POST['id'])){
	$id = $_POST['id'];
	$music = new Music();
	$songs = $music->getMusicByUserId($id);
	$users = new Users();
	$user = $users->getUserById($id);
	for ($i=0;$i<sizeof($songs);$i++){
		$songs[$i]['username'] = $user['name'];
	}
	echo json_encode($songs, JSON_UNESCAPED_UNICODE);	
	exit();
}else{
	if (isset($_POST['songId'])){
		$id = $_POST['songId'];
		$music = new Music();
		$song = $music->getMusicById($id);
		$users = new Users();
		$user = $users->getUserById($song['user_id']);
		$song['username']=$user['name'];
		echo json_encode($song, JSON_UNESCAPED_UNICODE);
		exit();
	}
}

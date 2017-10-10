<?php include("../_config.php");
session_start();
if (!isset($_SESSION['id']) || $_GET['id']!=$_SESSION['id']){
	header("Location: ".SITE_URL);
	exit();
}

$users = new users();
$music = new Music();
$user = $users->getUserById($_SESSION['id']);
$songs = $music->getMusicByUserId($_SESSION['id']);
if (empty($songs)){
	echo "<div class='panel-body'>";
	echo "No tienes canciones";
	echo "</div>";
	exit();
}
?>
<div>En este panel puedes eliminar canciones que ya no deseas seguir teniendo en tu cuenta</div>

<?php 

echo "<div class='edit-list'><ul>";
for ($i=0;$i<sizeof($songs);$i++){
	echo "<li><span class='edit-track'>".$songs[$i]['name']."</span><span class='delete-song' onclick='promptDeleteSong(".$songs[$i]['id'].",\"".$songs[$i]['name']."\");'><i class='fa fa-times-circle' aria-hidden='true'></i></span></li>";
}
echo "</ul></div>";


?>
<div><a href="<?php echo SITE_URL?>usuario/<?php echo $_SESSION['id']?>">Volver</a></div>


<script>
function promptDeleteSong(songId,name){
	if (confirm("¿Estás seguro de que quieres borrar la canción: "+name+"?")) {
		deleteSong(songId);
	}else{
		return false;
	}
}

function deleteSong(songId){
	$.ajax({
		url: SITE_URL+"actions/delete-song.php",
		data: {id:songId},
		async: false,
		type: "post",
		success: function(txt){
			window.location.reload();
		}
	});
}

</script>
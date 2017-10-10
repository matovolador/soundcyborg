<?php
include("../_config.php");  
session_start();
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-34011285-2', 'auto');
  ga('send', 'pageview');

</script>

<?php
  

$bands = new Users();

if (!isset($_SESSION['id'])&&(!isset($_GET['id']))){
	if (isset($_GET['key'])){
		//codigo de activacion de cuenta
		$key = $_GET['key'];	
		$flag=$bands->activateUser($key);
		if ($flag){
			echo "<p>Tu cuenta se ha activado con &eacute;xito. Haz click <a href='".SITE_URL."login'>aqu&iacute;</a> para ingresar.</p>";
		}else{
			echo "<p>No existen cuentas con ese c&oacute;digo de activaci&oacute;n.</p>";
			
		}
	}else{	
		echo "Necesitas estar logueado. Visita este <a href='".SITE_URL."login' >link</a> para ingresar.";
	

	}
}else{
	if (isset($_GET['id'])){
		$id = $_GET['id'];
	}else{
		$id = $_SESSION['id'];
	}

	$user = $bands->getUserById($id);
	if ($user == null || empty($user) || $user ==  false || $user['active']!=1 || $user['banned']==1){
		die ("No existen usuarios para la ID: ".$id);
	}
	echo "<h3 class='col-sm-12 center-text '>".$user['name']."</h3>";
	//show profile pic and upload profile pic /change profile pic 
	$fmt = filemtime ( SITE_ROOT ."/bands/".$user['dir']."/profile.jpg" );
	echo "<div class='col-sm-12 col-md-4'>";
	echo "<div class='img-wrap'>";
	echo "<img class='profile-img' rel='image_src' src='". SITE_URL ."bands/".$user['dir']."/profile.jpg?time=".$fmt."' />";
	if ($_GET['id']==$_SESSION['id']) 
		echo "<a href='".SITE_URL."upload?type=image' class='img-desc'>Cambiar</a>";
	echo "</div>";
	
	echo "</div>";
  
  //if band has mp3 files: show player
  if (!$bands->isEmptyDir("../bands/".$user['dir']."/mp3")){

    //show player if $songs != null:
    ?>
    <div class="col-sm-12 col-md-4">
    
   	<div class="myPlayer">
      <div class="myPlayer-play" onclick="play();"></div>
      <div class="myPlayer-pause" onclick="pause();"></div>
      <div class="myPlayer-next" onclick="next();"></div>
      <div class="myPlayer-back" onclick="previous();"></div>
      <div class="myPlayer-text" id="myPlayer-text"></div>
      <div class="myPlayer-progressbar"></div>
      <div class="myPlayer-durationbar"></div>
      <div class="myPlayer-currentTime">00:00:00</div>
      <div class="myPlayer-totalTime">00:00:00</div>
      <div class="myPlayer-like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
      <div class="myPlayer-shuffle shuffle"></div>
      <div class="myPlayer-repeat repeat"></div>
      <div class="myPlayer-volume-icon"><i class="fa fa-volume-down vol-down" aria-hidden="true"></i><i class="fa fa-volume-up vol-up" aria-hidden="true"></i><i class="fa fa-volume-off vol-off" aria-hidden="true"></i></div>
      <div class="myPlayer-volume-bar"></div>
      <div class="myPlayer-volume-circle"><i class="fa fa-circle" aria-hidden="true"></i></div>
      
    </div>
     <div class="songlist myScroll">
    </div>  
  </div>
    

<!--/////// end /////////////-->

		
	<?php 
	}else{
		echo "<p>Este usuario no tiene canciones</p>";
	
	} 
	
	$user=$bands->getUserById($id);
	echo "<div class=''>Descripci&oacute;n</div>";
	if ($id == $_SESSION['id']){
		//place editable textarea with description and submit.
		echo "<div class='user-desc'><textarea class='user-desc-textarea' id='description' onKeyUp='limitText(this,500); showSend();'>".$user['description']."</textarea><a href='#' class='prevent-default account-tool small' id='change-desc' onclick='submitDesc(".$id.");'>Enviar Cambios</a></div>";
		?>
		
		<a class='account-tool center-text upload-link' href='<?php echo SITE_URL ?>upload?type=music'>Sube canciones</a><br />
		<?php if ($hasSongs) ?>
		<a href="<?php echo SITE_URL ?>editar-canciones/<?php echo $_SESSION['id']?>" >Editar Canciones</a>
		
		<?php 
	}else{
		//place text with description
		echo "<div class='user-desc'>".$user['description']."</div>";
	
		if (isset($_SESSION['id'])){
			?>
			<div class="contact-user col-sm-12"><a href="<?php echo SITE_URL ?>contactar-usuario?id=<?php echo $id ?>">Contactar Usuario</a></div>
			<div class="report-user col-sm-12"><a href="<?php echo SITE_URL ?>reportar?id=<?php echo $id ?>" >Reportar usuario</a></div>
			<?php 
		}
	}

}

?>
<script>
<!--////////  MY PLAYER ////////-->

////////  MY PLAYER ////////-->

var defaultSongs;
var songs;
var sound;
var soundIds = [];
var currentSongId=-1;
var timerOne = null;
var repeat = false;
var shuffle = false;

var music;
var genero;
var pais;
var loaded= false;



var genre = -1;
var country = -1;
var playedSongs = [];
var paused = false;
var id = <?php echo json_encode($id) ?> ;





$(document).ready(function(){
	
	//$.getScript(SITE_URL+"js/my-player.js");
	$("#form").validate(); 

	$(".prevent-default").click(function(e){
	    e.preventDefault();
	  });


    $.ajax({
    url: SITE_URL+"actions/load-songs-json.php",
    async: true,
    method: "post",
    data: {id: id},
    dataType: 'json',
    success: function(result){

      defaultSongs = result;
      songs = defaultSongs.slice();
      loadSongList();
    }
  });

  
  

  $(".prevent-default").click(function(e){
    e.preventDefault();
  });


});

$("#form").validate(); 

function submitDesc(userId){
	var txt = $("#description").val();
	$.ajax({
		async: false,
		url: SITE_URL+"actions/submit-description.php",
		type: "post",
		data: {text:txt,userId: userId},
		success(txt){
			window.location.reload();
		}

	});

}
function showSend(){
	$("#change-desc").show();
}
</script>
</div>
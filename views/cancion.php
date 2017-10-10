<?php
include("../_config.php");  
session_start();

if (!isset($_GET['id'])){
  die("Acceso denegado");
}

$music = new Music();
$song = $music->getMusicById($_GET['id']);
$users = new Users();
$user = $users->getUserById($song['user_id']);
if (empty($user)||empty($song)||$user['active']!=1 || $user['banned']==1){
  die("Acceso denegado");
} 
$fmt = filemtime ( SITE_ROOT ."/bands/".$user['dir']."/profile.jpg" );
$user['name'] = str_replace('"'," ",$user["name"]); 
$user['name'] = str_replace('\''," ",$user["name"]);
$song['name'] = str_replace('\'', ' ', $song['name']);
$song['name'] = str_replace("\"", ' ', $song['name']);
?>


<script>
$('head').append('<meta property="og:url" content="http://www.soundcyborg.com/cancion/<?php echo $_GET['id']?>" /><meta property="og:type" content="music" /><meta property="og:title" content="<?php echo $song['name']?> - <?php echo $user['name']?>" /><meta property="og:description" content="Escuchá la música de Uruguay en SoundCyborg.com" /><meta property="og:image" content="<?php echo SITE_URL?>bands/<?php echo $user['dir']?>/profile.jpg?time=<?php echo $fmt?>" />');

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-34011285-2', 'auto');
  ga('send', 'pageview');

</script>
<?php

	echo "<h5 class='center-text'>".$song['name']." - ".$user['name']."</h5>";

	echo "<div class='col-sm-12 col-md-4'>";
	echo "<a href='".SITE_URL."usuario/".$user['id']."'>";
	echo "<div class='img-wrap'>";
	echo "<img class='profile-img' rel='image_src' src='". SITE_URL ."bands/".$user['dir']."/profile.jpg?time=".$fmt."' />";
	echo "</div>";
	echo "</a>";
	echo "</div>";
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

</div>
<script>
<!--////////  MY PLAYER ////////-->

////////  MY PLAYER ////////-->

var defaultSongs=[];
var songs=[];
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





$(document).ready(function(){
	var songId = <?php echo json_encode($_GET['id']) ?>;
	//$.getScript(SITE_URL+"js/my-player.js");
	$("#form").validate(); 

	$(".prevent-default").click(function(e){
	    e.preventDefault();
	  });


    $.ajax({
    url: SITE_URL+"actions/load-songs-json.php",
    async: true,
    method: "post",
    data: {songId: songId},
    dataType: 'json',
    success: function(result){
      defaultSongs[0] = result;
      songs[0] = defaultSongs[0];
      loadSongList();
      document.title = songs[0]['name']+" - "+songs[0]['username'];
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
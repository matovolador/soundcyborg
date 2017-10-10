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




  
  <h4 class='center-text'>M&uacute;sica</h4>
<div class="col-sm-12 col-md-12 ad">
  
  <!-- scyborg 1 -->
  <ins class="adsbygoogle"
       style="display:block"
       data-ad-client="ca-pub-8873123515716032"
       data-ad-slot="6768618920"
       data-ad-format="auto"></ins>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</div>

<div class="row">

<div class="dropdown col-sm-12 col-md-2 genre genre-list">
<div class="center-text">Listas de reproducci&oacute;n</div>
  <button class="btn dropdown-toggle btn-default btn-alpha" type="button" data-toggle="dropdown">G&eacute;neros
  <span class="caret"></span></button>
  <ul class="dropdown-menu genre-ul">
    <li data-id="-1" onclick="loadGenre(this);">Todos</li>
    <li data-id="-2" onclick="loadGenre(this);">Novedades</li>
    <li data-id="<?php echo GENRE_ROCK ?>" onclick="loadGenre(this);">Rock</li>
    <li data-id="<?php echo GENRE_BLUES ?>" onclick="loadGenre(this);">Blues</li>
    <li data-id="<?php echo GENRE_ALTERNATIVE_ROCK ?>" onclick="loadGenre(this);">Rock Alternativo</li>
    <li data-id="<?php echo GENRE_METAL ?>" onclick="loadGenre(this);">Metal</li>
    <li data-id="<?php echo GENRE_FUNK ?>" onclick="loadGenre(this);">Funk</li>
    <li data-id="<?php echo GENRE_JAZZ ?>" onclick="loadGenre(this);">Jazz</li>
    <li data-id="<?php echo GENRE_FUSION ?>" onclick="loadGenre(this);">Fusi&oacute;n</li>
    <li data-id="<?php echo GENRE_ELECTRONIC ?>" onclick="loadGenre(this);">Electr&oacute;nica</li>
    <li data-id="<?php echo GENRE_ACOUSTIC ?>" onclick="loadGenre(this);">Ac&uacute;stico</li>
    <li data-id="<?php echo GENRE_PUNK ?>" onclick="loadGenre(this);">Punk</li>
    <li data-id="<?php echo GENRE_GRUNGE ?>" onclick="loadGenre(this);">Grunge</li>
    <li data-id="<?php echo GENRE_REGGAE ?>" onclick="loadGenre(this);">Reggae</li>
    <li data-id="<?php echo GENRE_SKA ?>" onclick="loadGenre(this);">Ska</li>
    <li data-id="<?php echo GENRE_INSTRUMENTAL ?>" onclick="loadGenre(this);">Instrumental</li>
  </ul>
</div>
<div class='music-main-container col-sm-12 col-md-8 myScroll'></div>



<div class="myPlayer col-sm-12 col-md-2">
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
 <div class="songlist myScroll col-sm-12 col-md-2">
</div>  
<!--<div class="dropdown col-sm-6 col-md-2 country country-list">
  <button class="btn dropdown-toggle btn-default" type="button" data-toggle="dropdown">Pa&iacute;ses
  <span class="caret"></span></button>
    <ul class="dropdown-menu country-ul">
      <li data-id="-1" onclick="loadCountry(this);">Todos</li>
      <li data-id="AR" onclick="loadCountry(this);">Argentina</li>
      <li data-id="BO" onclick="loadCountry(this);">Bolivia</li>
      <li data-id="BR" onclick="loadCountry(this);">Brasil</li>
      <li data-id="CL" onclick="loadCountry(this);">Chile</li>
      <li data-id="CO" onclick="loadCountry(this);">Colombia</li>
      <li data-id="EC" onclick="loadCountry(this);">Ecuador</li>
      <li data-id="PY" onclick="loadCountry(this);">Paraguay</li>
      <li data-id="PE" onclick="loadCountry(this);">Per&uacute;</li>
      <li data-id="UY" onclick="loadCountry(this);">Uruguay</li>
      <li data-id="VE" onclick="loadCountry(this);">Venezuela</li>
    <ul>
</div>-->
  </div>
  
 



<script type="text/javascript">
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
$(document).ready(function(){
  loadMusic();
  
    
   $("#hide-countries").hide();
  $("#hide-genres").hide();
  checkCurrentGenre();
  checkCurrentCountry();
  if (isFacebookApp()){
    alert("Es aconsejable utilizar un navegador que no sea el de Facebook móvil para un correcto funcionamiento del sitio. Para lograr esto de la manera más facil, presione en los tres puntos en la esquina superior derecha, y seleccione 'Abrir en <su navegador>' donde en vez de <su navegador> usted verá su navegador por defecto.");
  }
  
});
function checkMusicMarquee () {
  var divArray = $(".music-desc").children("div");
  for (var i=0;i<divArray.length;i++){
    $(divArray[i]).removeClass("marquee");
    if (divArray[i].scrollWidth > divArray[i].clientWidth || divArray[i].scrollHeight > divArray[i].clientHeight ){
      
      $(divArray[i]).addClass("marquee");
    }
  }
  $('.marquee').marquee({
  allowCss3Support:false,
    duration: 5000,
    gap: 50,
    delayBeforeStart: 2000,
    pauseOnCycle: true,
    pauseOnHover: true,
    direction: 'left',
    duplicated: true,
    startVisible : true
  });
}
function loadMusic(){
  $.ajax({
    url: SITE_URL+"actions/music-handler.php",
    type: "get",
    async: false,
    data: {genero: genero, pais: pais},
    success: function(output){
      var result = $.parseJSON(output);
      music = result[0];
      resultString = result[1];
      $(".music-main-container").html("<p class='center-text'>Lista de reproducción </p>"+resultString);
      $(".music-main-container").show();
     
      if (!loaded){
        defaultSongs = music;
        songs = defaultSongs.slice();
        loaded = true;  
      }
      loadSongList();
      checkMusicMarquee();
    }
  });

}



function loadCountry(id){
  pais = $(id).data('id');
  loadMusic();
  var li = $('.country-list li');
  for (i = 0; i < li.length; i++){
    $(li[i]).removeClass("current");
    if ($(li[i]).attr("data-id")==pais){
      $(li[i]).addClass("current");
    }
  }  
}

function loadGenre(id){
  genero = $(id).data('id');
  loadMusic();
  var li = $('.genre-list li');
  for (i = 0; i < li.length; i++){
    $(li[i]).removeClass("current");
    if ($(li[i]).attr("data-id")==genero){
      $(li[i]).addClass("current");
    }
  }  
}

function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
  vars[key] = value;
  });
  return vars;
}

function checkCurrentGenre(){
    genre = getUrlVars()["genero"];
    var li = $('.genre-list li');
    if (genre==-1 || genre==null){
      $(li[0]).addClass("current");
      return;
    }
    if (genre==-2){
      $(li[1]).addClass("current");
      return;
    }
    for (i = 0; i < li.length; i++){
      if ($(li[i]).attr("data-id")==genre){
        $(li[i]).addClass("current");
      }
    }
}
function checkCurrentCountry(){
    country = getUrlVars()["pais"];
    var li = $('.country-list li');
    if (country==-1 || country==null){
      $(li[0]).addClass("current");
      return;
    }
    for (i = 0; i < li.length; i++){
      if ($(li[i]).attr("data-id")==country){
        $(li[i]).addClass("current");
      }
    }
}




function isFacebookApp() {
    var ua = navigator.userAgent || navigator.vendor || window.opera;
    return (ua.indexOf("FBAN") > -1) || (ua.indexOf("FBAV") > -1);
}



$(".prevent-default").click(function(e){
  e.preventDefault();
});

$("#form").validate(); 




</script>
</div>
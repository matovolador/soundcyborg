 
var volume = 1.0;
var lastVolume = volume;
var muted = false;
var draggingVolume = false;
function checkMarquee(){
    var textDiv = document.getElementById("myPlayer-text")
    $(textDiv).removeClass("player-marquee");
    if (textDiv.scrollHeight > textDiv.clientHeight ){
      $(textDiv).addClass("player-marquee");
    }
    

    $('.player-marquee').marquee({
      allowCss3Support:false,
      duration: 5000,
      gap: 50,
      delayBeforeStart: 1500,
      pauseOnCycle: true,
      pauseOnHover: true,
      direction: 'left',
      duplicated: true,
      startVisible : true
    });

    
    
      
}



function playSong(songId){
  if (!checkIfLoading()) return false;
    if (songs == null) return false;
  if (repeat){
    if (songId>songs.length-1)     songId = 0;
  }else{
    if (songId>=songs.length) return false;
    if (songId<0) return false;  
  }
  
  currentSongId=songId;

  for (var i=0;i<soundIds.length;i++){
    sound.stop(soundIds[i]);
  }
  sound = new Howl({
    src: [SITE_URL+"bands/"+songs[currentSongId]['user_id']+"/mp3/"+songs[currentSongId]["file"]],
    html5: true,
    volume: volume,
    onload : function(){
      calculateDuration();
      
    },
    onplay: function(){
      calculatePlayerPosition();
      songStart();
    },
    onend: function(){
      clearInterval(timerOne);
      songStop();
    }
  });
  sound.load();
  calculatePlayerPosition();
  soundIds[soundIds.length]=sound.play();
  $(".myPlayer-play").hide();
  $(".myPlayer-pause").show();
  loadExtra();
  addSongToPlayed(currentSongId);


}

function loadSongList(){
  
    if (songs == null) return false;
  if (songs!=null || songs!=false){
    var songsString= "<ol>";
    for (var i=0;i<songs.length;i++){
        songsString = songsString + "<li><a href='#/' class='song-link prevent-default' onclick='playSong("+i+");' >"+songs[i]["name"]+" - "+songs[i]['username']+"</a> <span href=href='#/' class='share-link' onclick='share("+songs[i]['id']+");'><i class='fa fa-share-alt' aria-hidden='true'></i></span></li>";
      
      
      
    }
    songsString = songsString + "</ol>";
    $(".songlist").html(songsString);  
    
  }
  
}

function promotDeleteSong(id){

}

//PLAYER UI FUNCTIONS:
function play(){
  if (!checkIfLoading()) return false;
    if (songs == null) return false;
  //if no song is loaded:
  
  if (currentSongId == -1){
    currentSongId = 0;
    for (var i=0;i<soundIds.length;i++){
      sound.stop(soundIds[i]);
    }
    sound = new Howl({
      src: [SITE_URL+"bands/"+songs[currentSongId]['user_id']+"/mp3/"+songs[currentSongId]["file"]],
      html5: true,
      volume: volume,
      onload: function(){
        calculateDuration();
      },
      onplay: function(){
        calculatePlayerPosition();
        songStart();
      },
      onend: function(){
        clearInterval(timerOne);
        songStop();
      }
    });
    sound.load();
    calculatePlayerPosition();
    soundIds[soundIds.length]=sound.play();
    $(".myPlayer-play").hide();
    $(".myPlayer-pause").show();
    loadExtra();
    addSongToPlayed(currentSongId);
    paused = false; 
    return;
  }
  if (!paused) {
    sound.load();
    addSongToPlayed(currentSongId);
    loadExtra();
  }
  paused = false; 
  soundIds[soundIds.length]=sound.play();
  $(".myPlayer-play").hide();
  $(".myPlayer-pause").show();  
  
}
function pause(){
  if (!checkIfLoading()) return false;
    if (songs == null) return false;
  paused = true;
  sound.pause(soundIds[soundIds.length-1]);
  $(".myPlayer-pause").hide();
  $(".myPlayer-play").show();
}
function next(){
    if (songs == null) return false;
  if (songs.length == 0) return false;
  if (currentSongId >= songs.length-1 && repeat == false) {
    playedSongs = [];
    return false;
  }
  if (!checkIfLoading()) return false;

  if (currentSongId >= songs.length-1 && repeat == true) {
    playedSongs = [];
    currentSongId = -1;
  }

  currentSongId ++;
  for (var i=0;i<soundIds.length;i++){
    sound.stop(soundIds[i]);
  }
  sound = new Howl({
    src: [SITE_URL+"bands/"+songs[currentSongId]['user_id']+"/mp3/"+songs[currentSongId]["file"]],
    html5: true,
    volume: volume,
    onload: function(){
      calculateDuration();
    },
    onplay: function(){
      calculatePlayerPosition();
      songStart();
    },
    onend: function(){
      clearInterval(timerOne);
      songStop();
    }
  });
  sound.load();
  calculatePlayerPosition();
  soundIds[soundIds.length]=sound.play();
  $(".myPlayer-play").hide();
  $(".myPlayer-pause").show();
  loadExtra();
  addSongToPlayed(currentSongId);

}
function previous(){
    if (songs == null) return false;
  if (currentSongId <= 0) return false;
  if (!checkIfLoading()) return false;
  currentSongId --;
  for (var i=0;i<soundIds.length;i++){
    sound.stop(soundIds[i]);
  }
  sound = new Howl({
    src: [SITE_URL+"bands/"+songs[currentSongId]['user_id']+"/mp3/"+songs[currentSongId]["file"]],
    html5: true,
    volume: volume,
    onload: function(){
      calculateDuration();
    },
    onplay: function(){
      calculatePlayerPosition();
      songStart();
    },
    onend: function(){
      clearInterval(timerOne);
      songStop();
    }
  });
  sound.load();
  calculatePlayerPosition();
  soundIds[soundIds.length]=sound.play();
  $(".myPlayer-play").hide();
  $(".myPlayer-pause").show();
  loadExtra();
  removeSongToPlayed(currentSongId +1);

}

function checkIfLoading(){
  if (sound==null) return true;
  if (sound.state() == "loaded") return true;
  return false;
}

function loadExtra(){
  loadSongText();
  loadLikes();
}

function addSongToPlayed(index){
  playedSongs.push(songs[index]);
}
function removeSongToPlayed(index){
  playedSongs.splice(index,1);
}
function loadSongText(){
  $(".myPlayer-text").html(songs[currentSongId]['name'] + " - " + songs[currentSongId]['username']);
  checkMarquee();

}


function loadLikes(){
   
  ///checks if user liked the song
  $.ajax({
    async: false,
    url: SITE_URL+"actions/load-like.php",
    type: "post",
    data: {songId: songs[currentSongId]['id']},
    success: function(txt){
      $(".myPlayer-like").removeClass("liked");
      $(".myPlayer-like").removeClass("not-liked");
      if (txt == "true"){
        //add liked class:
        $(".myPlayer-like").addClass("liked");
      }else{
        //add unliked class:
        $(".myPlayer-like").addClass("not-liked");
      }
    }
  });

}



function calculatePlayerPosition(){
  timerOne = window.setInterval(function(){
    var currentPos = sound.seek();
    if (currentPos == null || currentPos < 0 || isNaN(currentPos)){
      $(".myPlayer-currentTime").html("<img src='"+SITE_URL+"/img/loading.gif' />");  
    }else{
      $(".myPlayer-currentTime").html(secondsToHms(currentPos));  
      var duration = sound.duration(soundIds.length-1);
      movePlayerPosition(currentPos,duration);
    }
  }, 100);
}
function calculateDuration(){
  var duration = sound.duration(soundIds.length-1);
  $(".myPlayer-totalTime").html(secondsToHms(duration));
  checkCurrentVolume();  
}
function songStart(){
  registerPlayed(songs[currentSongId]['id']);
}
function songStop(){
  
  if (!repeat){
    if (currentSongId+1 >= songs.length){
      playedSongs = [];
      currentSongId = -1;
      $(".myPlayer-play").show();
      $(".myPlayer-pause").hide();
      loadExtra();
      return;
    }  
  }
  
  playSong(currentSongId + 1);
  return;


}

function movePlayerPosition(currentPos,duration){
  var percent = currentPos * 100 / duration;
  var barLength = $(".myPlayer-durationbar").width();
  var pos = percent * barLength / 100;
  pos = pos + 10;
  $(".myPlayer-progressbar").css({"left":pos+"px"});
}

$('.myPlayer-durationbar').click(function (e) { //Default mouse Position 
  
  goToSecond(e.pageX);
});

function goToSecond(x){
  var objCoords = $(".myPlayer-durationbar").offset();
  var absoluteLeft = objCoords.left; 
  var x = x - absoluteLeft;
  var elementWidth = $(".myPlayer-durationbar").width();
  var pos = x * 100 / elementWidth;
  var duration = sound.duration(soundIds.length-1);
  posInSeconds = pos * duration / 100;
  sound.seek(posInSeconds);

}

function secondsToHms(d) {
    d = Number(d);

    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    if (h<10) h="0"+h;
    if (m<10) m="0"+m;
    if (s<10) s="0"+s;
    return (h+":"+m+":"+s);

      
}
function shuffleArray(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}


function shufflePlaylist(){
  //TODO : imlpement "playedSongs"  instead of "spliceIndex".
  shuffle = true;
  songs = defaultSongs.slice();
  spliceIndex = currentSongId +1 ;
  songsLeft = songs.splice(spliceIndex,songs.length);
  songsLeft = shuffleArray(songsLeft);
  songs=songs.splice(0,spliceIndex);
  Array.prototype.push.apply(songs,songsLeft);
  
  loadSongList();

  return;
}
function unshufflePlaylist(){
  shuffle = false;
  currentSong = songs[currentSongId];
  songs=defaultSongs.slice();
  currentSongId=songs.indexOf(currentSong);
  loadSongList();
  return;
}
function loadSong(id,music){
  songs = music.slice();
  defaultSongs = songs.slice();

  if (shuffle){
    shufflePlaylist();
  }
  playSong(id);
  loadSongList();
}
function showPlay(id){
  $("#"+id).css("opacity", "0.5");

}
function hidePlay(id){
  $("#"+id).css("opacity" , "0.0");
}

$(document).on("click", ".liked",function(){
  $.ajax({
    url: SITE_URL+"actions/like-handler.php",
    data: {songId:songs[currentSongId]['id'], action: "unlike"},
    type: "post",
    async: true,
    success: function(txt){
      if (txt == "true") {
        $(".myPlayer-like").addClass("not-liked");
        $(".myPlayer-like").removeClass("liked");
      }
    }
  });
});
$(document).on("click", ".not-liked",function(){
  $.ajax({
    url: SITE_URL+"actions/like-handler.php",
    data: {songId:songs[currentSongId]['id'], action: "like"},
    type: "post",
    async: true,
    success: function(txt){
      if (txt == "true") {
        $(".myPlayer-like").addClass("liked");
        $(".myPlayer-like").removeClass("not-liked");
      }
    }
  });
});

$(document).on("click",".shuffle",function(){
  $(".myPlayer-shuffle").removeClass("shuffle");
  $(".myPlayer-shuffle").addClass("unshuffle");
  shufflePlaylist();
});
$(document).on("click",".unshuffle",function(){
  $(".myPlayer-shuffle").addClass("shuffle");
  $(".myPlayer-shuffle").removeClass("unshuffle");
  unshufflePlaylist();
});

$(document).on("click",".repeat",function(){
  $(".myPlayer-repeat").removeClass("repeat");
  $(".myPlayer-repeat").addClass("unrepeat");
  repeat = true;
});
$(document).on("click",".unrepeat",function(){
  $(".myPlayer-repeat").addClass("repeat");
  $(".myPlayer-repeat").removeClass("unrepeat");
  repeat = false;
});

$(document).on("click",".myPlayer-durationbar",function(event){
  x = event.clientX;
  goToSecond(x);
});

$(document).on("click",".vol-up",mute);
$(document).on("click",".vol-down",mute);
$(document).on("click",".vol-off",unMute);
$(document).on("click",".myPlayer-volume-bar",function(event){
  x = event.clientX;
  changeVolume(x);
});
$(document).on("mousedown",".myPlayer-volume-bar",function(){
  draggingVolume = true;
});
$(document).on("mousedown",".myPlayer-volume-circle",function(){
  draggingVolume = true;
});
$(document).on("mouseup",function(){
  draggingVolume = false;
});
$(document).on("mouseout",".myPlayer-volume-bar",function(){
  draggingVolume = false;
});
$(document).on("mouseout",".myPlayer-volume-circle",function(){
  //draggingVolume = false;
});
$(document).on("mousemove",function(event){
  if (draggingVolume){
    changeVolume(event.clientX);
  }
});



function changeVolume(x){
  
  var objCoords = $(".myPlayer-volume-bar").offset();
  var absoluteLeft = objCoords.left; 
  var xPos = x - absoluteLeft;
  var elementWidth = $(".myPlayer-volume-bar").width();
  moveVolumeKnob(xPos,absoluteLeft,elementWidth);
  var pos = xPos * 100 / elementWidth;
  var maxVolume = 1.0;
  lastVolume = volume;
  volume = pos * maxVolume / 100;
  if (sound!=null) sound.volume(volume,soundIds[soundIds.length]);
  
  checkCurrentVolume();
  
}
function moveVolumeKnob(x,barLeft,barWidth){
 if (x <0  || x > barWidth ) return false;

  circleWidth = $(".myPlayer-volume-circle").width();
  x = x + 40 - circleWidth/2;
  $(".myPlayer-volume-circle").css({"left":x+"px"});
}
function mute(){
  muted = true;
  lastVolume = volume;
  volume = 0;
  if (sound!=null) sound.volume(volume,soundIds[soundIds.length]);
  checkCurrentVolume();
}
function unMute(){
  muted = false;
  volume = lastVolume;
  
  if (sound!=null) sound.volume(volume,soundIds[soundIds.length]);
  checkCurrentVolume(); 
}
function checkCurrentVolume(){
  if (volume<0.0) volume = 0.0;
  if (volume>1.0) volume = 1.0;
  if (volume == 0.0 ){
    $(".vol-up").hide();
    $(".vol-down").hide();
    $(".vol-off").show();
  }else{
    if (volume<0.6){
      $(".vol-off").hide();
      $(".vol-up").hide();
      $(".vol-down").show();
    }else{
      $(".vol-off").hide();
      $(".vol-down").hide();
      $(".vol-up").show();
    }
  }
  if (sound!=null) sound.volume(volume,soundIds[soundIds.length]);
}

function registerPlayed(songId){
  $.ajax({
    url: SITE_URL+"actions/register-play.php",
    async: true,
    type: "post",
    data: {songId:songId},
    success: function(txt){

    }
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
      $(".music-main-container").html(resultString);
      $(".music-main-container").show();
     

      

    }
  });

}

function loadMusicByUserId(){
  $.ajax({
    url: SITE_URL+"actions/music-handler.php",
    type: "get",
    async: false,
    data: {id: id},
    success: function(output){
      var result = $.parseJSON(output);
      music = result[0];
      resultString = result[1];
      $(".music-main-container").html(resultString);
      $(".music-main-container").show();
     
      if (!loaded){
        defaultSongs = music;
        songs = defaultSongs.slice();
        loaded = true;  
      }
      loadSongList();

    }
  });
}

function share(songId){
  urlString = "http://www.soundcyborg.com/cancion/"+songId;
  window.prompt("Copiar vínculo", urlString);
}
////////////////////END/////////////



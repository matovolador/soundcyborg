<?php include("../_config.php");
$userClass = new Users();
$musicClass = new Music();
$resultString="";
$country = false;
if (isset($_GET['pais'])&&$_GET['pais']!=-1){
  $country = $_GET['pais'];
}

if (isset($_GET['genero'])){
  if ($_GET['genero']==-2){
    $music = $musicClass->getLatestMusic($country);
  }else{
    if ($_GET['genero']==-1){
      $music = $musicClass->getMusicByLikes($country); 
    }else{
      $music = $musicClass->getMusicByGenre($_GET['genero'],$country);    
    }
    
  }
  
  
}else{

    //Show most liked music:
    $music = $musicClass->getMusicByLikes($country); 
}

if (empty($music)){
  $resultString = "<div>No hay música bajo la selecci&oacute;n elegida.</div>";
  

}else{

  //show normal page:
  


  
  for ($i=0;$i<count($music);$i++){    
    $user=$userClass->getUserById($music[$i]['user_id']);
    $music[$i]['username'] = $user['name'];
    $music[$i]['username'] = str_replace("\"","",$user["name"]); 
    $music[$i]['username'] = str_replace('\'',"",$music[$i]["username"]);
    $name = str_replace(" ","%20",$music[$i]['name']);
    $music[$i]['name'] = str_replace('\'', '', $music[$i]['name']);
    $music[$i]['name'] = str_replace("\"", '', $music[$i]['name']);
    $fmt = filemtime ( SITE_ROOT ."/bands/".$user['id']."/profile.jpg" ); 
    $music[$i]['img']="".SITE_URL."/bands/".$user['id']."/profile.jpg?time=".$fmt." />";
  }
  for ($i=0;$i<count($music);$i++){
    $user=$userClass->getUserById($music[$i]['user_id']);
    $resultString .= "<div class='music-song'>";
    
    $resultString .= "<img class='music-pic' src='". SITE_URL ."bands/".$user['id']."/profile.jpg?time=".$fmt."' />";
    $resultString .= "<img class='music-play' id='button-play-".$i."' src='".SITE_URL."img/button-play.png'  onclick='loadSong(".$i.",".json_encode($music).");' onmouseover='showPlay(this.id);' onmouseout='hidePlay(this.id);' />";
    $resultString .= "<div class='music-desc'>";
    $resultString .= "<div class='music-title'>".$music[$i]['name']."</div>";
    $resultString .= "<div class='music-genre'>".Music::translateGenre($music[$i]['genre'])."</div>";
    $resultString .= "<div class='music-user'><a href='".SITE_URL."usuario/".$user['id']."' >".$music[$i]['username']."</a></div>";
    //$resultString .= "<div class='music-country'>".Music::translateCountry($user['country'])."</div>";
    $resultString .= "<div class='music-notice'><i class='fa fa-play' aria-hidden='true'></i> ".$music[$i]['plays']."    <i class='fa fa-thumbs-o-up' aria-hidden='true'></i> ".$music[$i]['likes']."</div>";
    $explicit ="";
    if ($music[$i]['explicit'] == 1 ) $explicit = "Explícito";
    $resultString .= "<div class='music-notice'>".$explicit."</div>";
    
    $resultString .= "</div>"; 

    $resultString .= "</div>";
  
    
  }
  /*
  for ($i=0;$i<count($music);$i++){    
    $user=$userClass->getUserById($music[$i]['user_id']);
    $name = str_replace(" ","%20",$music[$i]['name']);
    $resultString .= "<div class='music-song-list'>";
    
    $resultString .= "<span class='music-play-list' id='button-play-".$i."' onclick='loadSong(".$i.",".json_encode($music).");'><i class='fa fa-play-circle' aria-hidden='true'></i>    </span>";
    $resultString .= "<span class='music-desc-list'>";
    $resultString .= "<span class='music-title'>".$music[$i]['name']."    </span>";
    $resultString .= "<span class='music-user'><a href='".SITE_URL."usuario/".$user['id']."' >".$music[$i]['username']."</a>    </span>";
    $resultString .= "<span class='music-genre'>".Music::translateGenre($music[$i]['genre'])."    </span>";
    $resultString .= "<span class='music-country'>".Music::translateCountry($user['country'])."    </span>";
    $resultString .= "<span class='music-notice'><i class='fa fa-play' aria-hidden='true'></i> ".$music[$i]['plays']."    <i class='fa fa-thumbs-o-up' aria-hidden='true'></i> ".$music[$i]['likes']."    </span>";
    $explicit ="";
    if ($music[$i]['explicit'] == 1 ) $explicit = "Explícito";
    $resultString .= "<span class='music-notice'>".$explicit."</span>";
    
    $resultString .= "</span>"; 

    $resultString .= "</div>";
  }
  */  
}

echo json_encode(array($music,$resultString));
?>
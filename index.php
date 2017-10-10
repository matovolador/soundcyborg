<?php include("_config.php");
session_start();
//ROUTING-----
$routes = new Routes();
//echo $route->getCurrentUri();
$viewFile = $routes->getView($routes->getCurrentUri());

//echo $viewFile;
//------------------
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sound Cyborg - El Portal del M&uacute;sico</title>
				        
				
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="/manifest.json">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="theme-color" content="#ffffff">

		
        <!-- Latest compiled and minified CSS -->
		<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" >
		<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL ?>css/bootstrap-cyborg.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL ?>css/fileinput.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL ?>css/jRating.jquery.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL ?>css/font-awesome.css" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL ?>css/pace.css">

		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL ?>css/style.css?v=1.0.2">

	
		<script type="text/javascript"> var SITE_URL = "<?php echo SITE_URL;?>"</script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL ?>js/jquery-validation-1.15.0.js?v=1.0.1"></script>
		<script type="text/javascript" src="<?php echo SITE_URL ?>js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL ?>js/fileinput.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL ?>js/form-validator.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL ?>js/howler.js"></script>
		<script type="text/javascript" src="<?php echo SITE_URL ?>js/jRating.jquery.js"></script>
		<script  type="text/javascript"  src="<?php echo SITE_URL ?>js/pace.js"></script>
		<script  type="text/javascript"  src="<?php echo SITE_URL ?>js/jquery.marquee.js"></script>
		<script  type="text/javascript"  src="<?php echo SITE_URL ?>js/jquery.pause.js"></script>
		<script  type="text/javascript"  src="<?php echo SITE_URL ?>js/my-player.js?v=1.2.1"></script>
		
		
		<!-- Magnific Popup core CSS file -->
		<link rel="stylesheet" href="<?php echo SITE_URL ?>magnific-popup/magnific-popup.css">
		<!-- Magnific Popup core JS file -->
		<script src="<?php echo SITE_URL ?>magnific-popup/jquery.magnific-popup.js"></script>

		
    </head>
    <body>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>


    <header>
    	<div class="header-wrapper">
	    	<div class="container-fluid" style="padding:20px;">
			    <a href="<?php echo SITE_URL ?>" ><img class="logo" src="<?php echo SITE_URL ?>img/logo.png" /></a>
				<h2 class="logo-h2"><span class="first-word">Sound</span><span class="second-word">Cyborg</span></h2>
			</div>
			<div class="clear-fix"></div>
		</div>
    	<nav class="navbar navbar-default">
		  	<div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				    <div id="mymenu"> <!--JS purposes -->
				      <ul class="nav navbar-nav">
				      	<li><a class="mylinks active" href="<?php echo SITE_URL ?>">M&uacute;sica</a></li>
				      	<li><a class="mylinks" href="<?php echo SITE_URL ?>info">Informaci&oacute;n</a></li>
				        <li><a class="mylinks" href="<?php echo SITE_URL ?>contacto">Contacto</a></li>
				        <li><a href="http://facebook.com/SoundCyborg" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i><span> Facebook</span></a></li>
						
				      </ul>
				     
			      
			      <ul class="nav navbar-nav navbar-right">
					
			        <?php 
			        if (isset($_SESSION['id'])){ ?>
			        <li><a href="<?php echo SITE_URL?>usuario/<?php echo $_SESSION['id']?>" ><i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta</a></li>
			        <li><a href="<?php echo SITE_URL ?>actions/logout.php">Salir</a></li>
			        <?php }else{
			        	?>
			        	<li><a href="<?php echo SITE_URL ?>login">Ingresar</a></li>	
			        	<?php
			         
			        }?>
			      </ul>
			      </div>
			    </div><!-- /.navbar-collapse -->
		  	</div><!-- /.container-fluid -->
		</nav>
    </header>
    <!--Load views in this div -->
    <div class="panel-body">
    <div class="main-content"></div>
    </div>
    <!-- -->
    <div class="clear-fix"></div>
    <footer>
    	<div class="panel panel-default">
			<div class="panel-footer">
			<div class="cookie"></div>
			<span style="margin:10px;"><i class="fa fa-envelope" aria-hidden="true"></i> info@soundcyborg.com</span>
			<span style="margin:10px; "><a href="<?php echo SITE_URL?>terminos-de-uso">T&eacute;rminos de Uso</a></span>
			<span style="margin:10px;">&copy; <a href="http://rufodev.com">RufoDev.com</a> 2016</span>
			<div class="clear-fix"></div>
			</div>
		</div>
		
	</footer>
		<script type="text/javascript">
		
		var viewFile = "<?php echo $viewFile ?>";
		var mainFile = "";
		$(document).ready(function(){

			$(".main-content").load(SITE_URL+"views/"+viewFile);
			pos = viewFile.indexOf("?");
			cleanFile = viewFile.substr(0,pos);
			idPos = viewFile.indexOf("=");
			fileId = viewFile.substr(idPos+1,viewFile.length);
			if (cleanFile == "") cleanFile = viewFile;
			for (i=0;i<$('#mymenu ul li').length;i++){
				var node = document.getElementById("mymenu").getElementsByTagName("li")[i];
				node.setAttribute("class", "");
			}
			var node;
			switch (cleanFile){
				case "":
					node = document.getElementById("mymenu").getElementsByTagName("li")[0];
					break;
				case "music.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[0];
					break;
				case "info.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[1];
					break;
				case "buscar.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[2];
					break;
				case "publicar.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[2];
					break;
				case "arte.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[3];
					break;
				
				case "contacto.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[4];
					break;
				case "signup.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[6];
					break;
				case "signin.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[6];
					break;
				case "usuario.php":
				<?php if (isset($_SESSION['id'])){
						$sessionId = $_SESSION['id'];
					}else{
						$sessionId = null;
					} ?>
					session = <?php echo json_encode($sessionId) ?>;
					if ( fileId == session){
						node = document.getElementById("mymenu").getElementsByTagName("li")[6];	
					}else{
						node=false;
					}
					
					break;
				case "edit-songs.php":
					node = document.getElementById("mymenu").getElementsByTagName("li")[6];
					break;
				default :
					node = false;
					break;
			}
			if (!node==false)
			node.setAttribute("class", "active");
		});

		function signout() {
	      	$.ajax({
	           type: "POST",
	           url: SITE_URL+'actions/logout.php',
	           data:{action:'logout'},
	           success:function(txt) {
	           		alert(txt);
					window.location.reload();
	           }

	      	});
		}

		</script>
	</body>
</html>

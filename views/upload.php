<?php include("../_config.php");
session_start();


if (!isset($_SESSION['id'])){  //TODO Change this logic into negative for proper functionality to !isset
	echo "<p>Debes crear o iniciar sesi&oacute;n en una cuenta de banda o art&iacute;sta primero.</p><p>Visita este link para continuar</p><a href='login'>Login</a>";
	
}else {

	if (!isset($_GET['type'])) {
		
		echo "<p>&iquest;Subir <a href='".SITE_URL."upload?type=music' >m&uacute;sica</a>, o <a href='".SITE_URL."upload?type=image' >imagen de perfil</a> ?</p>";
		
		exit();
	}
	$msg = $_GET['msg'];
	if ($msg=="badfile") $msg="Archivo no v&aacute;lido.";
	if ($msg=="error") $msg="Ha ocurrido un error. Vuelva a intentarlo.";
	if ($msg=="fields") $msg="Debes completar todos los campos.";



	$type = $_GET['type'];
	
	if ($type == "music"){
		//show image upload form:
	?>
		
		<div class="error"><?php echo $msg ?></div>
		<h4>Sube tu canci&oacute;n</h4>

		<form id="form" enctype="multipart/form-data" action="<?php echo SITE_URL ?>actions/user-upload-file.php" method="post">
			<div class="form-group col-md-12">
				<div class="col-md-2"><label for="name">T&iacute;tulo de la canci&oacute;n</label></div>
				<div class="col-md-4"><input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el t&iacute;tulo de la canci&oacute;n" required></div>
				<div class="col-md-6"></div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-2"><label for="genre">G&eacute;nero</label></div>
				<div class="col-md-2"><select class="form-control" name="genre" id="genre" required>
									  	<option selected value="-1"> -- G&eacute;nero -- </option>
									  	<option value="<?php echo GENRE_ROCK ?>">Rock</option>
									  	<option value="<?php echo GENRE_BLUES ?>">Blues</option>
									  	<option value="<?php echo GENRE_METAL ?>">Metal</option>
									  	<option value="<?php echo GENRE_ALTERNATIVE_ROCK ?>">Rock Alternativo</option>
									  	<option value="<?php echo GENRE_FUNK ?>">Funk</option>
									  	<option value="<?php echo GENRE_JAZZ ?>">Jazz</option>
									  	<option value="<?php echo GENRE_FUSION ?>">Fusi&oacute;n</option>
									  	<option value="<?php echo GENRE_ELECTRONIC ?>">Electr&oacute;nica</option>
									  	<option value="<?php echo GENRE_ACOUSTIC ?>">Ac&uacute;stico</option>
									  	<option value="<?php echo GENRE_PUNK ?>">Punk</option>
									  	<option value="<?php echo GENRE_GRUNGE ?>">Grunge</option>
									  	<option value="<?php echo GENRE_REGGAE ?>">Reggae</option>
									  	<option value="<?php echo GENRE_INSTRUMENTAL ?>">Instrumental</option>
									  	<option value="<?php echo GENRE_SKA ?>">Ska</option>
		  							  </select>
		  							</div>
		  		<div class="col-md-8"></div>
		  		</div>
		  	<div class="form-group col-md-12">
				<div class="col-md-2"><label for="explicit" >&iquest;Contenido Expl&iacute;cito? </label></div>
				<div class="col-md-2"><input class="form-control" name="explicit" id="explicit" type="checkbox" value="1"></div>
				<div class="col-md-8"></div>
			</div>
			<div class="form-group col-md-12">
				<div class="col-md-2"><label for="file">Selecciona un archivo mp3 de hasta 15MB</label></div>
				<div class="col-md-4"><input type="file" class="file" id="file" name="file" accept="audio/mp3" required></div>
				<div class="col-md-6"></div>
			</div>
			<input type="hidden" name="what" id="what" value="music" >
			
		</form>
		<div class="loading"></div>
		<script type="text/javascript">
			$("#form").validate();
			var dataArray;
			$("#file").fileinput({
				allowedFileExtensions: ["mp3"],
				uploadUrl: SITE_URL+"actions/user-upload-file.php",
		    	maxFileSize: 15000,
		    	uploadExtraData:function(previewId, index) {
		    		isExplicit = 0;
		    		if($("#explicit").is(':checked')){
		    			isExplicit = 1;
		    		}
			        var data = {
			            what : $("#what").val(),
			            name : $("#name").val(),
			            genre : $("#genre").val(),

			           explicit : isExplicit
			        };
			        return data;
			    },

			});
			$("#file").on("fileuploaded",function(event, data, previewId, index) {
    		    response = data.response;
    		    what = $("#what").val();
    		    if (response == "ok" ){
    		    	window.location.replace(SITE_URL+"usuario/"+ <?php echo json_encode($_SESSION['id']) ?> );	
    		    }else{
    		    	window.location.replace(SITE_URL+"upload?type="+what+"&msg="+response);	
    		    }
    		    
			});
			
		</script>
		

<?php 
	}
	if ($type == "image"){
		//show music upload form:
		?>
		
		<div class="error"><?php echo $msg ?></div>
		<h4>Sube tu imagen de perfil</h4>
		
		<form id="form" enctype="multipart/form-data" action="<?php echo SITE_URL ?>actions/user-upload-file.php" method="post">
			<div class="form-group col-md-12">
				<div class="col-md-2"><label for="file">Selecciona una imagen jpg de hasta 2MB</label></div>
				<div class="col-md-4"><input type="file" class="file" id="file" name="file" accept="image/jpeg" required></div>
				<div class="col-md-6"></div>
			</div>
			<input type="hidden" name="what" id="what" value="image" >
			
		</form>
		<div class="loading"></div>
  
		<script type="text/javascript">
			$("#form").validate();
			$("#file").fileinput({
				uploadUrl: SITE_URL+"actions/user-upload-file.php",
				allowedFileExtensions: ["jpg","jpeg"],
		    	maxFileSize: 2000,
		    	uploadExtraData: {what: $("#what").val()},
		    	
			});
			$("#file").on("fileuploaded",function(event, data, previewId, index) {
    		    response = data.response;
    		    what = $("#what").val();
    		    if (response == "ok" ){
    		    	window.location.replace(SITE_URL+"usuario/"+ <?php echo json_encode($_SESSION['id']) ?> );	
    		    }else{
    		    	window.location.replace(SITE_URL+"upload?type="+what+"&msg="+response);	
    		    }
    		    
			});

			$("#send").click(function(){
				$(".loading").show();

			})
		</script>
		

<?php 

	}
}

?>
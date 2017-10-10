<?php include ("../_config.php"); 
session_start();
if (!isset($_SESSION['id'])){
	header("Location: ".SITE_URL);
}
if (!isset($_GET['id'])){
	header("Location: ".SITE_URL);
}
$id = $_GET['id'];
if ($id == $_SESSION['id']){
	header("Location: ".SITE_URL);
}
$users = new Users();
$reportedUser = $users->getUserById($id);
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
if (isset($_GET['msg'])){
	if ($_GET['msg']=="captcha"){
		echo "<div class='error'>El captcha es incorrecto. Int&eacute;ntelo de nuevo.</div>";
	}
	if ($_GET['msg']=="error"){
		echo "<div class='error'>Ocurri&oacute; un error en el formulario. Int&eacute;ntelo de nuevo.</div>";		
	}
	if ($_GET['msg']=="ok"){
		echo "<div class=''>Su reporte ha sido enviado con &eacute;xito.</div>";
		echo "</div>";
		exit();
	}

}



?>

	<h4>Reportar usuario</h4>
	<div class="col-md-12">
	<p>Este formulario est&aacute; dise&ntilde;ado para reportar usuarios por mal uso del sitio. Aseg&uacute;rate de comprobar que el usuario que estas por reportar de hecho est&aacute; en incumplimiento de las politicas de uso.</p>
	<p>Est&aacute;s por reportar al usuario: <a href="<?php echo SITE_URL ?>usuario/<?php echo $id ?>" ><?php echo $reportedUser['name'] ?></a></p>
	
	</div>
	<form id="form" action="<?php echo SITE_URL ?>actions/report-user.php" method="post">
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="content">Razones por las cuales decides reportar a este usuario:</label></div>
			<div class="col-md-10"><textarea rows="5" class="form-control" id="textArea" name="content" onKeyUp="limitText(this.form.content,500);" placeholder="Ingresa tu reporte" required></textarea></div>
		</div>
		<input type="hidden" name="reporter" value="<?php echo $_SESSION['id'] ?>" >
		<input type="hidden" name="reported" value="<?php echo $id ?>" >
		<button type="submit" class="btn btn-primary">Enviar</button>
	</form>
	<script type="text/javascript">
		$("#form").validate();
	</script>


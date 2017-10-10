<?php include ("../_config.php"); 
session_start();
if (!isset($_GET['id']) || $_SESSION['id']==$_GET['id'] || !isset($_SESSION['id']) ){
	die ("Accesso denegado");
}
$id = $_GET['id'];
$users = new Users();
$target = $users->getUserById($id);
if (empty($target)){
	die ("No existen usuarios para la ID : ".$id);

}


////
$msg = $_GET['msg'];
if ($msg == "success"){ 
	?>
	
		<p>Tu mensaje ha sido enviado con &eacute;xito.</p>



<?php }else{ ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-34011285-2', 'auto');
  ga('send', 'pageview');

</script>
	<h4>Contacto</h4>
	<?php
	if ($_GET['msg'] == "error" ) echo "<p class='error'>Hubo un error enviando el mensaje. Int&eacute;ntelo de nuevo.</p>";
	?>
	<div class="col-md-12">
		<div>Est&aacute;s contact&aacute;ndote con "<?php echo $target['name'] ?>".</div>
		<div>Tu direcci&oacute;n de email ser&aacute; envi&aacute;da junto con el mensaje.</div>
	</div>
	
	<form id="form" action="<?php echo SITE_URL ?>actions/user-contact-user.php" method="post">
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="content">Mensaje</label></div>
			<div class="col-md-10"><textarea rows="5" class="form-control" id="textArea" name="content" onKeyUp="limitText(this.form.content,1000);" placeholder="Ingresa tu mensaje" required></textarea></div>
		</div>
		<input type=hidden name="originId" value="<?php echo $_SESSION['id']?>" required >
		<input type=hidden name="targetId" value="<?php echo $target['id']?>" required >
		<div class="col-md-2"></div>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Enviar</button>
		</div>
	</form>
	<script type="text/javascript">
		$("#form").validate();
	</script>

<?php } ?>
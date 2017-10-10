<?php include ("../_config.php"); 
session_start();
$msg = $_GET['msg'];
if ($msg == "success"){
	?>
	
		<p>Tu mensaje ha sido enviado con &eacute;xito. Responderemos a la brevedad.</p>
	



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
	<div class="col-md-12">
	<p>Env&iacute;a un mensaje en el formulario, o m&aacute;ndanos un email a info@soundcyborg.com.</p>
	<p>Tambi&eacute;n puedes visitar nuestro facebook <a href="http://facebook.com/SoundCyborg" target="_blank" >aquí</a>.</p>
	</div>
	<?php
	if ($_GET['msg'] == "captcha" ) echo "<p class='error'>Hubo un error en el Captcha. Int&eacute;ntelo de nuevo.</p>";
	if ($_GET['msg'] == "error" ) echo "<p class='error'>Hubo un error enviando el correo. Int&eacute;ntelo de nuevo.</p>";
	?>
	<form id="form" action="<?php echo SITE_URL ?>actions/do-contact.php" method="post">
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="email">E-mail</label></div>
			<div class="col-md-10"><input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu e-mail" required></div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="content">Aviso</label></div>
			<div class="col-md-10"><textarea rows="3" class="form-control" id="textArea" name="content" onKeyUp="limitText(this.form.content,500);" placeholder="Ingresa tu aviso" required></textarea></div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="captcha">Captcha</label></div>
			<div class="col-md-2"><input type="text" class="form-control" id="captcha" name="captcha" placeholder="Ingresa el captcha" required></div>
			<div class="col-md-2"><img src="<?php echo SITE_URL ?>actions/captcha.php"  /></div>
			<div class="col-md-6"></div>
		</div>

		<button type="submit" class="btn btn-primary">Enviar</button>
	</form>
	<script type="text/javascript">
		$("#form").validate();
	</script>

<?php } ?>
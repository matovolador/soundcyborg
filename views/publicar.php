<?php include ("../_config.php"); 
session_start();
$msg = $_GET['msg'];
if ($msg == "success"){
	?>
		<p>Tu aviso ha sido enviado con &eacute;xito. Ser&aacute; filtrado antes de ser publicado.</p>
	



<?php }else{ ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-34011285-2', 'auto');
  ga('send', 'pageview');

</script>


	<h2>Publicar</h2>
	<?php
	if ($_GET['msg'] == "captcha" ) echo "<p class='error'>Hubo un error en el Captcha. Int&eacute;ntelo de nuevo.</p>";
	?>
	<form id="form" action="<?php echo SITE_URL ?>actions/create-post.php" method="post">
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="contact">Informaci&oacute;n de contacto</label></div>
			<div class="col-md-10"><input type="text" class="form-control" id="contact" name="contact" onKeyUp="limitText(this.form.contact,100);" placeholder="Ingresa tu informaci&oacute;n de contacto" required></div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="title">T&iacute;tulo</label></div>
			<div class="col-md-10"><input type="text" class="form-control" id="title" name="title" onKeyUp="limitText(this.form.title,100);" placeholder="T&iacute;tulo del aviso" required></div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="content">Aviso</label></div>
			<div class="col-md-10"><textarea rows="3" class="form-control" id="textArea" name="content" onKeyUp="limitText(this.form.content,500);" placeholder="Ingresa tu aviso" required></textarea></div>
		</div>
		<div class="col-sm-6"></div>
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="captcha">Captcha</label></div>
			<div class="col-md-2"><input type="text" class="form-control" id="captcha" name="captcha" placeholder="Ingresa el captcha" required></div>
			<div class="col-md-2"><img src="<?php echo SITE_URL ?>actions/captcha.php"  /></div>
			<div class="col-md-6"></div>
		</div>
		<div class="col-sm-12">
			<button type="submit" class="btn btn-primary">Enviar</button>
		</div>
	</form>
	<script type="text/javascript">
		$("#form").validate();
	</script>

<?php } ?>
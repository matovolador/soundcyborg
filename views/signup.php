<?php include ("../_config.php"); 
?>

<?php
if ((!isset($_GET['msg'])) || ($_GET['msg']!= "ok")){ 
	if (($_GET['msg']!= "ok") && (isset($_GET['msg']))){
		echo "<div class='error'><p>Se han producido los siguientes errores:</p><p>".$_GET['msg']."</p><p>Vuelve a intentarlo</p></div>";
	}
	?>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<h4 class="page-desc">Registro</h4>
			<p class="page-desc">Registrate para formar parte de la comunidad de SoundCyborg.</p>
		</div>
		<div class="col-sm-3"></div>
	</div>
	<form id="form" action="<?php echo SITE_URL ?>actions/user-register.php" method="post">
		<div class="row">
		<div class="col-sm-3"></div>
		<div class="form-group col-sm-3">
			<label for="email">Direcci&oacute; de e-mail</label>
			<input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu direcci&oacute;n de e-mail" required>
			<p class="detail">Aconsejamos no usar Hotmail ya que presenta errores al recibir emails de sitios nuevos en la web</p>
		</div>
		<div class="form-group col-sm-3">
			<label for="password">Contrase&ntilde;a</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Ingresa una contrase&ntilde;a" required>
			<p class="detail">La contraseña debe tener m&iacute;nimo 8 caracteres, contener al menos un n&uacute;mero y una letra.</p>
	    
		</div>
		
		<div class="col-sm-3"></div>
		</div>
		
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="form-group col-sm-3">
			<label for="name">Nombre de usuario, banda o artista</label>
			<input type="text" class="form-control" id="name" name="name" onKeyUp="limitText(this.form.name,30);" placeholder="" required>
			</div>
			
			
		</div>
		
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="form-group col-sm-3">
				<label for="captcha">Captcha</label>
				<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Ingresa el captcha" required>
				<img src="<?php echo SITE_URL ?>actions/captcha.php"  />
			
			</div>
			
			<div class="form-group col-sm-3">
				<label for="terminos">Acepto las <a href="<?php echo SITE_URL ?>terminos-de-uso">politicas de privacidad y condiciones de uso</a></label>
				<input type="checkbox" value="" name="terminos" required>
			</div>
			<div class="col-sm-3"></div>
		</div>
		<div class="row">
		<div class="col-sm-3"></div>
		<div class="form-input col-sm-3">
			<button type="submit" class="btn btn-primary">Registrarse</button>
		</div>
		<div class="col-sm-3"></div>
		<div class="col-sm-3"></div>
		</div>
	</form>
<?php 
	}else{
		if ($_GET['msg']=="ok"){
			echo "<div class='ok'>&iexcl;Te has registrado con &eacute;xito!<br>Recibiras un email a la direcci&oacute;n que has proporcionado con informaci&oacute;n para activar tu cuenta.</div>";
		}
	} 
?>

<script type="text/javascript">
$("#form").validate();
</script>
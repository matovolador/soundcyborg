<?php include ("../_config.php"); 
session_start();
?>


<?php 
if (isset($_GET['msg'])){ 
echo "<div class='error'><p>Ha ocurrido el siguiente error:</p><p>".$_GET['msg']."</p></div>";
}
 ?>
 
 	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6 page-desc">
			<h4 class="page-desc">Login</h4>
		</div>
		<div class="col-sm-3"></div>
	</div>
	
	<form id="form" action="<?php echo SITE_URL ?>actions/user-login.php" method="post">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="form-group col-sm-3">
				<label for="email">Direcci&oacute;n de e-mail:</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Ingresar e-mail" required>
			</div>
			<div class="form-group col-sm-3">
				<label for="password">Contrase&ntilde;a:</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Ingresar contrase&ntilde;a" required>
			</div>
			<div class="col-sm-3"></div>
			</div>
		<?php if (isset($_SESSION['login-failed'])){ ?>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="form-group col-sm-6">
				<div class="col-sm-2"><label for="captcha">Captcha</label></div>
				<div class="col-sm-4"><input type="text" class="form-control" id="captcha" name="captcha" placeholder="Ingresa el captcha" required></div>
				<div class="col-sm-1"><img src="<?php echo SITE_URL ?>actions/captcha.php"  /></div>
			</div>
			<div class="col-sm-3"></div>
		</div>
		<?php }  ?>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="form-input col-sm-3">
				<button type="submit" class="btn btn-primary">Login</button>
			</div>
			<div class="col-sm-3"></div>
			<div class="col-sm-3"></div>
		</div>
	</form>
	<script type="text/javascript">
		$("#form").validate();
	</script>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-3" style="padding:20px;">
			<p>&iquest;Todav&iacute;a no tienes una cuenta? <a href="<?php echo SITE_URL ?>registro">&iexcl;Registrate!</a></p>
		</div>
		<div class="col-sm-3" style="padding:20px;">
			<p>&iquest;Olvidaste tu contrase&ntilde;a? Has click <a href="<?php echo SITE_URL ?>password">aqu&iacute;</a> para recuperarla.</p>
		</div>
		<div class="col-sm-3"></div>
	</div>

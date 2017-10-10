<?php
include("../_config.php");  
session_start();

if ($_GET['msg']!="ok" && $_GET['msg']!="done") {
	if (!isset($_GET['code'])){
	?>

		<?php 
		if (isset($_GET['msg'])){
			$msg = $_GET['msg'];
			if ($msg != "ok" && $msg != "done" && $msg != "captcha" && $msg != "pass") echo "<div class='error'>".$msg."</div>";
			if ($msg == "captcha") echo "<div class='error'>El captcha es incorrecto. Vuelva a intentarlo.</div>";
			if ($msg == "pass") echo "<div class='error'>Las contraseñas no coinciden. Vuelva a intentarlo.</div>";
		}
		?>
		<form id="form" action="<?php echo SITE_URL ?>actions/user-changepass.php" method="post">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="form-group col-sm-8">
					<label for="email">Direcci&oacute;n de e-mail:</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Ingresar e-mail" required>
				</div>
				<div class="col-sm-2"></div>
				<div class="form-group col-sm-12">
					<input type="hidden" class="form-control" id="action" name="action" value="request">
				</div>
				
			</div>
			
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="form-input col-sm-3">
					<button type="submit" class="btn btn-primary">Cambiar Contrase&ntilde;a</button>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-3"></div>
			</div>
		</form>
		<script type="text/javascript">
			$("#form").validate();
		</script>

	<?php 
	}else{  
		$code = $_GET['code'];
		?>

		<?php 
		if (isset($_GET['msg'])){
			$msg = $_GET['msg'];
			if ($msg != "ok" && $msg != "done" && $msg != "captcha" && $msg != "pass") echo "<div class='error'>".$msg."</div>";
			if ($msg == "captcha") echo "<div class='error'>El captcha es incorrecto. Vuelva a intentarlo.</div>";
			if ($msg == "pass") echo "<div class='error'>Las contraseñas no coinciden. Vuelva a intentarlo.</div>";
		}
		?>
		<form id="form" action="<?php echo SITE_URL ?>actions/user-changepass.php" method="post">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="form-group col-sm-8">
					<label for="email">Direcci&oacute;n de e-mail:</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Ingresar e-mail" required>
				</div>

				<div class="col-sm-2"></div>
				<div class="form-group col-sm-12">
					<input type="hidden" class="form-control" id="action" name="action" value="change">
					<input type="hidden" class="form-control" id="code" name="code" value="<?php echo $code ?>">
				</div>
				
			</div>
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="form-group col-sm-8">
					<label for="password">Contrase&ntilde;a:</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Ingresar contrase&ntilde;a" required>
					<p class="detail">La contraseña debe tener m&iacute;nimo 8 caracteres, contener al menos un n&uacute;mero y una letra.</p>
				</div>
				<div class="col-sm-2"></div>
				
			</div>
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="form-group col-sm-8">
					<label for="passwordRepeat">Repetir Contrase&ntilde;a:</label>
					<input type="password" class="form-control" id="passwordRepeat" name="passwordRepeat" placeholder="Ingresar contrase&ntilde;a nuevamente" required>
				</div>
				<div class="col-sm-2"></div>
				
			</div>
			
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="form-input col-sm-3">
					<button type="submit" class="btn btn-primary">Cambiar Contrase&ntilde;a</button>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-3"></div>
			</div>
		</form>
		<script type="text/javascript">
			$("#form").validate();
		</script>

	<?php 
	}
}else{
	if ($_GET['msg']=="ok"){
		echo "<p>Se ha enviado un email para el cambio de contraseña a la dirección proporcionada.</p>";
	}else{
		if ($_GET['msg']=="done"){
			echo "<p>La contraseña se ha cambiado con éxito. Visita este <a href='".SITE_URL."login' >link</a> para ingresar.</p>";
		}
	}
}

?>
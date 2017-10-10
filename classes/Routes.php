<?php
class Routes {
	public $urls;
	public function Routes(){
		$this->urls = [ "" => "music.php",
					"info" => "info.php",
					"admin" => "admin.php",
					"contacto" => "contacto.php",
					"usuario" => "usuario.php",
					"registro" => "signup.php",
					"login" => "signin.php",
					"password" => "password.php",
					"buscar" => "buscar.php",
					"publicar" => "publicar.php",
					"404" => "404.php",
					"upload" => "upload.php",
					"musica" => "music.php",
					"reportar" => "report.php",
					"editar-canciones" => "edit-songs.php",
					"terminos-de-uso" => "terms.php",
					"inicio" => "inicio.php",
					"arte" => "arte.php",
					"test" => "test.php",
					"contactar-usuario" => "contactar-usuario.php",
					"cancion" => "cancion.php"


					];
	}

	
	public function getView($urlKey){
		$vars = $this->getVars();
		$urlKey=str_replace(".php","",$urlKey);
		if ($vars){
			$urlKey=str_replace($vars, "", $urlKey);
			$view = $this->urls[$urlKey];
			if ($view == null) return "404.php";
			return $view.$vars;
		}
		if (is_numeric($this->getLastUri()) ){
			$id = $this->getLastUri();
			$urlKey = str_replace("/".$id,"",$urlKey);
			$view = $this->urls[$urlKey];
			if ($view == null) return "404.php";
			$view = $this->urls[$urlKey] . "?id=" . $id;
		}else{
			$view = $this->urls[$urlKey];
		}
		if ($view == null) return "404.php";
		return $view;
	}


	public function getCurrentUri() {
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
		$uri = trim($uri, '/');
		return $uri;
	}
	//TODO: FIX THIS FUNCTION. Return value is incorrect
	public function getLastUri() {
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
		$uri = trim($uri, '/');
		$uri = explode("/",$uri);
		return $uri[sizeof($uri) - 1];
	}

	public function getVars(){
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		if ($pos = strpos($uri,"?")){
			$vars = substr($uri,$pos,strlen($uri));
			return $vars;
		}else{
			return false;
		}
	}
}
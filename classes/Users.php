<?php

define("MAX_MUSIC",20);
define("MAX_PREMIUM_MUSIC",100);


class Users{
	public $db;
	public function Users(){
		$this->db = new PDOdb();
	}

    public function login($args){
        $email=$args["email"];
        $pass=md5($args["pass"]);
        $row=$this->db->request("SELECT * FROM users WHERE email = ? LIMIT 1","select",[$email],true);
        if (!empty($row)){
            if ($pass != $row['password']&& $_SESSION['admin']!=true) return "Contraseña no válida para ese email.";
            if ($row['active']!=1) return "Esa cuenta no ha sido activada. Revisa tu correo para encontrar el email de activación.";
            if ($row['banned'] == 1) return "Esa cuenta ha sido bloqueada por no cumplir con los T&eacute;rminos de Uso."; 
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['dir'] = $row['dir'];
            $_SESSION['music_count'] = $row['music_count'];
            $_SESSION['country'] = $row['country'];

            return "ok";
        }else{
            return "No existe una cuenta con esa dirección de email.";
        }
        return false;
    }

    public function register($args){
        $name = $args['name'];
        $email = $args['email'];
        $pass = md5($args['password']);
        $country = "UY";
        $randString = $this->createRandomString();
        $res = $this->db->request("SELECT * FROM users WHERE email = ?","select",[$email],true);
        
        if (empty($res)){
            

            $res=$this->db->request("INSERT INTO users (name,password,email,rand_key,country) VALUES (?,?,?,?,?)","insert",[$name,$pass,$email,$randString,$country]);
            
            if ($res){
                
                $headers = 'From: "SoundCyborg" system@soundcyborg.com' . "\r\n";
                $headers .= "Content-Type: text/plain; charset=ISO-8859-1";  
                $title = 'SoundCyborg - Creación de tu cuenta de SoundCyborg';
               
                $content = "Se ha creado tu cuenta en SoundCyborg.com\r\nE-Mail: ".$email."\r\nNombre de Usuario: ".$name."\r\n"."Para activar este registro, haz click en el siguiente link: \r\n"."http://www.soundcyborg.com/usuario?key=".$randString;

                $flag=mail($email,utf8_decode($title),$content,$headers);
                return "ok";
            }else{
                return "Error";
            }
        }else{
            return "Ese email ya está en uso";
        }
    }

    public function generateDir($id,$dir){
        $res = $this->db->request("SELECT * FROM users WHERE id=?","select",[$id],true);
        if (!empty($res)){
            $name = $res['name'];
            $dir = $this->generateBandDirString(strtolower($dir));    
            if (!$this->checkBandDir($dir)){
                return false;
            }
            //if all conditions are met:
            $this->createBandDir($dir);
            session_start();
            $res=$this->db->request("UPDATE users SET dir = ? WHERE id = ?","update",[$dir,$id]);
            if ($res) {
                $_SESSION['dir'] = $dir;
                return true;
            }
            
        }
        return false;
        
        

    }

    public function generateBandDirString($bandName){
        $bandName = strtolower($bandName);
        $bandName = preg_replace('/[^A-Za-z0-9\-]/', '', $bandName);
        $bandName = str_replace(" ","",$bandName);
        return $bandName;

    }
    public function checkBandDir($dir){
        if (!file_exists('../bands/'.$dir)) {
            return true;
        }else{
            return false;
        }
    }

    public function createBandDir($dir){
        if (!file_exists('../bands/'.$dir)) {
            mkdir('../bands/'.$dir, 0777, TRUE);
            mkdir('../bands/'.$dir."/mp3", 0777, TRUE);
            copy ( '../img/no-pic.png', '../bands/'.$dir."/profile.jpg");

            return true;
        }else{
            return false;
        }
    }

    public function createDirById($id){
        if (!file_exists('../bands/'.$id)) {
            mkdir('../bands/'.$id, 0777, TRUE);
            mkdir('../bands/'.$id."/mp3", 0777, TRUE);
            copy ( '../img/no-pic.jpg', '../bands/'.$id."/profile.jpg");
            $res=$this->db->request("UPDATE users SET dir = ? WHERE id = ?","update",[$id,$id]);
            if (!$res) {
                $_SESSION['dir'] = $dir;
                return true;
            }
            return false;
        }else{
            return false;
        }   
    }

    public static function removeImage($id){
        copy ( '../img/no-pic.jpg', '../bands/'.$id."/profile.jpg");
        return;
    }


    public function gatherExistingDirs(){
        $paths = [];
        foreach(glob('../bands/*') as $filename){
            $pos = strrpos($filename,"/");
            $filename= substr($filename,$pos+1);
            $paths[] = $filename;
        }
        return $paths;
    }

    public function isEmptyDir($dirName){
        if ($files = glob($dirName . "/*")) {
            return false;
        }else{
            return true;
        }

    }

    public function activateUser($randKey){
        $res = $this->db->request("SELECT * FROM users WHERE rand_key=? LIMIT 1","select",[$randKey],true);
        if (!empty($res)){
            $id = $res['id'];
            $res=$this->db->request("UPDATE users SET rand_key='',active=1 WHERE id=?","update",[$id]);
            if ($res) {
                $this->createDirById($id);
                return true;
            }    
        }
        return false;
    }
    
    
    public function changePasswordRequest($email){
        $randString = $this->createRandomString();
        $this->db->request("UPDATE users SET rand_key=? WHERE email=?","update",[$randString,$email]);
        $headers = 'From: system@soundcyborg.com' . "\r\n";
        $headers .= "Content-Type: text/plain; charset=ISO-8859-1";  
        $title = 'SoundCyborg - Cambio de contraseña';
        $content = "Se ha solicitado un cambio de contraseña para la cuenta de banda/artista bajo esta dirección de correo. Para cambiar tu contraseña haz click en el siguiente link:\r\nhttp://www.soundcyborg.com/password?code=".$randString."\r\nSi no deseas cambiar tu contraseña simplemente ignora este mensaje.";
        
        $flag=mail($email,utf8_decode($title),$content,$headers);
        return;   
    }

    public function changePassword($email,$pass,$code){
        $error=$this->validatePassword($pass);
        if ($error == "ok"){
            $pass = md5($pass);
            $res=$this->db->request("UPDATE users SET password=?,rand_key='' WHERE email=? AND rand_key=? ","update",[$pass,$email,$code]);
            if ($res) return "ok";
            return "sql error.";
        }else{
            return $error;
        }
    }

    private function createRandomString(){
        $bands = $this->db->request("SELECT * FROM users","select");
        
        do{
            $randString = $this->generateRandomString();
            $flag = false;
            for ($i=0;$i<sizeof($bands);$i++){
                if ($bands[$i]['rand_key'] == $randString) $flag = true;
            }
        }while ($flag);
        return $randString;
    }

    private function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $length - 1)];
        }
        return $randomString;
    }

    public function validateRandomString($string){
        $res = $this->db->request("SELECT * FROM users WHERE rand_key = ? LIMIT 1 ","select",[$string]);
        if (!empty($res)){
        	return false;
        }
        return true;
    }

	public function validateUserName($name){
		$error = null;
        if (strlen($name) >30 ){
            $error="El nombre no debe de contener más de 30 caracteres.";
            return $error;
        }
        $users = $this->db->request("SELECT * FROM users","select");
        $found = false;
        $i = 0;
        while(!$found && $i<count($users)){
            if (strtolower($users[$i]['name']) == strtolower($name)){
                $found = true;
            }
            $i++;
        }
        if ($found) return "Ese nombre ya está en uso.";

        return "ok";
	}

	public function validateEmail($email){
		$error = null;

		$flag=filter_var($email, FILTER_VALIDATE_EMAIL);
		if ($flag==false){
			$error = "Email no válido.";
			return $error;
		}

		$res = $this->db->request("SELECT * FROM users WHERE email=?","select",[$email]);
		if (!empty($res)){
			$error = "Ese email ya está en uso.";
			return $error;
		}

		return "ok"; 
	}
	
	public function validatePassword($pass) {
	    $errors = null;

	    if (strlen($pass) < 8) {
	        $errors .= "La contraseña es muy corta. - ";
	    }

	    if (!preg_match("#[0-9]+#", $pass)) {
	        $errors .= "La contraseña debe contener al menos un número. - ";
	    }

	    if (!preg_match("#[a-zA-Z]+#", $pass)) {
	        $errors .= "La contraseña debe contener al menos una letra. - ";
	    }     
        if ($errors!=null) return $errors;
	    return "ok";
	}

	public function resetPassword($email){
		$res = $this->db->request("SELECT * FROM users WHERE email = ?","select",[$email]);
		if (!empty($res)){
			$this->setRandPass($email);
			return true;
		}else{
			return false;
		}	
	}

	public function setNewPassword($pass){
		if (!checkSession()) return false;
		if (checkPassword($pass)){
			$user = new User();
			$user->changePassword($pass);
			return true;
		}else{
			return false;
		}
	}

	public function checkSession(){
		session_start();
		if (isset($_SESSION['id'])) return true;
		return false;
	}

    public function getUserById($id){
        $res = $this->db->request("SELECT * FROM users WHERE id = ? AND banned != 1 ","select",[$id],true);
        return $res;
    }
    public function getUserByEmail($email){
        $res = $this->db->request("SELECT * FROM users WHERE email = ? AND banned != 1 ","select",[$email],true);
        return $res;   
    }

    public function banAccount($id){
        $res = $this->db->request("SELECT * FROM users WHERE id=? ","select",[$id],true);
        if (empty($res)) return false;
        $this->db->request("UPDATE users SET banned=1 WHERE id=? ","update",[$id]);
        $flag = $this->deleteFolder("../bands/".$res['dir']);
        return $flag;

    }

    public static function deleteFolder($dir) { 
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach ($files as $file) { 
          (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        } 
        return rmdir($dir); 
    } 

    public function canUserUploadMusic($id){
        $res=$this->getUserById($id);
        if (!empty($res) && ($res['music_count'] < MAX_MUSIC)) return true;
        return false;

    }

    public function incrementMusicCount($id){
        
        if ($this->canUserUploadMusic($id)){
            $res=$this->db->request("UPDATE users SET music_count = music_count + 1 WHERE id = ?","update",[$id]);
            if ($res) return true;
            return false;
        }
        
        return false;        
    }

    public function getUsersWithMusic(){
        $res = $this->db->request("SELECT * FROM users WHERE music_count > 0 ","select");
        return $res;
    }

    public function updateDescription($userId,$text){
        $res=$this->db->request("UPDATE users SET description = ? WHERE id = ? LIMIT 1","update",[$text,$userId]);
        if ($res ) return true;
        return false;
    }
}



?>
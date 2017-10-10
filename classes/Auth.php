<?php
class Auth {
	public $db;
	public function Auth(){
		$this->db = new PDOdb();
	}

	//$args["name"=>x,"pass"=>x,"email"=>x]
    public function create ($args){
        $name = $args["name"];
        $pass = md5($args["pass"]);
        $email = $args["email"];
        $res=$this->db->request("INSERT INTO auth (name,password,email) VALUES (?,?,?)","insert",[$name,$pass,$email]);
       	
        return true;

    }

    
    //$args["email"=>x,"pass"=>x]
    public function login($args){
        $email=$args["email"];
        $pass=md5($args["pass"]);
        $res=$this->db->request("SELECT * FROM auth WHERE email = ? AND password = ?","select",[$email,$pass],true);
        
         if (!empty($res)){
        	session_start();
        	$_SESSION['admin'] = true;
			$_SESSION['email']=$email;
			return true;
        }
        return false;
    }

}



?>
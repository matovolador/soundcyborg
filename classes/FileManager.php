<?php
class FileManager {
	
	private $db;

	public function FileManager(){
		$this->db = new PDOdb();
	}

	public function createMusicFile($args){
		if (!isset($_SESSION['id'])) return false;
		$name = $args['name'];
		$band_id = $_SESSION['id'];
		$explicit = $args['explicit'];
		//$fileName = $this->createFileName();
		$fileName = $args['fileName'];
		//$fileName = $this->generateFileName($name.$args['file_extension']);
		$genre = $args['genre'] ;
		$res = $this->db->request("INSERT INTO music (user_id,name,file,genre,explicit,country) VALUES (?,?,?,?,?,?)","insert",[$band_id,$name,$fileName,$genre,$explicit,$_SESSION['country']]);
		if ($res){
			return $fileName;
		}else{
			return false;
		}
		

	}
	

	public function createFileName(){
		$str = $this->generateRandomString();
		$flag = false;
		while (!$flag){
			$res=$this->db->request("SELECT * FROM music WHERE name = '$str' LIMIT 1","select",false,true);
			if (empty($res)){
				$flag = true;
			}
		}
		return $str . ".mp3";
	}
	


	public function generateFileName($fileName){
		$fileName = strtolower($fileName);
        $fileName = preg_replace('/[^A-Za-z0-9\-.]/', '', $fileName);
        $fileName = str_replace(" ","",$fileName);
        return $fileName;

	}

	private function generateRandomString($length = 25) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	//TODO CHECK THIS FUNCTION!!!
	public static function resizeImage($filename){
		$original_info = getimagesize($filename);
		$original_w = $original_info[0];
		$original_h = $original_info[1];
		$original_img = imagecreatefromjpg($filename);
		$thumb_w = 100;
		$thumb_h = 100;
		$thumb_img = imagecreatetruecolor($thumb_w, $thumb_h);
		imagecopyresampled($thumb_img, $original_img,
		                   0, 0,
		                   0, 0,
		                   $thumb_w, $thumb_h,
		                   $original_w, $original_h);
		imagejpeg($thumb_img, $thumb_filename);

		//TODO CHECK THIS:
		//imagepng($thumb_img, $thumb_filename);
		imagedestroy($thumb_img);
		imagedestroy($original_img);
		return;
	}

	
}	


?>
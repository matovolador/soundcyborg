<?php
class Posts {
	public $db;
	public function Posts(){
		$this->db = new PDOdb();
	}

	//$args["name"=>x,"pass"=>x,"email"=>x]
    public function createPost ($args){
        $title = $args["title"];
        $content = $args["content"];
        $contact = $args['contact'];
        $res=$this->db->request("INSERT INTO posts (title,content,contact, day, active) VALUES (?,?,?, NOW(), '0')","insert",[$title,$content,$contact]);
        return $res;
    }

    public function deletePost($id){
        $res=$this->db->request("DELETE FROM  posts WHERE  id ='$id' LIMIT 1 ");
        return $res;
    }

    public function getSortedPosts($country = false){
        if (!$country){
            $res = $this->db->request("SELECT * FROM posts WHERE active = '1' ORDER BY day DESC","select");
            if (empty($res)) return false;
            return $res;    
        }else{
            $res = $this->db->request("SELECT * FROM posts WHERE active = '1' AND country = ? ORDER BY day DESC","select",[$country]);
            if (empty($res)) return false;
            return $res;    
        }
        
        
    }

    public function getAllPosts(){
        $res = $this->db->request("SELECT * FROM posts ORDER BY day DESC","select");
        if (is_null($res)) return;
        return $res;
    }



    public function togglePost($id){
        $res=$this->db->request("SELECT * FROM posts WHERE id=?","select",[$id],true);
        if (empty($res)) return false;
    
        if ($res['active'] == 0){
            $toggle = 1;
        }else{
            $toggle = 0;
        }
        $this->db->request("UPDATE posts SET active=? WHERE id=?","update",[$toggle,$id]);
        return true;
        
    }
    
    
    public function searchPosts($str,$country=false){
        if (!$country){
            $res = $this->db->request("SELECT * FROM posts WHERE (title LIKE ? OR content LIKE ?) AND active = '1' ORDER BY day DESC","select",["%$str%","%$str%"]);
            if (!$res->num_rows === 0) return false;
            return $res;    
        }
        $res = $this->db->request("SELECT * FROM posts WHERE (title LIKE ? OR content LIKE ?) AND active = '1' AND country=? ORDER BY day DESC","select",["%$str%","%$str%",$country]);
        if (!$res->num_rows === 0) return false;
        return $res;
        
    }

    public function filter($string,$posts){
        $stringArray = explode(" ", $string);
        $postsArray = array();
        $h=0;
        foreach ($stringArray as $value){
            for ($i=0;$i<sizeof($posts);$i++){
                if ((strpos($value, $posts[$i]["title"]) !== false)) {    
                    $posts[$h] = $value;
                }else{
                    if ((strpos($value, $posts[$i]["content"]) !== false)) {    
                        $postsArray[$h] = $value;
                    }
                }
                
            }
        
            return $postsArray;
        }
    }
}


?>
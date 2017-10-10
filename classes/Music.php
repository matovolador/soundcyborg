<?php
define("GENRE_ROCK",1);
define("GENRE_METAL",2);
define("GENRE_ALTERNATIVE_ROCK",3);
define("GENRE_FUNK",4);
define("GENRE_JAZZ",5);
define("GENRE_FUSION",6);
define("GENRE_ELECTRONIC",7);
define("GENRE_ACOUSTIC",8);
define("GENRE_PUNK",9);
define("GENRE_GRUNGE",10);
define("GENRE_REGGAE",11);
define("GENRE_INSTRUMENTAL",12);
define("GENRE_SKA",13);
define("GENRE_BLUES",14);

//TODO imlpement ommission logic : i.e.: if user is banned , etc. dont load music.
class Music{
	public $db;
	public function Music(){
		$this->db = new PDOdb();
	}

    public function getMusicByUserId($id){
        $res = $this->db->request("SELECT * FROM users WHERE id=? LIMIT 1","select",[$id]);
        if (empty($res)) return false;
        if ($res['banned'] == 1) return false;
        $res = $this->db->request("SELECT * FROM music WHERE user_id = ? ","select",[$id]);
        return $res;
    }

    //ALL GETMUSIC FUNCTIONS WILL ORDER DESCENDING BY rating_total, and then by total_votes DESCENDING

    public function getMusicByLikes($country=false){
        if (!$country){
            $res = $this->db->request("SELECT * FROM music ORDER BY likes DESC","select");
        }else{
            $res = $this->db->request("SELECT * FROM music WHERE country = ? ORDER BY likes DESC","select",[$country]);
        }
        $res=$this->clearInvalidAccounts($res);
        return $res;    
        
    }


    public function getMusicByGenre($genre,$country=false){
        if (!$country){
            $res = $this->db->request("SELECT * FROM music WHERE genre = ? ORDER BY likes DESC","select",[$genre]);
        }else{
            $res = $this->db->request("SELECT * FROM music WHERE genre = ? AND country = ? ORDER BY likes DESC","select",[$genre,$country]);
        }
        $res=$this->clearInvalidAccounts($res);
        return $res;
        
    }

    public function getLatestMusic($country=false){
        if (!$country){
            $res = $this->db->request("SELECT * FROM music ORDER BY id DESC LIMIT 100","select");    
        }else{
            $res = $this->db->request("SELECT * FROM music WHERE country = ? ORDER BY id DESC LIMIT 100","select", [$country]);
        }
        $res=$this->clearInvalidAccounts($res);
        return $res;   
    }

    public function getMusicById($id){
        $res[0] = $this->db->request("SELECT * FROM music WHERE id = ? LIMIT 1","select",[$id],true);
        $res=$this->clearInvalidAccounts($res);
        $res = $res[0];
        return $res;   
    }

    public function deleteSong($songId,$userId){
        $res= $this->db->request("DELETE FROM music WHERE id=? AND user_id = ?","delete",[$songId,$userId]);
        $this->db->request("UPDATE users SET music_count = music_count -1 WHERE id = ? ","update",[$userId]);
        return $res;
    }

    public function registerPlay($songId){
        $res=$this->db->request("UPDATE music SET plays = plays + 1 WHERE id = ? ","update",[$songId]);
        return $res;
    }

    public function clearInvalidAccounts($array){
        for ( $i=0;$i<count($array);$i++){
            $user = $this->db->request("SELECT * FROM users WHERE id = ? LIMIT 1","select",[$array[$i]['user_id']],true);
            if ($user['banned']==1 || empty($user)){
                array_splice($array, $i, 1);
                $i--;
            }
        }
        return $array;
    }

    public static function translateGenre($genreId){
        $genreString="";
        switch($genreId){
            case GENRE_ROCK:
                $genreString = "Rock";
                break;
            case GENRE_METAL:
                $genreString = "Metal";
                break;
            case GENRE_ALTERNATIVE_ROCK:
                $genreString = "Rock Alternativo";
                break;
            case GENRE_FUNK:
                $genreString = "Funk";
                break;
            case GENRE_JAZZ:
                $genreString = "Jazz";
                break;
            case GENRE_FUSION:
                $genreString = "Fusión";
                break;
            case GENRE_ELECTRONIC:
                $genreString = "Electrónica";
                break;
            case GENRE_ACOUSTIC:
                $genreString = "Acústico";
                break;
            case GENRE_PUNK:
                $genreString = "Punk";
                break;
            case GENRE_GRUNGE:
                $genreString = "Grunge";
                break;
            case GENRE_REGGAE:
                $genreString = "Reggae";
                break;
            case GENRE_INSTRUMENTAL:
                $genreString = "Instrumental";
                break;
            case GENRE_SKA:
                $genreString = "Ska";
                break;
            case GENRE_BLUES:
                $genreString = "Blues";
                break;
            default:
                $genreString = "";
                break;
        }
        return $genreString;
    }

    public static function translateCountry($countryCode){
        $countryString="";
        switch($countryCode){
            case "UY":
                $countryString="Uruguay";
                break;
            case "AR":
                $countryString="Argentina";
                break;
            case "CO":
                $countryString="Colombia";
                break;
            case "CL":
                $countryString="Chile";
                break;
            case "PE":
                $countryString="Perú";
                break;
            case "PY":
                $countryString="Paraguay";
                break;
            case "BO":
                $countryString="Bolivia";
                break;
            case "EC":
                $countryString="Ecuador";
                break;
            case "VE":
                $countryString="Venezuela";
                break;
            default:
                $countryString = "";
                break;
        }


        return $countryString;
    }


}



?>
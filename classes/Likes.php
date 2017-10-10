<?php 

class Likes {
	public $db;

	public function Likes(){
		$this->db = new PDOdb();
	}

	public function likeSong($songId,$userId){
		session_start();
		$song = $this->db->request("SELECT * FROM music WHERE id = ? LIMIT 1","select",[$songId],true);
		if ($_SESSION['id']==$song['user_id']) return false;
		if ($this->doesUserLikeSong($songId,$userId)) return false;
		$res=$this->db->request("INSERT INTO likes (user_id,music_id) VALUES (?,?)","insert",[$userId,$songId]);
		$res2=$this->db->request("UPDATE music SET likes = likes + 1 WHERE id = ? LIMIT 1", "update",[$songId]);
		if ($res && $res2) return true;
		return false;
	}

	public function unlikeSong($songId,$userId){
		session_start();
		$song = $this->db->request("SELECT * FROM music WHERE id = ? LIMIT 1","select",[$songId],true);
		if ($_SESSION['id']==$song['user_id']) return false;
		if (!$this->doesUserLikeSong($songId,$userId)) return false;
		$res=$this->db->request("DELETE FROM likes WHERE user_id = ? AND music_id = ? LIMIT 1","delete",[$userId,$songId]);
		$res2=$this->db->request("UPDATE music SET likes = likes - 1 WHERE id = ? LIMIT 1", "update",[$songId]);
		if ($res && $res2) return true;
		return false;
	}

	public function doesUserLikeSong($songId,$userId){
		session_start();
		if ($userId != $_SESSION['id']) return false;
		$res = $this->db->request("SELECT * FROM likes WHERE user_id = ? AND music_id = ? LIMIT 1","select",[$userId,$songId],true);
		if (empty($res)) return false;
		return true;
	}	

	public function fetchLikesBySong($songId){
		$res = $this->db->request("SELECT * FROM likes WHERE music_id = ? ","select",[$songId]);
		return $res;
	}	
}


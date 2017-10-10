<?php
class Messages {
	private $db;
	private $users;
	public function Messages(){
		$this->db = new PDOdb();
		$this->users = new Users();
	}


	public function sendMessage($originId,$targetId, $msg){
		$originUser = $this->users->getUserById($originId);
		$targetUser = $this->users->getUserById($targetId);
		$title = $msg['title'];
		$content = $msg['content'];
		
	}
}
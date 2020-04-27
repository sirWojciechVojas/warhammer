<?php namespace App\Models;

use CodeIgniter\Model;

class ChatsModel extends Model {

	public function __construct(){
		$this->db	= \Config\Database::connect();
	}

	public function chatContent(){
		return $this->db->table('chat')->orderBy('waktu','ASC')->get(); 
	}

	public function messageInsert($message){ 
		$this->db->table('chat')->set($message)->insert();
	}
	
	public function main($status) {
		$this->db->table('status')->set('status', $status)->update();
		return redirect()->to(base_url('chat'));
	}

	public function getStatus() { 
		return $this->db->table('status')->get()->getResult(); 
	}

}

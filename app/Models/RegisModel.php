<?php namespace App\Models;

use CodeIgniter\Model;

class RegisModel extends Model {

	public function __construct() {
		$this->db = \Config\Database::connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
		// $this->validation =  \Config\Services::validation();
		$this->ID = (int) $this->session->get('ID');
	}

	public function orang() {
		return $this->db->table('users')->get();
	}

	public function aktif($user) {
		return $this->db->table('users')->set('status',TRUE,true)->where(['user'=>$user])->update();
	}

	public function nonaktif($user) {
		return $this->db->table('users')->set('status',FALSE,true)->where(['user'=>$user])->update();
	}

	public function deleteUser($user) {
		$this->db->table('users')->getWhere('user', $user);
		$this->db->table('users')->delete();
	}

}
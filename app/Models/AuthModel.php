<?php namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model {

	public function __construct() {
		$this->db = \Config\Database::connect();
		$this->request = \Config\Services::request();
	}

	public function cek_login(){
		$where    = array(
						'role' => $this->request->getPost('nameBG'),
						'user' => $this->request->getPost('user'),
						'pass' => $this->request->getPost('pass'),
						'status' => TRUE
					);
		return $this->db->table('users')->getWhere($where);
	}
	public function getBgId($USEDNAME) {
		return $this->db->table('w_bg_start')->select(['ID'])->where('USEDNAME',$USEDNAME)->get()->getRowArray();
	}

}
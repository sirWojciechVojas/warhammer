<?php namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model {

	public function __construct() {
		$db = \Config\Database::connect();
		$request = \Config\Services::request();
	}

	public function cek_login(){
				$db = \Config\Database::connect();
				$request = \Config\Services::request();
		$where    = array(
						'user' => $request->getPost('user'),
						'pass' => $request->getPost('pass'),
						'status' => TRUE
					);
		return $db->table('users')->getWhere($where);
	}

}
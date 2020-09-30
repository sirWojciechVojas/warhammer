<?php namespace App\Models;

use CodeIgniter\Model;

class RegisModel extends Model {

	public function __construct() {
		$this->db = \Config\Database::connect();
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
	}

	public function daftar()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'user' => 'required|min_length[3]|max_length[24]',
				'role' => 'required|min_length[3]|max_length[24]',
				'passFirst' => 'required|min_length[5]|max_length[32]',
				'passCheck' => 'matches[pass]',
			];

			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
				$this->session->setFlashdata('fail','<div class="alert alert-warning alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Twój login już istnieje!</strong>
				</div>');
				return redirect()->to(base_url('login/register'));
			}else{
				$model = new UserModel();

				$newData = [
					'user' => $this->request->getVar('user'),
					'role' => $this->request->getVar('nameBG'),
					'pass' => $this->request->getVar('passFirst'),
					'status' => FALSE,
					'akses' => 'USER',
				];
				$model->save($newData);
				$session = session();
				$session->setFlashdata('scc', '<div class="alert alert-success alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Udało się! Teraz musisz tylko poczekać na aktywację!</strong>
				</div>');
				return redirect()->to(base_url());
			}
		}

	}

	public function orang() {
		return $this->db->table('users')->get();
	}

	public function aktif($user) {
		$this->db->table('users')->getWhere('user', $user);
		$this->db->table('users')->update(array('status' => TRUE));
	}

	public function nonaktif($user) {
		$this->db->table('users')->getWhere('user', $user);
		$this->db->table('users')->update(array('status' => FALSE));
	}

	public function hapus($user) {
		$this->db->table('users')->getWhere('user', $user);
		$this->db->table('users')->delete();
	}

}
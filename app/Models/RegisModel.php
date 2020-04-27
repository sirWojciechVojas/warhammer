<?php namespace App\Models;

use CodeIgniter\Model;

class RegisModel extends Model {

	public function daftar() {
		$db = \Config\Database::connect();
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		$vcek = array('user'=>$request->getPost('user'));
		$cek = $db->getWhere('users', $vcek);

		if ($cek->resultID->num_rows > 0) {
			$session->setFlashdata('fail', '<div class="alert alert-warning alert-dismissable">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Username Tidak Tersedia!</strong>
													</div>');
			redirect(base_url('register'));
		} else {
			$form = array(
						'nama' => $this->input->post('nama'),
						'user' => $this->input->post('user'),
						'pass' => $this->input->post('pass'),
						'status' => FALSE,
						'akses' => 'USER'
					);
			$db->table('users')->insert($form);
			$session->setFlashdata('scc', '<div class="alert alert-success alert-dismissable">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Sukses, Tunggu admin mengaktifkan akun anda!</strong>
													</div>');
			redirect(base_url());
		}
	}

	public function orang() {
		$db = \Config\Database::connect();
		
		return $this->db->table('users')->get();
	}

	public function aktif($user) {
		$db->table('users')->getWhere('user', $user);
		$db->table('users')->update(array('status' => TRUE));
	}

	public function nonaktif($user) {
		$db->table('users')->getWhere('user', $user);
		$db->table('users')->update(array('status' => FALSE));
	}

	public function hapus($user) {
		$db->table('users')->getWhere('user', $user);
		$db->delete('users');
	}

}
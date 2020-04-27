<?php namespace App\Controllers;

class Login extends BaseController {
	var $a;
	var $session;
	function __construct(){
		//parent::__construct();
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$auth = model('auth');
		$chats = model('chats');
		$regis = model('regis');
	}
 
	function index(){
		$session = \Config\Services::session();
		//$session->destroy();
		$BG = model('BGModel');		
		if ($session->get('sesi') == TRUE) {
			$session->setFlashdata('done', '<div class="alert alert-warning alert-dismissable">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Tidak perlu, Anda Sudah Login!</strong>
													</div>');
			return redirect()->to(base_url('chat'));
		} else {
			$data['BG']=$BG->getBGinfo();
			//$this->printr($data['BG']);
			$data['session']=$session;
			$js['js']='login.inc.js';
			echo view('header');
			echo view('login',$data);
			echo view('footer',$js);
		}
		
	}
 
	function auth() {
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$auth = model('AuthModel');
		$where    = array(
						'user' => $request->getPost('user'),
						'pass' => $request->getPost('pass')
					);
		$cek      = $auth->cek_login('users',$where);
			
		if($cek->resultID->num_rows > 0) {
 
			foreach($cek->getResult() as $row) {
				$nama  = $row->nama;
				$user  = $row->user;
				$akses = $row->akses;
			}

			$sesi = array(
						'nama'  => $nama,
						'user'  => $user,
						'akses' => $akses,
						'sesi'  => TRUE
					);
			
			$session->set($sesi);

			return redirect()->to(base_url('chat'));
 
		} else {
			$session->setFlashdata('gagal', '<div class="alert alert-danger alert-dismissable">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Username/Password Salah!</strong>
													</div>');
			return redirect()->to(base_url('login'));
		}
	
	}
 
	function logout(){
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to(base_url());
	}

	/*===============================================================
								REGISTER
	===============================================================*/
	public function register() {
		echo view('header');
		echo view('regis');
		echo view('footer');
	}

	public function regis() {
		return $regis->daftar();
	}

	public function aktif($user) {
		$regis->aktif($user);
		redirect(base_url('chat/pending'));
	
	}

	public function nonaktif($user) {
		$regis->nonaktif($user);
		redirect(base_url('chat/pending'));
	}

	public function deleteUser($user) {
		$regis->deleteUser($user);
		redirect(base_url('chat/pending'));
	}

}
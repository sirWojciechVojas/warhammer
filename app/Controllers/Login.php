<?php namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController {
	var $a;
	var $session;
	function __construct(){
		//parent::__construct();
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$this->auth = model('AuthModel');
		$this->chats = model('ChatsModel');
		$this->regis = model('RegisModel');
		$this->BG = model('BGModel');
	}

	function index(){
		//$session = \Config\Services::session();
		//$session->destroy();
		if ($this->session->get('isLoggedIn') == TRUE) {
			$this->session->setFlashdata('done', '<div class="alert alert-warning alert-dismissable">
												<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
												<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Nie musisz się logować!</strong>
											</div>');
			return redirect()->to(base_url('chat'));
		} else {
			$data['BG']=$this->BG->getBGinfo();
			//$this->printr($data['BG']);
			$data['session']=$this->session;
			$js['js']='login.inc.js';
			echo view('header');
			echo view('login',$data);
			echo view('footer',$js);
		}

	}

	function auth()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'user' => 'required|min_length[5]|max_length[20]',
				'nameBG' => 'required|min_length[5]|max_length[32]',
				'pass' => 'required|min_length[3]|max_length[32]|validateUser[user,nameBG,pass]',
			];

			$errors = [
				'pass' => [
					'validateUser' => 'Imię BG, Login lub hasło są niepoprawne!'
				]
			];
			//echo $this->validate($rules, $errors);

			if (! $this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
				$this->session->setFlashdata('gagal','<div class="alert alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<i class="fa fa-exclamation-circle">&nbsp;</i><strong>Imię BG, Nazwa użytkownika i/lub hasło są niepoprawne!</strong>
				</div>');
				return redirect()->to(base_url('login'));
			}else{
				$model = new UserModel();

				$user = $model->where('user', $this->request->getVar('user'))
											->first();

				$this->setUserSession($user);
				//$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to(base_url('chat'));
			}

		}
	}
	private function setUserSession($user)
	{
		if($user['role']=='GAME MASTER') $USEDNAME='Richard Krupse';
		else $USEDNAME=$user['role'];
		$data = [
				'ID'  => $this->auth->getBgId($USEDNAME)['ID'],
				'USER_ID' => $user['USER_ID'],
				'user' => $user['user'],
				'USEDNAME' => $USEDNAME,
				'role' => $user['role'],
				'status' => $user['status'],
				'akses' => $user['akses'],
				'isLoggedIn'  => TRUE
			];

		session()->set($data);
		return true;

	}

	function logout(){
		$this->session->destroy();
		return redirect()->to(base_url());
	}

	/*===============================================================
								REGISTER
	===============================================================*/
	public function register() {
		$data['BG']=$this->BG->getBGinfo();
		$data['session'] = $this->session;
		$js['js']='login.inc.js';
		echo view('headerV');
		echo view('regis',$data);
		echo view('footerV',$js);
	}

	public function regis() {
		return $this->regis->daftar();
	}

	public function aktif($user) {
		$this->regis->aktif($user);
		redirect(base_url('chat/pending'));

	}

	public function nonaktif($user) {
		$this->regis->nonaktif($user);
		redirect(base_url('chat/pending'));
	}

	public function deleteUser($user) {
		$this->regis->deleteUser($user);
		redirect(base_url('chat/pending'));
	}

}
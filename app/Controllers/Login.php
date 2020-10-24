<?php namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController {
	var $a;
	var $session;
	function __construct(){
		parent::__construct();
		$this->router = \Config\Services::router();
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$this->auth = model('AuthModel');
		$this->chats = model('ChatsModel');
		$this->regis = model('RegisModel');
		$this->BG = model('BGModel');
		helper(['form']);
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
			$data['BG']=$this->BG->getBGinfo2();
			// $data['BG'][0]->HISTORY = 'lihuj';
			// $this->printr($data['BG']);
			$data['session']=$this->session;
			$js['js']='login.inc.js';
			$js['controllerName']=$this->router->controllerName();
			$js['methodName']=$this->router->methodName();
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
		$data['BG']=$this->BG->getBGinfo2();
		$data['session'] = $this->session;
		$js['js']='login.inc.js';
		echo view('headerV');
		echo view('regis',$data);
		echo view('footerV',$js);
	}

	public function regis() {
		$data = [];


		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'nameBG' => [
					'rules' => 'required',
					'label' => 'Imię Bohatera Gracza',
					'errors' => [
						'required' => 'Musisz wybrać Bohatera!'
					]
				],
				'user' => [
					'rules' => 'required|min_length[5]|max_length[24]',
					'errors' => [
						'required' => 'Pole Nazwa użytkownika jest wymagane!',
						'min_length' => 'Pole Nazwa użytkownika musi zawierać conajmniej 5 znaków!',
						'max_length' => 'Pole Nazwa użytkownika musi zawierać conajwyżej 24 znaki!'
					]
				],
				'passFirst' => [
					'rules' => 'required|min_length[5]|max_length[32]',
					'errors' => [
						'required' => 'Hasło jest wymagane!',
						'min_length' => 'Hasło musi zawierać conajmniej 5 znaków!',
						'max_length' => 'Hasło musi zawierać conajwyżej 32 znaki!'
					]
				],
				'passCheck' => [
					'rules' => 'matches[passFirst]',
					'errors' => [
						'matches' => 'Hasła nie są identyczne!'
					]
				]
			];
			$errors = [
				'passFirst' => [
					'validateUser' => 'Imię BG, Login lub hasło są niepoprawne!'
				]
			];
			// echo $this->validate($rules, $errors);
			if (! $this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
				// $this->printr($this->validator->listErrors());
				$this->session->setFlashdata('fail','<div class="alert alert-warning alert-dismissable" style="padding: 1em 0;">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>'. $this->validator->listErrors() .'</strong>
				</div>');
				$this->session->setFlashdata('last_post', $_POST);
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

}
<?php namespace App\Controllers;

class Chat extends BaseController {
	

	public function __construct() {
		$this->regis = model('RegisModel');
		$this->chats = model('ChatsModel');
	}

	public function index() {
		echo session('user').'<br>';
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$ses=$session->get('user');
		echo 'zalogowano użytkownika: <b>'.$ses.'</b><br>';
		if ($session->get('sesi') == FALSE) {
			$session->setFlashdata('login', '<div class="alert alert-warning alert-dismissable">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Anda Harus Login!</strong>
													</div>');
			return redirect()->to(base_url('public/login'));
		} else {
			$data['ajax'] = false;
			$data['orang'] = $this->regis->orang();
			$data['status'] = $this->chats->getStatus();
			$data['chat']   = $this->chats->chatContent()->getResult();
			$data['dices']  = array(2,4,6,8,10,12,20,100);
			$data['session']=$session;
			$js['js']='chat.inc.js';
			echo view('header');
			echo view('chat', $data);
			echo view('footer',$js);
		}
	}

	public function send() {
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		date_default_timezone_set('Europe/Warsaw');
		$date = date('Y-m-d H:i:s');
		$message = array(
			'pengirim' => session('user'),
			'waktu' => $date,
			'teks' => $request->getPost('message')
		);
		//$this->printr($message);
		$this->chats->messageInsert($message);
		$data['orang'] = $this->regis->orang();
		$data['chat']=$this->chats->chatContent()->getResult();
		$data['status'] = $this->chats->getStatus();
		$data['ajax']=true;
		$data['session']=$session;
		//return 'VOJAS';
		return view('chat', $data);
		//return redirect()->to(base_url('chat'));
	}

	public function open() {
		return $this->chats->main(TRUE);
	}

	public function maintenance() { 
		return $this->chats->main(FALSE);
	}

	public function pending() {
		if (session('sesi') == FALSE) {
			session()->setFlashdata('login', '<div class="alert alert-warning alert-dismissable">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Anda Harus Login!</strong>
													</div>');
			return redirect()->to(base_url());
		} else {
			$data['orang'] = $this->regis->orang();
			$data['status'] = $this->chats->getStatus();
			$data['session'] = \Config\Services::session();
			$js['js']='chat.inc.js';
			echo view('header');
			echo view('pending', $data);
			echo view('footer',$js);
		}
	}
}


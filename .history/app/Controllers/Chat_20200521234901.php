<?php namespace App\Controllers;

Class Chat extends BaseController {

	public $CI = NULL;

	public function __construct() {
		$this->regis = model('RegisModel');
		$this->chats = model('ChatsModel');
	}

	public function index() {
		//echo session('user').'<br>';
		$session = \Config\Services::session();
		$request = \Config\Services::request();
		$ses=$session->get('user');
		//echo 'zalogowano użytkownika: <b>'.$ses.'</b><br>';
		if ($session->get('sesi') == FALSE) {
			$session->setFlashdata('login', '<div class="alert alert-warning alert-dismissable">
														<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
														<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Anda Harus Login!</strong>
													</div>');
			return redirect()->to(base_url('login'));
		} else {
			$data['ajax'] = false;
			$data['orang'] = $this->regis->orang();
			$data['BG'] = $this->chats->getCechy2();
			$table = $this->chats->getCechy();

			$data['skills']= $this->chats->getAllSkills();
			$data['talents']= $this->chats->getAllTalents();
			$data['i']=0;
			$Glowne_ini=array_splice($table[0], 14, 8);
			$Drugo1_ini=array_splice($table[0], 14, 4);
			$Drugo2_ini=array_splice($table[0], 14, 4);
			$Glowne_adv=array_splice($table[1], 20, 8);
			$Drugo1_adv=array_splice($table[1], 20, 4);
			// $Drugo2_adv nie ma schematu rozwoju
			$Glowne_cur=array_splice($table[1], 4, 8);
			$Drugo1_cur=array_splice($table[1], 4, 4);
			$Drugo2_cur=array_splice($table[1], 4, 4);//tu error zmień 5->4

			$data['Glowne'] = array($Glowne_ini,$Glowne_adv,$Glowne_cur);
			$data['Drugo1'] = array($Drugo1_ini,$Drugo1_adv,$Drugo1_cur);
			$data['Drugo2'] = array($Drugo2_ini,$Drugo2_cur);
			$data['RestInfo'] = $table;
			$data['curCareer'] = $this->chats->getProfesje($data['BG']['CURCAREER_ID']);
			$data['prevCareer'] = $this->chats->getProfesje($data['BG']['PREVCAREER_IDs']);
			//$a=array_keys($data['BG']);
			//$this->printr($data['talents']);

			//$this->printr($data['curCareer']);
			$data['aSkills'] = $this->chats->getAvaibleSkills($data['curCareer']['AVAIBLESKILLS']);
			//$aTalents = $this->chats->getAvaibleTalents($data['curCareer']['AVAIBLETALENTS']);
			//$this->vardump($data['aSkills']);	//tu
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
	public function rozne() {
		$request = \Config\Services::request();
		//$data['skillName'] = 'Kuglarstwo';
		$data['skillName'] = $request->getPost('skillName');
		setlocale(LC_ALL, "en_US.utf8");
		$skillBaseName = 'w_um_'.preg_replace("/'/", "", iconv("utf-8", "ascii//TRANSLIT", preg_replace('/\s+/', '', mb_strtolower($data['skillName']))));
		$data['skillsDetails']= $this->chats->getSkillsDetails($skillBaseName);

		return view('rozne',$data);
	}
	public function send() {
		$request = \Config\Services::request();
		$session = \Config\Services::session();
		date_default_timezone_set('Europe/Warsaw');
		$date = date('Y-m-d H:i:s');
		$message = array(
			'pengirim' => session('nama'),
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


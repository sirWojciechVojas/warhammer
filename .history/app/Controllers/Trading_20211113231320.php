<?php namespace App\Controllers;

use App\Models\ChatsModel;
use App\Models\TradingModel;
use stdClass;

class Trading extends BaseController
{
	public function __construct() {
		parent::__construct();
		$this->trading = model('TradingModel');
		$this->chats = model('ChatsModel');
		$this->BG = model('BGModel');
		$this->router = \Config\Services::router();
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$this->view = \Config\Services::renderer();
		$this->bgId = $this->session->get('ID');
	}
	public function index()
	{
		//return redirect()->to(base_url('login'));
		// $data['js']='handout';
		// echo view('header');
		// echo view('home');
		// echo view('footer');
		// return $this->audio();
		// $this->umzd();
	}
	public function new(){
		$data = [
			'NAME' => 'Kindżał',
			'DESCRIPTION' => 'Miły w dotyku',
			'DETAILS' => '',
			'ITEM_CLASS' => 'WEAPON',
			'ITEM_ID' => '13',
			'ITEM_GENRE' => '',
			'IMG_CLASS' => '',
			'PRIZE' => 14000,
			'CHARGE' => 150,
		];
			$model = new TradingModel();
			$model->save($data);
	}
	public function trading() {
		$data['swv'] = 'sirWojciech';
		return view('trading',$data);
	}
	public function tGoods() {

		//$data['mGoldPanel'] = $this->mGoldPanel('Imperium','Goods',$data['mGold']);
		// $data['controller'] = $this;
		// $this->printr($data['tGoods']);
		$outputTbl=new stdClass();
		$this->view->setVar('tGoods', $this->chats->getInvBG())
					->setVar('acc', null)
					->setVar('controller', $this);
		$outputTbl->tGInd = $this->view->render('tGInd');
		$outputTbl->tFlankL = $this->view->setVar('side', 'left')->render('tFlank');
		$outputTbl->tFlankR = $this->render('tFlank');

		return json_encode($outputTbl);
	}
	public function tDetails() {

		// $data['what'] = ($this->request->getPost('what')!==null) ? $this->chats->getInvTempId($this->request->getPost('idTemp')) : $this->chats->getInvTempId(1);
		// $this->printr($this->chats->getInvTempId($this->request->getPost('idTemp')));
		$what = $this->request->getPost('what');
		$dictArr = array(
						'ITEM_CLASS'=>'w_itemclass',
						'ITEM_ID'=>'w_bron',
						'ITEM_CATEGORY'=>'w_itemclass',
						'IMG_CLASS'=>'w_itemclass',
						);

		$outputTbl=new stdClass();
		$this->view->setVar('what', $what)
					->setVar('content', $this->request->getPost('content'))
					->setVar('iClass', $this->trading->getInvTempDist($dictArr[$what]));
		// $this->view->setVar('iClass', $dictArr[$what]);
		$outputTbl->tClassEdit  = $this->view->render('tClassEdit');

		return json_encode($outputTbl);
	}
	public function update() {
		$data = ($this->request->getPost('co')!==null) ? $this->request->getPost('co') : null;
		$model = new TradingModel();
		$model->save($data);
		return $this->tradingGM();
	}

	public function tradingGM() {
		$data['equipFieldNames'] = $this->trading->getInvTempNames();
		$data['equipFTemplate'] = $this->trading->getInvTemp();
		$data['invTemp'] = ($this->request->getPost('idTemp')!==null) ? $this->trading->getInvTempId($this->request->getPost('idTemp')) : $this->trading->getInvTempId(1);
		$data['controller'] = $this;
		// $this->printr($this->chats->getInvTempId(1));

		$outputTbl=new stdClass();
		$this->view->setVar('equipFieldNames', $this->trading->getInvTempNames())
				   ->setVar('equipFTemplate', $this->trading->getInvTemp())
				   ->setVar('invTemp', $data['invTemp'])
				   ->setVar('controller', $this);
		$outputTbl->tEdit  = $this->view->render('tEdit');
		$outputTbl->tAdd  = $this->view->render('tAdd');
		$outputTbl->tGTemp = $this->view->render('tGTemp');

		// return $data['idTemp'];
		return json_encode($outputTbl);
	}

	public function mGoldPanel($prefix,$type,$mGold) {
		$data['prefix'] = $prefix;
		$data['type'] = $type;
		$data['mGold'] = $mGold;
		return view('mGold',$data);
	}
	public function mGoldCalc($Brass,$currency) {

		$e = new stdClass();
		if($currency==1){
			$e->mCrown = floor($Brass/7680);
			$e->mShilling = floor(($Brass%7680)/64);
			$e->mPenny = ($Brass%7680)%32;
			$e->hBrass = $Brass;
		}
		else {
			$e->mCrown = floor($Brass/240);
			$e->mShilling = floor(($Brass%240)/12);
			$e->mPenny = ($Brass%240)%12;
			$e->hBrass = $Brass;
		}

		return $e;
	}
	//--------------------------------------------------------------------

}

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
	public function trading() {
		$data['swv'] = 'sirWojciech';
		return view('trading',$data);
	}
	public function tGoods() {

		$data['tGoods'] = $this->chats->getInvBG();
		//$data['mGoldPanel'] = $this->mGoldPanel('Imperium','Goods',$data['mGold']);
		$data['controller'] = $this;
		// $this->printr($data['tGoods']);
		return view('tGInd',$data);
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
	//--------------------------------------------------------------------

}

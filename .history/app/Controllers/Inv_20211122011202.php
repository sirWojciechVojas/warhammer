<?php namespace App\Controllers;

use App\Models\ChatsModel;
use App\Models\InvModel;
use App\Models\InvBGModel;
use stdClass;

class Inv extends BaseController
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
		$model = new InvModel();
		$this->printr($model->getInvTemp());
		//return redirect()->to(base_url('login'));
		// $data['js']='handout';
		// echo view('header');
		// echo view('home');
		// echo view('footer');
		// return $this->audio();
		// $this->umzd();
	}
	public function new(){
		$idTemp = ($this->request->getPost('idTemp')!==null) ? $this->request->getPost('idTemp') : 1;
		$model = new InvModel();
		$data = $model->find($idTemp);
		$data['ID']=null;
		// $this->printr($data);
		$model->save($data);
		return $this->tradingGM();
	}
	public function tradingN() {
		$data['swv'] = 'sirWojciech';
		return view('trading',$data);
	}
	public function tGoods() {
		$data['nClass'] = ($this->request->getPost('nClass')!==null) ? $this->request->getPost('nClass') : null;
		//$data['mGoldPanel'] = $this->mGoldPanel('Imperium','Goods',$data['mGold']);
		// $data['controller'] = $this;
		$outputTbl=new stdClass();
		$this->view->setVar('tGoods', $this->chats->getInvBG())
					->setVar('acc', null)
					->setVar('nClass', $data['nClass'])
					->setVar('controller', $this);
		$outputTbl->tGInd = $this->view->render('tGoods');
		$outputTbl->tFlankL = $this->view->setVar('side', 'left')->render('tFlank');
		$outputTbl->tFlankR = $this->view->setVar('side', 'right')->render('tFlank');
		// $this->vardump($outputTbl);

		return json_encode($outputTbl);
	}
	public function tDetails() {
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
					->setVar('invItem', $this->invItem())
					->setVar('iClass', $this->trading->getInvTempDist($dictArr[$what]));
		// $this->view->setVar('iClass', $dictArr[$what]);
		$outputTbl->tClassEdit  = $this->view->render('tClassEdit');

		return json_encode($outputTbl);
	}
	public function invItem(){

		for($i=0;$i<1400;$i++){
				// $outputTbl[]= ($i<10) ? 'x0'.++$i : 'x'.++$i;
				if($i<9) $preV = 'v000';
				else if($i>=9 && $i<99) $preV = 'v00';
				else if($i>=99 && $i<999) $preV = 'v0';
				else $preV = 'v';
				$outputTbl[$i] =  $preV.($i+1);
		}
		// $this->printr($outputTbl);
		return $outputTbl;
	}
	public function update() {
		$data = ($this->request->getPost('co')!==null) ? $this->request->getPost('co') : null;
		$model = new InvModel();
		$model->save($data);
		return $this->tradingGM();
	}

	public function tradingGM($nClass=null) {
		$invModel = new InvModel();
		$invBGModel = new InvBGModel();

		$data['idTemp'] = ($this->request->getPost('idTemp')!==null) ? $invModel->getInvTempId($this->request->getPost('idTemp')) : $invModel->getInvTempId(1);
		$data['idInd'] = ($this->request->getPost('idInd')!==null) ? $invBGModel->getInvTempId($this->request->getPost('idInd')) : $invBGModel->getInvTempId(1);
		$data['nClass'] = ($this->request->getPost('nClass')!==null) ? $this->request->getPost('nClass') : $nClass;
		// $data['controller'] = $this;
		$outputTbl  = new stdClass();
		$outputTbl->nClass  = $nClass;
		// return $outputTbl;
		// $this->printr($invBGModel->getInvTempNames());
		// $this->printr($invBGModel->getInvTrash());
		$this->view->setVar('tempFieldNames', $invModel->getInvTempNames())
				   ->setVar('indFieldNames', $invBGModel->getInvTempNames())
				   ->setVar('acc', 'GM')
				   ->setVar('nClass', $data['nClass'])
				   ->setVar('idTemp', $data['idTemp'])
				   ->setVar('idInd', $data['idInd'])
				   ->setVar('controller', $this);
		$outputTbl->tGTemp = $this->view->setVar('tGoods', $invModel->getInvTemp())->render('tGoods');// Szablony
		$outputTbl->tEdit  = $this->view->render('tEdit');
		$outputTbl->tGEdit = $this->view->render('tGEdit');
		$outputTbl->tAdd  = $this->view->render('tAdd');
		$outputTbl->tFlankL = $this->view->setVar('side', 'left')->render('tFlank');
		$outputTbl->tFlankR = $this->view->setVar('side', 'right')->render('tFlank');
		$outputTbl->tTrash = $this->view->setVar('nClass', 'trashInd')->setVar('tGoods', $invBGModel->getInvTrash())->render('tGoods');// Stos

		// return $data['indId'];
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
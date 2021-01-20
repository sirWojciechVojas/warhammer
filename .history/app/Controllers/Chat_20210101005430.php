<?php namespace App\Controllers;

use App\Models\ChatsModel;
use App\Controllers\Gui;
use stdClass;

Class Chat extends BaseController {

	public $CI = NULL;

	public function __construct() {
		parent::__construct();
		$this->regis = model('RegisModel');
		$this->chats = model('ChatsModel');
		$this->BG = model('BGModel');
		$this->router = \Config\Services::router();
		$this->session = \Config\Services::session();
		$this->request = \Config\Services::request();
		$this->bgId = $this->session->get('ID');
	}

	public function index() {
		//echo session('user').'<br>';
		$ses=$this->session->get('user');
		//echo 'zalogowano użytkownika: <b>'.$ses.'</b><br>';
		if ($this->session->get('isLoggedIn') == FALSE) {
			$this->session->setFlashdata('login', '<div class="alert alert-warning alert-dismissable">
												<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
												<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Musisz się zalogować!</strong>
											</div>');
			return redirect()->to(base_url('login'));
		} else {
			$data['ajax'] = false;
			$data['orang'] = $this->regis->orang();
			$data['BG'] = $this->chats->getCechy2();
			$data['BGs']=$this->BG->getBGinfo();
			$table = $this->chats->getCechy();

			$data['skills']= $this->chats->getAllSkills();
			$data['talents']= $this->chats->getAllTalents();
			$data['i']=0;
			$Glowne_ini=array_splice($table[0], 14, 8);
			$Drugo1_ini=array_splice($table[0], 14, 4);
			$Drugo2_ini=array_splice($table[0], 14, 4);
			$Glowne_adv=array_splice($table[1], 22, 8);
			$Drugo1_adv=array_splice($table[1], 22, 4);
			// $Drugo2_adv nie ma schematu rozwoju
			$Glowne_cur=array_splice($table[1], 4, 8);
			$Drugo1_cur=array_splice($table[1], 4, 4);
			$Drugo2_cur=array_splice($table[1], 4, 6);//tu error zmień 5->4

			// $this->printr($Drugo1_ini);
			// $this->printr($Glowne_cur);
			// $this->printr($Drugo1_cur);
			// $this->printr($Drugo2_cur);


			$data['Glowne'] = array($Glowne_ini,$Glowne_adv,$Glowne_cur);
			$data['Drugo1'] = array($Drugo1_ini,$Drugo1_adv,$Drugo1_cur);
			$data['Drugo2'] = array($Drugo2_ini,$Drugo2_cur);
			$data['RestInfo'] = $table;
			$data['curCareer'] = $this->chats->getProfesje($data['BG']['CURCAREER_ID']);
			$data['prevCareer'] = $this->chats->getProfesje($data['BG']['PREVCAREER_IDs']);
			$data['aSkills'] = $this->chats->getAvaibleSorT($data['curCareer']['AVAIBLESKILLS'],'umiejetnosci');
			$data['aTalents'] = $this->chats->getAvaibleSorT($data['curCareer']['AVAIBLETALENTS'],'zdolnosci');
			$data['mGold'] = $this->chats->getGold();
			$data['diary'] = $this->chats->getDiary();
			$data['ip'] = $this->request->getIPAddress();
			//$this->printr($this->chats->dupa());
			// $this->printr($this->chats->getDiary());
/*
			foreach($this->chats->getSkillsCurrentId() as $IdNum){
				$data['allMySkills'][]=$data['skills'][$IdNum['NAME']-1];
			}
*/
			$data['allMySkillsId'] = $this->chats->getSorTCurrentId('um');
			$data['allMySkills'] = $this->chats->getSorTCurrent('um','umiejetnosci');
			// $this->printr($data['allMySkills']);
			$data['allMyTalentsId'] = $this->chats->getSorTCurrentId('zd');
			$data['allMyTalents'] = $this->chats->getSorTCurrent('zd','zdolnosci');


			//$data['oProfessions'] = $this->chats->getProfesje($data['BG']['OUTPUTPROFESSION']);
			//$a=array_keys($data['BG']);

			$data['PD'] = $this->chats->getPD();
			$data['HP'] = $this->chats->getHP();
			//$this->printr($data['HP']);

			//$this->printr( $this->generujKod(128));
			//$this->printr($data['aSkills']);
			//$this->printr($data['aTalents']);
			$data['status'] = $this->chats->getStatus();
			$data['chat']   = $this->chats->chatContent()->getResult();
			// $this->printr($data['chat']);

			$data['dices']  = array(2,4,6,8,10,12,20,100,'3D');
			$data['session']=$this->session;
			//$this->printr($_SESSION);

			$js['js']='chat.inc.js';
			// $js['wsAddress']= preg_replace('#http#','ws',substr(base_url('../..'),0,-1));// zamiana 8080 na 8082

			$js['wsAddress']= (preg_match('#ngrok#',BASE_WS)) ? BASE_WS : BASE_WS.':'.PORT_WS;
			$js['wsAddress'].= '?access_token=';
			// $this->printr($js['wsAddress']);
			$js['controller']=$this;
			$js['controllerName']=$this->router->controllerName();
			$js['methodName']=$this->router->methodName();
			echo view('header',$js);
			echo view('chat', $data);
			echo view('footer',$js);
		}
	}
	public function update_diary() {
		$textArea = $this->request->getPost('textArea');
		$this->chats->updateDiary($textArea);
		return json_encode($this->chats->getDiary());

		// return time();
	}
	public function data_images() {
		return json_encode($this->chats->dataImg());
	}
	public function update_hp() {
		$ile=$_POST['ile'];
		return json_encode($this->chats->updateHP($ile));
	}
	public function gain_pd() {
		$ile = $this->request->getPost('ile');
		$data = $this->chats->gainPD($ile);
		// $data=new stdClass();
		$guiClass = new Gui();
		$data->pdbars = $guiClass->umzd('PDBar');

		return json_encode($data);
	}
	public function rozne() {
		$request = \Config\Services::request();
		// $data['skillName'] = 'Kuglarstwo';
		$data['skillName'] = $request->getPost('skillName');
		setlocale(LC_ALL, "en_US.utf8");
		$skillBaseName = preg_replace("/'/", "", iconv("utf-8", "ascii//TRANSLIT", preg_replace('/\s+/', '', mb_strtolower($data['skillName']))));
		$data['skillsDetails']= $this->chats->getSkillsDetails($skillBaseName);

		return view('rozne',$data);
		//return json_encode($data['skillsDetails']);
	}
	public function dialogBox() {
		$data['prefix'] = $this->request->getPost('prefix');
		$data['hBrass'] = $this->request->getPost('hBrass');
		$data['HP'] = $this->chats->getHP();
		if($data['prefix']=='PD') $data['HP']->buttons = array(1,2,5,10,20,50,'reset');
		elseif($data['prefix']=='Brass') $data['HP']->buttons = array(1,2,5,10,20,'reset');
		//print_r($data['HP']);
		if($this->request->getPost('key')){
			$data['traitName'] = $this->request->getPost('key');
			$data['traitAct'] = $this->request->getPost('traitAct');
			// $data['traitAct'] = (is_array($data['traitAct'])) ? json_encode($data['traitAct']) : $data['traitAct'];
			$data['traitAct'] = (is_array($data['traitAct'])) ? htmlspecialchars(json_encode($data['traitAct'])) : $data['traitAct'];

			$data['traitAdv'] = $this->request->getPost('traitAdv');
			$data['traitInit'] = $this->request->getPost('traitInit');
			$data['wTrait'] = $this->request->getPost('wTrait');
			$data['NazwaCechy'] = $this->chats->getNazwyCech()[$data['traitName']];
			$data['titleBar2'] = (in_array($data['traitName'],array('FATEINS','LUCKMOTIVE'))) ? $data['NazwaCechy'] : $this->request->getPost('titleBar').$data['NazwaCechy'];
			$data['titleBar3'] = (preg_match("#&#",$data['NazwaCechy'])) ? explode("&",$data['NazwaCechy']) : $data['NazwaCechy'];
			// $data['titleBar3'] = $data['NazwaCechy'];

		}
		else $data['titleBar2'] = $this->request->getPost('titleBar');
		// return json_encode($data);
		$data['umzd'] = $this->request->getPost('umzd');
		$data['titleBar'] = mb_strtolower($this->request->getPost('titleBar'));
		$data['idUm'] = $this->request->getPost('idUm');


		if($data['prefix']=='Inv') {
			$data['details'] = null;
			$invid = $this->request->getPost('invid');
			// return $invid;
			$data['item'] = $this->chats->getInvId($invid);
			$data['addClass']=' row';
			if($data['item']['ITEM_CLASS']=='WEAPON') $data['item']=$this->chats->getInvWeapon($data['item']['INV_ID']);

			$data['titleBar2']= ($data['item']['PERSONAL_PSEU']) ? :ucfirst($data['item']['NAME']);
			// foreach($data['item'] as $key => $val){
			// 	if($val['ITEM_CLASS']=='WEAPON') $val['Vojasik']='Kasiunia';
			// }
			//return json_encode($data['item']);
		}
		else if($data['prefix']=='UmZd') {
			$data['details'] = $this->request->getPost('details');
			$data['addClass']= null;
		}
		else {
			$data['details'] = null;
			$data['addClass']=' row';
		}
		// return $this->printr($data);

		return view('dialogBox',$data);
		// return json_encode($data);
	}

	public function send() {
		date_default_timezone_set('Europe/Warsaw');
		// $date = $this->request->getPost('time');
		$date = date('Y-m-d H:i:s');
		$message = array(
			'user' => $this->request->getPost('user'),
			'role' => $this->request->getPost('role'),
			'waktu' => $date,
			'teks' => $this->request->getPost('teks')
		);
		//$this->printr($message);
		$this->chats->messageInsert($message);
		// $data['orang'] = $this->regis->orang();
		// $data['chat']=$this->chats->chatContent()->getResult();
		// $data['status'] = $this->chats->getStatus();
		// $data['ajax']=true;
		// $data['session']=$this->session;
		// return 'VOJAS';
		// return view('chat', $data);
		//return redirect()->to(base_url('chat'));
		// return 'coooooooo';
	}

	public function awans() {

		$data['BG'] = $this->chats->getCechy2();
		$data['curCareer'] = $this->chats->getProfesje($data['BG']['CURCAREER_ID']);
	//	$data['curCareer'] = $this->chats->getProfesje($data['BG']['PREVCAREER_IDs']);
		$data['aSkills'] = $this->chats->getAvaibleSorTId($data['curCareer']['AVAIBLESKILLS']);
		// $data['aTalents'] = $this->chats->getAvaibleSorTId($data['curCareer']['AVAIBLETALENTS']);
		$getSkillsCurrent = $this->chats->getSorTCurrentId('um');
		//$getTalentsCurrent = $this->chats->getSorTCurrentId('zd');
		// $this->printr($getTalentsCurrent);
		//$this->printr($data['aSkills']);

		$this->awansLoop($data['aSkills'],$getSkillsCurrent,'um',0);

		//$elegy[0][0]=15;
		//$this->awansLoop($elegy,$getTalentsCurrent,'zd');

		//$this->printr( $this->generujKod(128));
		//$this->printr($data['curCareer']);

		//return json_encode($this->chats->getProfesje(67));
		//return json_encode($getSkillsCurrent);
		//return 'wszystko ok!';
	}
	public function ransom_trait() {
		$data['traitName']=$this->request->getPost('traitName');
		$data['traitInc']=$this->request->getPost('traitInc');
		$data['traitAct']=$this->request->getPost('traitAct');
		$data['expCost']=$this->request->getPost('expCost');

		$model = new ChatsModel();
		if(is_array($data['traitName'])){
			$data['traitNamePL'][0]=$model->getNazwyCech()[$data['traitName'][0]];
			$data['traitNamePL'][1]=$model->getNazwyCech()[$data['traitName'][1]];
		}
		else $data['traitNamePL']=$model->getNazwyCech()[$data['traitName']];

		// return json_encode($data);
		return $model->ransomTrait($data);
	}
	public function ransom_pd() {
		//$getSOrT=$this->request->getPost('getSOrT');//to ktore chcemy dodac
		$co = $this->request->getPost('co'); //um lub zd
		$getSOrT[0][0] = $this->request->getPost('idUm');
		//if(is_nan($this->request->getPost('details'))) $getSOrT=1;
		// return var_dump($this->request->getPost('details'));
		$details = $this->request->getPost('details');
		if($details!=="") $getSOrT[0][0] .= '|'.$details;
		// return 	json_encode($getSOrT);
		// return json_encode($getSOrT);

		// $this->db->trans_begin();
		$this->chats->updatePD();
		//$this->printr($getSOrT);
		$getCurrent = $this->chats->getSorTCurrentId($co);//get Skills Or Talents Current
		//$this->printr($getSOrT);
		$this->awansLoop($getSOrT,$getCurrent,$co,1);
		// $this->db->trans_complete();
		$guiClass = new Gui();
		return json_encode($guiClass->umzd('UmZd'));
	}
	public function awansLoop($SorT,$gSorTC,$tbl,$status){

		foreach($SorT as $val1){
			$i=count($val1);
			$i = ($i==2)? $this->generujKod(128): $i;//kod powiązań umiejetnosci "albo"
			foreach($val1 as $val2){
				$a=0;
				if(preg_match('#\|#',$val2)){
					$v=explode('|',$val2);
					$val2=$v[0];
					$val3=$v[1];
				}
				else $val3=null;
				foreach($gSorTC as $row){
					//if($row['SKILLNAME']==$val2 && $row['SKILLNAME']==$val3 && $row['BGNAME']==$this->bgId)	$a=1;
					if($row['NAME']==$val2 && $row['DETAILS']==$val3 && $row['BGNAME']==$this->bgId){ $id=(int) $row['ID']; $a=1; $b=$row['STATUS']; $c=$row['LEVEL'];}

				}
				if($status==1) $b++;
				else $c++;
				if($a==1){
					$allUpdate[]=array(
						'ID'=>$id,
						/*'SKILLNAME'=>$val2,
						'DETAILS'=>$val3,
						'BGNAME'=>$this->bgId,*/
						'STATUS'=>$b,
						'LEVEL'=>$c,
						/*'CONNECT'=> $i*/
					);
				}
				else {
					$allInsert[]=array(
						'ID'=>NULL,
						'NAME'=>$val2,
						'DETAILS'=>$val3,
						'BGNAME'=>$this->bgId,
						'STATUS'=>0,
						'LEVEL'=>1,
						'CONNECT'=> $i
					);
				}

				//$i++;
			}
		}

		//$this->printr($getSkillsCurrent);
		if(isset($allUpdate)){
			// $bty=[$allUpdate,$id,$tbl,gettype(count($allUpdate))];
			// $this->printr($bty);
			// $this->printr($allUpdate);
			return $this->chats->updateSorT($allUpdate,$id,$tbl);
		}
		if(isset($allInsert)){
			// $this->printr($allInsert);
			//$this->printr($tbl);
			return $this->chats->insertSorT($allInsert,$tbl);
		}

	}
	public function brass() {
		$brass = $this->request->getPost('brass');
		$this->chats->updateGold($brass);
	}
	public function generujKod($dlugoscKodu) {
		$znaki = "abcdefghijkmnoprstuwxyzq"; //bez małego L
		$znaki .= "ABCDEFGHIJKLMNPRSTUWZYXQ"; // bez O
		$znaki .= "123456789"; // bez 0
		$dl = strlen($znaki) - 1;
		$wynik=null;
		for($i =0; $i < $dlugoscKodu; $i++)
		  {
		   $losuj = rand(0, $dl);
		   $wynik .=  $znaki[$losuj];
		   }
		return $wynik;
	}

	public function slot() {
		$data['slot'] = $this->request->getPost('slot');
		$data['invid'] = $this->request->getPost('invid');
		return $this->chats->updateSlot($data);
	}
	public function inventory() {
		$data['invBG']=htmlspecialchars(json_encode($this->chats->getInvBG()));
		// $this->printr($this->chats->getInvBG());
		$data['slots']=array(
				 'A'=>['head','amulet','arm_R','belt','ring_R','leg_R','feet'],
				 'B'=>['cape','armor','arm_L','hands','ring_L','leg_L','pupil'],
				 'handy'=>['quiver1','quiver2','handy1','handy2','handy3']
				);
		$wspV=25.744;
		// $this->request->isAJAX()
		//$wspV=40;
		$data['type']=$this->request->getPost('type');
		// $this->printr($data['type']);
		$data['w']=floor($this->request->getPost('w')/$wspV);
		$data['imax']=$this->request->getPost('nrRow');
		$data['jmax']=round($this->request->getPost('w')/$wspV);
		// header( "Content-Type: application/json" );

		// $a = json_encode(view('inventory',$data));
		// return $data['type'];
		// $output = view('inventory', $data);
		// echo json_encode($output);
		return view('inventory',$data);
	}
	public function change() {
		$this->session->set($this->request->getPost('sesi'));
	}
	public function open() {
		return $this->chats->main(TRUE);
	}

	public function maintenance() {
		return $this->chats->main(FALSE);
	}

	public function pending() {
		if ($this->session->get('isLoggedIn') == FALSE) {
			$this->session->setFlashdata('login', '<div class="alert alert-warning alert-dismissable">
												<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
												<i class="fa fa-exclamation-circle">&nbsp;</i> <strong>Musisz się zalogować!</strong>
											</div>');

			return redirect()->to(base_url('login'));
		} else {
			$data['orang'] = $this->regis->orang();
			$data['status'] = $this->chats->getStatus();
			$data['session'] = $this->session;
			$js['js']='chat.inc.js';
			$js['controllerName']=$this->router->controllerName();
			$js['methodName']=$this->router->methodName();
			echo view('header');
			echo view('pending', $data);
			echo view('footer',$js);
		}
	}

	public function aktif() {
		$uri = $this->request->uri;
		$user = $uri->getSegment(3);
		$this->regis->aktif($user);
		return redirect()->to(base_url('chat/pending'));
	}
	public function nonaktif($user) {
		$uri = $this->request->uri;
		$user = $uri->getSegment(3);
		$this->regis->nonaktif($user);
		return redirect()->to(base_url('chat/pending'));
	}
	public function delete_user($user) {
		$uri = $this->request->uri;
		$user = $uri->getSegment(3);
		$this->regis->deleteUser($user);
		return redirect()->to(base_url('chat/pending'));
	}
}
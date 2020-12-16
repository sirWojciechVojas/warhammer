<?php namespace App\Models;

use CodeIgniter\Model;

class ChatsModel extends Model {

	public function __construct(){
		$this->db	= \Config\Database::connect();
		$this->session = \Config\Services::session();
		//var_dump( $this->session->get('ID'));
		$this->ID = (int) $this->session->get('ID');
		//$this->ID = 4;
	}

	public function chatContent(){
		return $this->db->table('chat')->orderBy('waktu','ASC')->get();
	}

	public function messageInsert($message){
		$this->db->table('chat')->set($message)->insert();
	}

	public function main($status) {
		$this->db->table('status')->set('status', $status)->update();
		return redirect()->to(base_url('chat'));
	}
	public function getSkillsDetails($skillBaseName) {
		return $this->db->table('w_umzd')->where(['CLASS'=>$skillBaseName])->get()->getResultArray();
		// return $this->db->table($tableName)->get()->getResultArray();
	}
	public function getAllSkills() {
		return $this->db->table('w_umiejetnosci')->get()->getResultArray();
	}
	public function getAllTalents() {
		return $this->db->table('w_zdolnosci')->get()->getResultArray();
	}
	public function getProfesje($ID) {
		return $this->db->table('w_profesje')->where('ID',$ID)->get()->getRowArray();
	}
	public function getCechy2() {
		return $this->db->table('w_bg_start')->join('w_bg_current','w_bg_current.USEDNAME_ID = w_bg_start.ID','left')->where('w_bg_current.USEDNAME_ID',$this->ID)->get()->getRowArray();
		//return $this->db->table('w_bg_start')->get()->getResultArray();
	}
	public function getNazwyCech() {
		$result = $this->db->table('w_cechypostaci')->get()->getResultArray();
		foreach($result as $row)
		{
			$array[$row['NAME']] = $row['TRANS_PL'];
		}
		return $array;
	}
	public function getCechy() {
		//return $this->db->table('w_bg_init')->where('ID', 4)->get()->getResultArray();
		$bg[] = $this->db->table('w_bg_start')->where('ID',$this->ID)->get()->getRowArray();
		$bg[] = $this->db->table('w_bg_current')->where('USEDNAME_ID',$this->ID)->get()->getRowArray();
		//return $this->db->table('w_bg_current')->where('USEDNAME',$this->ID)->get()->getRowArray();
		return $bg;
	}
	public function dupa() {
		return $this->db->table('w_umzd')->where(['IND'=>2,'CLASS'=>'wiedza'])->get()->getResult()[0]->NAME;
	}
	public function getAvaibleSorT($AVAIBLE,$tbl) {

		$skills=$this->db->table('w_'.$tbl)->get()->getResult();
		$array=explode(',',$AVAIBLE);
		$done=0;
		foreach($array as $key => $str)
		{
			//return $this->printr($array);
			$Pos1=strpos($str, "[");
			$Pos2=strpos($str, "]");
			if($Pos1!==false){
				$Pos1++;
				$ins=substr($str, $Pos1,$Pos2-$Pos1);
				//$ins = preg_replace('#\[|]#',null,$ins);
				$ins = explode('|', $ins);
				$iledel=1;
			}
			else $ins=$str;

			$array[$key] = explode('|', $str);

			foreach($array[$key] as $ke => $st){
				$array[$key][$ke] = explode('|', $st);

				$sa = preg_replace('#\[|]#',null,$st);
				$pos1=strpos($sa, ")");
				$pos2=strpos($sa, ")");
				$s = preg_replace('#\(.+\)#',null,$sa);
				//echo $skills[$s-1]->NAME;
				$s = preg_replace('#.\(.+\)#',null,$skills[$s-1]->NAME);
				if($pos1 !==false){
					$pos1++;
					//$d1 = substr($sa, $pos1,$pos2-$pos1);
					setlocale(LC_ALL, "en_US.utf8");
					$skillBaseName = preg_replace("/'/", "", iconv("utf-8", "ascii//TRANSLIT", preg_replace('/\s+/', '', mb_strtolower($s))));
					//$sreturn = $this->db->table($skillBaseName)->where('ID',4)->get()->getResult()[0]->NAME;
					//$ins = $s.' ('.$sreturn.')';
					foreach($array[$key][$ke] as $k => $s){
						$s = $ins;

						$pos_1=strpos($ins[$k], "(")+1;
						$pos_2=strpos($ins[$k], ")");
						if($pos_2 !==false){
							foreach($s as $K => $S){
								$s[$K] = substr($s[$K], $pos_1,$pos_2-$pos_1);
								$S = preg_replace('#\(.+\)#',null,$S);
								$S = preg_replace('#.\(.+\)#',null,$skills[$S-1]->NAME);
								$s[$K] = $S.' ('.$skillBaseName.')';
								//$s[$K] = $S.' ('.$this->db->table($skillBaseName)->where('ID',$s[$K])->get()->getResult()[0]->NAME.')';
							}
							$s = substr($ins[$k], $pos_1[$k],$pos_2[$k]-$pos_1[$k]);
							$s = preg_replace('#\(.+\)#',null,$s);
						}
						else {
							$s=preg_replace('#\(.+\)#',null,$st);
							$posIni=strpos($st, "(")+1;
							$posEnd=strpos($st, ")");
							$st=(int) substr($st, $posIni,$posEnd-$posIni);

							$s= preg_replace('# \(.+\)#',null,$skills[$s-1]->NAME);
							$s= ($st==0) ? $s.' (dowolność)' : $s.' ('.$this->db->table('w_umzd')->where(['IND'=>$st,'CLASS'=>$skillBaseName])->get()->getResult()[0]->NAME.')';
							//$s = ($st==0) ? $s.' (dowolność)' : $s.' ('.$st.'|'.$skillBaseName.')';
							//$s=$st;
						}
						$array[$key][$ke] = $s;
					}
				}

					//$s = $array[$key][$k];


				//else $s=false;
				//else $d=false;
				//$s = $ins;
				//$s = $skills;
				$array[$key][$ke] = $s;
			}
			$array[$key]=array_values(array_unique($array[$key], SORT_REGULAR));
		}

		return $array;
	}

	public function getAvaibleSorTId($AVAIBLE) {

		//$skills=$this->db->table('w_umiejetnosci')->get()->getResult();
		//$talents=$this->db->table('w_zdolnosci')->get()->getResult();

		$array=explode(',',$AVAIBLE);
		$done=0;
		foreach($array as $key => $str)
		{
			$Pos1=strpos($str, "[");
			$Pos2=strpos($str, "]");
			if($Pos1!==false){
				$Pos1++;
				$ins=substr($str, $Pos1,$Pos2-$Pos1);
				//$ins = preg_replace('#\[|]#',null,$ins);
				$ins = explode('|', $ins);
				$iledel=1;
			}
			else $ins=false;

			$array[$key] = explode('|', $str);

			foreach($array[$key] as $ke => $st){
				$array[$key][$ke] = explode('|', $st);

				$sa = preg_replace('#\[|]#',null,$st);
				$pos1=strpos($sa, ")");
				$pos2=strpos($sa, ")");
				$s = preg_replace('#\(.+\)#',null,$sa);
				//$s = preg_replace('#.\(.+\)#',null,$skills[$s-1]->NAME);
				if($pos1 !==false){
					$pos1++;
					//$d1 = substr($sa, $pos1,$pos2-$pos1);
					setlocale(LC_ALL, "en_US.utf8");
					$skillBaseName = 'w_um_'.preg_replace("/'/", "", iconv("utf-8", "ascii//TRANSLIT", preg_replace('/\s+/', '', mb_strtolower($s))));
					//$sreturn = $this->db->table($skillBaseName)->where('ID',4)->get()->getResult()[0]->NAME;
					//$ins = $s.' ('.$sreturn.')';
					foreach($array[$key][$ke] as $k => $s){
						$s = $ins;
						$pos_1=strpos($ins[$k], "(")+1;
						$pos_2=strpos($ins[$k], ")");
						if($pos_2 !==false){
							foreach($s as $K => $S){
								$s[$K] = substr($s[$K], $pos_1,$pos_2-$pos_1);
								$S = preg_replace('#\(.+\)#',null,$S);
								//$S = preg_replace('#.\(.+\)#',null,$skills[$S-1]->NAME);
								//$s[$K] = $S.' ('.$this->db->table($skillBaseName)->where('ID',$s[$K])->get()->getResult()[0]->NAME.')';
							}
							$s = substr($ins[$k], $pos_1[$k],$pos_2[$k]-$pos_1[$k]);
							//$s = preg_replace('#\(.+\)#',null,$s);
						}
						else {
							$s=preg_replace('#\(.+\)#',null,$st);
							$posIni=strpos($st, "(")+1;
							$posEnd=strpos($st, ")");
							$st=(int) substr($st, $posIni,$posEnd-$posIni);

							//$s= preg_replace('# \(.+\)#',null,$skills[$s-1]->NAME);
							//$s= ($st==0) ? $s.' (dowolność)' : $s.' ('.$this->db->table($skillBaseName)->where('ID',$st)->get()->getResult()[0]->NAME.')';
							$s= $s.'|'.$st;
							//$s=$st;
						}
						$array[$key][$ke] = $s;
					}
				}

					//$s = $array[$key][$k];


				//else $s=false;
				//else $d=false;
				//$s = $ins;
				//$s = $skills;
				$array[$key][$ke] = $s;
			}
			$array[$key]=array_values(array_unique($array[$key], SORT_REGULAR));
		}

		return $array;
	}
	public function getSorTCurrentId($tbl) {
		return $this->db->table('w_bg_'.$tbl.'_current')->getWhere(['BGNAME'=>$this->ID])->getResultArray();
	}
	public function getSorTCurrent($tbl,$tblAll) {
		$tabela = $this->db->table('w_bg_'.$tbl.'_current')->join('w_'.$tblAll,'w_bg_'.$tbl.'_current.NAME = w_'.$tblAll.'.ID','left')->orderBy('w_bg_'.$tbl.'_current.NAME','DESC')->getWhere(['BGNAME'=>$this->ID])->getResultArray();
		foreach($tabela as $key => $skill){
				setlocale(LC_ALL, "en_US.utf8");
				$skillBaseName = preg_replace("/'/", "", iconv("utf-8", "ascii//TRANSLIT", preg_replace('/\s+/', '', mb_strtolower(preg_replace('#\(różne\)#',null,$skill['NAME'])))));
				//$skillAdd = $skill['DETAILS'].'|'.$skillBaseName;
				if($skill['DETAILS']!=="" && $skill['DETAILS']!=='0') {
					$skillAdd = $this->db->table('w_umzd')->where(['IND'=>$skill['DETAILS'],'CLASS'=>$skillBaseName])->get()->getResult()[0]->NAME;
					$skill['NAME']=preg_replace('#(różne)#',$skillAdd,$skill['NAME']);

				}
				elseif($skill['DETAILS']=='0'){
					$skill['NAME']=preg_replace('#(różne)#','dowolność',$skill['NAME']);
				}
				$tabela[$key]=$skill;
		}
		return $tabela;
	}
	public function insertSorT($allInsert,$tbl) {
		if(count($allInsert)==1) return $this->db->table('w_bg_'.$tbl.'_current')->insert($allInsert);
		else return $this->db->table('w_bg_'.$tbl.'_current')->insertBatch($allInsert);
	}
	public function updateSorT($allUpdate,$id,$tbl) {
		if(count($allUpdate)==1) return $this->db->table('w_bg_'.$tbl.'_current')->update($allUpdate[0],['ID' => $id]);
		else return $this->db->table('w_bg_'.$tbl.'_current')->updateBatch($allUpdate,'ID');
	}

	public function gainPD($ile) {
		$this->db->table('w_bg_current')->set('CUREXP',"CUREXP + $ile",false)->set('ALLEXP',"ALLEXP + $ile",false)->where(['USEDNAME_ID'=>$this->ID])->update();
		$data = $this->db->table('w_bg_current')->select('CUREXP, ALLEXP')->getWhere(['USEDNAME_ID'=>$this->ID])->getRow();
		$data->ile=$ile;
		return $data;
	}
	public function updatePD() {
		$this->db->table('w_bg_current')->set('CUREXP',"CUREXP - 100",false)->where(['USEDNAME_ID'=>$this->ID])->update();
		return 'ready';
	}
	public function updateHP($ile) {
		$this->db->table('w_bg_current')->set('HP',"HP + $ile",false)->where(['USEDNAME_ID'=>$this->ID])->update();
		$data = $this->db->table('w_bg_current')->select('HP, WOUNDS, (HP / WOUNDS * 100)  as HPpercent')->getWhere(['USEDNAME_ID'=>$this->ID])->getRow();
		$data->ile=$ile;
		return $data;
	}
	public function updateGold($brass) {
		return $this->db->table('w_bg_current')->set('BRASS',"BRASS + $brass",false)->where(['USEDNAME_ID'=>$this->ID])->update();
	}
	public function getGold() {
		return $this->db->table('w_bg_current')->select('FLOOR(BRASS/240) as mCrown, FLOOR((BRASS%240)/12) as mShilling, (BRASS%240)%12 as mPenny, BRASS as hBrass')->getWhere(['USEDNAME_ID'=>$this->ID])->getRow();
	}
	public function getHP() {
		$a = $this->db->table('w_bg_current')->select('HP, WOUNDS, (HP / WOUNDS * 100)  as HPpercent')->getWhere(['USEDNAME_ID'=>$this->ID])->getRow();
		$a->buttons = array(1,2,3,5,'reset');
		return $a;
	}

	public function dataImg() {
		$table = $this->db->table('users')->select('user, role')->get()->getResultArray();
		foreach($table as $val){
			$x=$val['user'];
			// unset($val['SLOT']);
			// $val['NAME'].='<div class="fixed-bottom">Szczegóły: PPM.</div>';
			$outputTbl[$x] = $val['role'].'.png';
		}
		return $outputTbl;
	}
	public function getPD() {
		$callback = function($val){return $val['total'];};	//ciekawy trick => cdn.
		for($i=1;$i<=5;$i++){
			switch ($i) {
				case 1:
					$a = ($this->db->table('w_bg_um_current')->select('SUM(STATUS - LVL_INPROF) as total')->getWhere(['BGNAME'=>$this->ID,'STATUS !='=>0])->getRow())->total;
					$b = ($this->db->table('w_bg_zd_current')->select('SUM(STATUS - LVL_INPROF) as total')->getWhere(['BGNAME'=>$this->ID,'STATUS !='=>0])->getRow())->total;
					$c1 = $this->db->table('w_bg_current')->select('SUM(WEAPONSKILL) + SUM(BALLISTICSKILL) + SUM(STRENGTH) + SUM(TOUGHNESS) + SUM(AGILITY) + SUM(INTELLIGENCE) + SUM(WILLPOWER) + SUM(FELLOWSHIP) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total'];
					$c2 = $this->db->table('w_bg_start')->select('SUM(WEAPONSKILL_IN) + SUM(BALLISTICSKILL_IN) + SUM(STRENGTH_IN) + SUM(TOUGHNESS_IN) + SUM(AGILITY_IN) + SUM(INTELLIGENCE_IN) + SUM(WILLPOWER_IN) + SUM(FELLOWSHIP_IN) as total', FALSE)->getWhere(['ID'=>$this->ID])->getResultArray()[0]['total'];
					$c = ($c1-$c2)/5;
					$d1 = $this->db->table('w_bg_current')->select('SUM(WOUNDS) + SUM(ATTACK) + SUM(MOVEMENT) + SUM(MAGIC) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total'];
					$d2 = $this->db->table('w_bg_start')->select('SUM(WOUNDS_IN) + SUM(ATTACK_IN) + SUM(MOVEMENT_IN) + SUM(MAGIC_IN) as total', FALSE)->getWhere(['ID'=>$this->ID])->getResultArray()[0]['total'];
					$d = $d1-$d2;
					break;
				case 2:
					//$a1 = $this->db->table('w_bg_um_current')->select('ID, MAX(LEVEL - LVL_INPROF)')->groupBy('CONNECT')->where(['BGNAME'=>$this->ID,'CONNECT !='=>1])->get()->getResultArray();
					$a1 = $this->db->table('w_bg_um_current')->select('MAX(LEVEL - LVL_INPROF) as total')->groupBy('CONNECT')->getWhere(['BGNAME'=>$this->ID,'CONNECT !='=>1])->getResultArray();
					$a1 = array_sum(array_map($callback, $a1));	//cd. polegający na uproszczeniu tablicy zagnieżdżonej a potem zsumowaniu elementów
					$a2 = ($this->db->table('w_bg_um_current')->select('SUM(LEVEL - LVL_INPROF) as total')->where(['BGNAME'=>$this->ID,'CONNECT'=>1])->get()->getRow())->total;
					$a=$a1+$a2;
					$b1 = $this->db->table('w_bg_zd_current')->select('MAX(LEVEL - LVL_INPROF) as total')->groupBy('CONNECT')->getWhere(['BGNAME'=>$this->ID,'CONNECT !='=>1])->getResultArray();
					$b1 = array_sum(array_map($callback, $b1));	//cd. polegający na uproszczeniu tablicy zagnieżdżonej a potem zsumowaniu elementów
					$b2 = ($this->db->table('w_bg_zd_current')->select('SUM(LEVEL - LVL_INPROF) as total')->where(['BGNAME'=>$this->ID,'CONNECT'=>1])->get()->getRow())->total;
					$b=$b1+$b2;
					//$a1 = ($this->db->table('w_bg_um_current')->selectSum('STATUS')->groupBy('CONNECT')->where(['BGNAME'=>$this->ID])->get()->getRow())->STATUS;
					$c = $this->db->table('w_bg_current')->select('SUM(WEAPONSKILL_ADV) + SUM(BALLISTICSKILL_ADV) + SUM(STRENGTH_ADV) + SUM(TOUGHNESS_ADV) + SUM(AGILITY_ADV) + SUM(INTELLIGENCE_ADV) + SUM(WILLPOWER_ADV) + SUM(FELLOWSHIP_ADV) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total']/5;
					$d = $this->db->table('w_bg_current')->select('SUM(WOUNDS_ADV) + SUM(ATTACK_ADV) + SUM(MOVEMENT_ADV) + SUM(MAGIC_ADV) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total'];
					break;
				case 3:
					$a = ($this->db->table('w_bg_um_current')->select('SUM(LEVEL - LVL_INPROF) as total')->where(['BGNAME'=>$this->ID])->get()->getRow())->total;
					$b = ($this->db->table('w_bg_zd_current')->select('SUM(LEVEL - LVL_INPROF) as total')->where(['BGNAME'=>$this->ID])->get()->getRow())->total;
					$c = $this->db->table('w_bg_current')->select('SUM(WEAPONSKILL_ADV) + SUM(BALLISTICSKILL_ADV) + SUM(STRENGTH_ADV) + SUM(TOUGHNESS_ADV) + SUM(AGILITY_ADV) + SUM(INTELLIGENCE_ADV) + SUM(WILLPOWER_ADV) + SUM(FELLOWSHIP_ADV) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total']/5;
					$d = $this->db->table('w_bg_current')->select('SUM(WOUNDS_ADV) + SUM(ATTACK_ADV) + SUM(MOVEMENT_ADV) + SUM(MAGIC_ADV) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total'];
					break;
				case 4:
					$a1 = $this->db->table('w_bg_um_current')->select('MAX(STATUS - LVL_INPROF) as total')->groupBy('CONNECT')->getWhere(['BGNAME'=>$this->ID,'CONNECT !='=>1])->getResultArray();
					$a1 = array_sum(array_map($callback, $a1));	//cd. polegający na uproszczeniu tablicy zagnieżdżonej a potem zsumowaniu elementów
					$a2 = ($this->db->table('w_bg_um_current')->select('SUM(STATUS - LVL_INPROF) as total')->where(['BGNAME'=>$this->ID,'CONNECT'=>1])->get()->getRow())->total;
					$a=$a1+$a2;
					$b1 = $this->db->table('w_bg_zd_current')->select('MAX(STATUS - LVL_INPROF) as total')->groupBy('CONNECT')->getWhere(['BGNAME'=>$this->ID,'CONNECT !='=>1])->getResultArray();
					$b1 = array_sum(array_map($callback, $b1));	//cd. polegający na uproszczeniu tablicy zagnieżdżonej a potem zsumowaniu elementów
					$b2 = ($this->db->table('w_bg_zd_current')->select('SUM(STATUS - LVL_INPROF) as total')->where(['BGNAME'=>$this->ID,'CONNECT'=>1])->get()->getRow())->total;
					$b=$b1+$b2;
					$c1 = $this->db->table('w_bg_current')->select('SUM(WEAPONSKILL) + SUM(BALLISTICSKILL) + SUM(STRENGTH) + SUM(TOUGHNESS) + SUM(AGILITY) + SUM(INTELLIGENCE) + SUM(WILLPOWER) + SUM(FELLOWSHIP) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total'];
					$c2 = $this->db->table('w_bg_start')->select('SUM(WEAPONSKILL_IN) + SUM(BALLISTICSKILL_IN) + SUM(STRENGTH_IN) + SUM(TOUGHNESS_IN) + SUM(AGILITY_IN) + SUM(INTELLIGENCE_IN) + SUM(WILLPOWER_IN) + SUM(FELLOWSHIP_IN) as total', FALSE)->getWhere(['ID'=>$this->ID])->getResultArray()[0]['total'];
					$c = ($c1-$c2)/5;
					$d1 = $this->db->table('w_bg_current')->select('SUM(WOUNDS) + SUM(ATTACK) + SUM(MOVEMENT) + SUM(MAGIC) as total', FALSE)->getWhere(['USEDNAME_ID'=>$this->ID])->getResultArray()[0]['total'];
					$d2 = $this->db->table('w_bg_start')->select('SUM(WOUNDS_IN) + SUM(ATTACK_IN) + SUM(MOVEMENT_IN) + SUM(MAGIC_IN) as total', FALSE)->getWhere(['ID'=>$this->ID])->getResultArray()[0]['total'];
					$d = $d1-$d2;
					break;
				case 5:
					$a = (($this->db->table('w_bg_current')->select('CUREXP as total')->getWhere(['USEDNAME_ID'=>$this->ID])->getRow())->total)/100;
					$b=$c=$d=0;
					break;
			}
			$PD[$i]=($a+$b+$c+$d)*100;
		}
		$PD[3]= ($PD[3]==0) ? 1:$PD[3];
		$PD[]=$PD[1]/$PD[3]*100;
		$PD[]=$PD[2]/$PD[3]*100;
		$PD[]=$PD[4]/$PD[3]*100;
		$PD[]=$PD[5]/$PD[3]*100;

		//return $b;//*100 PD :)
		return $PD;//*100 PD :)
	}
	public function updateSlot($data) {
		return $this->db->table('w_ekwipunek_bg')->set('SLOT',$data['slot'],true)->where(['ID'=>$data['invid']])->update();
		// return $data['slot'];
	}
	public function getInvWeapon($invid) {
		return $this->db->table('w_ekwipunek')->join('w_ekwipunek_bg','w_ekwipunek_bg.INV_ID = w_ekwipunek.ID','left')->join('w_bron','w_bron.ID = w_ekwipunek.ITEM_ID','left')->where('w_ekwipunek.ID',$invid)->get()->getRowArray();
	}
	public function getInvId($invid) {
		return $this->db->table('w_ekwipunek')->join('w_ekwipunek_bg','w_ekwipunek_bg.INV_ID = w_ekwipunek.ID','left')->where('w_ekwipunek_bg.ID',$invid)->get()->getRowArray();
	}
	public function getInvBG() {
		$inventoryTbl = $this->db->table('w_ekwipunek')->join('w_ekwipunek_bg','w_ekwipunek_bg.INV_ID = w_ekwipunek.ID','left')->where('w_ekwipunek_bg.OWNER',$this->ID)->get()->getResultArray();
		foreach($inventoryTbl as $val){
			$x=$val['SLOT'];
			unset($val['SLOT']);
			// $val['NAME'].='<div class="fixed-bottom">Szczegóły: PPM.</div>';
			$outputTbl[$x] = $val;
		}
		return $outputTbl;
	}

	public function getStatus() {
		return $this->db->table('status')->get()->getResult();
	}
	public function updateDiary($msg) {
		// return $this->db->table('w_dziennik')->set('NOTES',$msg,true)->where(['USEDNAME_ID'=>$this->ID])->update();
		$this->db->table('w_dziennik')->set('NOTES',$msg,true)->set('updated_at','NOW()',false)->where(['USEDNAME_ID'=>$this->ID])->update();
	}
	public function getDiary() {
		return $this->db->table('w_dziennik')->select('NOTES, created_at, updated_at')->where(['USEDNAME_ID'=>$this->ID])->get()->getRow();
	}
	public function ransomTrait($data) {

		// $this->db->transStart();
		// $this->db->setDatabase('test');
		// $this->db->setDatabase('test');
		// $this->db->table('w_bg_current')->set(['CUREXP'=>98,'WEAPONSKILL'=>48])->where(['USEDNAME_ID'=>$this->ID])->update();

		$builder=$this->db->table('w_bg_current');

		// $gra= [$traitAct,$traitNew,$traitIncBonus];
		// return json_encode($gra);
		if(is_array($data['traitName'])){
			$data['traitSum'] = array_map(function (...$arrays) {
				return array_sum($arrays);
			}, $data['traitAct'], $data['traitInc']);
			$first=$data['traitName'][0];
			$second=$data['traitName'][1];
			$builder->set("$first",$data['traitSum'][0], false)->set("$second",$data['traitSum'][1], false);
			$builder->where(['USEDNAME_ID'=>$this->ID]);
			$builder->update();
			$data['many']=count($data['traitName']);
		}
		else{
			$traitAct=$data['traitAct']%10;
			$traitNew=($data['traitAct']+$data['traitInc'])%10;
			$traitIncBonus=floor(($data['traitAct']+$data['traitInc'])/10);
			if($data['traitName']=='STRENGTH' && $traitNew<$traitAct) $builder->set('STRENGTHBONUS',$traitIncBonus, false);
			else if($data['traitName']=='TOUGHNESS' && $traitNew<$traitAct) $builder->set('TOUGHNESSBONUS',$traitIncBonus, false);

			$builder->set("$data[traitName]","$data[traitName]+$data[traitInc]", false)->set('CUREXP',"CUREXP-$data[expCost]", false);
			$builder->where(['USEDNAME_ID'=>$this->ID]);
			$builder->update();
			$data['many']=1;
		}


		return json_encode($data);
		// $this->db->transComplete();
	}
}
<?php namespace App\Models;

use CodeIgniter\Model;

class InvBGModel extends Model {

	protected $table      = 'w_ekwipunek_bg';
	protected $primaryKey = 'ID';

	protected $useAutoIncrement = true;

	// protected $returnType     = 'array';
	// protected $useSoftDeletes = true;

	protected $allowedFields = ['INV_ID','SLOT','PERSONAL_PSEU','PERSONAL_DESC','QUANTITY','OWNER_OPT','OWNER'];

	protected $useTimestamps = true;
	protected $createdField  = 'CREATED_AT';
	protected $updatedField  = 'UPDATED_AT';
	protected $deletedField  = 'DELETED_AT';

	// protected $validationRules    = [];
	// protected $validationMessages = [];
	// protected $skipValidation     = false;

	public function __construct(){
		$this->db	= \Config\Database::connect();
		$this->session = \Config\Services::session();
		//var_dump( $this->session->get('ID'));
		$this->ID = (int) $this->session->get('ID');
		//$this->ID = 4;
	}
	public function getInvTrash() {
		$trashTbl = $this->db->table('w_ekwipunek')->join('w_ekwipunek_bg','w_ekwipunek_bg.INV_ID = w_ekwipunek.ID','left')->where('w_ekwipunek_bg.OWNER_OPT',2)->get()->getResultArray();
		foreach($trashTbl as $key => $val){
			// $x=$val['SLOT'];
			// unset($val['SLOT']);
			// $val['NAME'].='<div class="fixed-bottom">Szczegóły: PPM.</div>';
			$outputTbl[$key] = $val;
		}
		return $outputTbl;
	}
	public function getInvTempNames(){
		$outputTbl = array_slice($this->db->getFieldNames('w_ekwipunek_bg'), 0, 8, true);
		return $outputTbl;
	}
	public function getInvTemp(){
		return $this->db->table('w_ekwipunek')->get()->getResultArray();
	}
	public function getInvTempDist($tName){
		$table = $this->db->table($tName)->select('NAME')->get()->getResultArray();
		foreach($table as $key => $val){
			$outputTbl[$key] = $val['NAME'];
		}
		return $outputTbl;
	}
	public function getInvTempId($ID){
		return $this->db->table('w_ekwipunek_bg')->getWhere(['ID'=>$ID])->getRow();
	}
}
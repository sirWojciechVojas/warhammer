<?php namespace App\Models;

use CodeIgniter\Model;

class TradingModel extends Model {

	protected $table      = 'w_ekwipunek';
	protected $primaryKey = 'ID';

	protected $useAutoIncrement = true;

	protected $returnType     = 'array';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['name', 'email'];

	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;

	public function __construct(){
		$this->db	= \Config\Database::connect();
		$this->session = \Config\Services::session();
		//var_dump( $this->session->get('ID'));
		$this->ID = (int) $this->session->get('ID');
		//$this->ID = 4;
	}

	public function getInvTempNames(){
		return $this->db->getFieldNames('w_ekwipunek');
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
		return $this->db->table('w_ekwipunek')->getWhere(['ID'=>$ID])->getRow();
	}
}
<?php namespace App\Controllers;

use CodeIgniter\Files\File;
use diceRoller\DiceRoll;

class FileX extends BaseController
{
	public function index()
	{
		//return redirect()->to(base_url('login'));
		// $data['js']='handout';
		helper('filesystem');
		$tab1 = get_dir_file_info(APPPATH.'../assets/img/inventory/Inventory_L[72x72]/Kopia fin/');
		$tab2 = array();
		foreach($tab1 as $key => $row) {
			$tab2[$key] = $row['size'];
		}
		array_multisort($tab2, SORT_ASC, $tab1);

		$tab3 = array();
		$i=0;
		// $prev_key=NULL;
		foreach($tab1 as $key => $row) {
			if($i%2==1) {
				// next($tab1);
				if (isset($prev_key)) $tab3[$prev_key] = $row['name'];

			}
			$i++;
			$prev_key = $key;
		}
		echo $this->stringify($tab3);
		// $ni = get_filenames($url);

		// $file = new File($url);
		// echo $file->getBasename();
		// $this->printr($tab3);
		// echo view('header');
		// echo view('home');
		// echo view('footer');
		// return $this->audio();

	}
	public function stringify($data) {
		switch (gettype($data)) {
		  case 'string' : return '\''.addcslashes($data, "'\\").'\'.<br>';
		  case 'boolean': return $data ? 'true' : 'false';
		  case 'NULL'   : return 'null';
		  case 'object' :
		  case 'array'  :
			$expressions = [];
			foreach ($data as $c_key => $c_value) {
			  $expressions[] = $this->stringify($c_key).' => '.
			  				   $this->stringify($c_value);
			}
			return gettype($data) === 'object' ?
			  '(object)['.implode(', ', $expressions).']' :
					  '['.implode(', ', $expressions).']';
		  default: return (string)$data;
		}
	 }
	public function handy(){
		// $tabelaFull = array(
		// 	'' => ,


		// );
	}
	public function audio()
	{
		$data['js']='ws-audio-api.min';
		echo view('headerH');
		echo view('audio');
		echo view('footerH',$data);
	}
	//--------------------------------------------------------------------

}

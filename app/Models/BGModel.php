<?php namespace App\Models;

use CodeIgniter\Model;

class BGModel extends Model {


	public function getBGinfo(){
		$db = \Config\Database::connect();
		//return $db->table('chat')->orderBy('waktu','ASC')->get();
		return $db->table('w_bg_start')->orderBy('ID','ASC')->get()->getResult();
	}
	public function imgInTheDir($fName){
		//$dir = base_url('../warhammer/assets/img/inventory/unit/').$fName;
		$dir = '../assets/img/inventory/unit/'.$fName;
		//$dir = dirname(getcwd() . '/warhammer/assets/img/inventory/unit/'.$fName);
		//return $dir;
		//return is_dir($dir);
		// Open a directory, and read its contents
		if (is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
						if($file != "." && $file != "..") $fileName[]=$file;
    				}
					return $fileName;
    			closedir($dh);
				return "$dir nie jest katalogiem";
			}
		}

	}

}

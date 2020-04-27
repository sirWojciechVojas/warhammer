<?php namespace App\Controllers;

class Bountify extends BaseController{
	
	var $var1;
	var $var2;
	public function __construct() {
		$this->bg = model('BGModel');
	}
	function index () {
		$js['js']='bountify.inc.js';
		$data['dirL']='Inventory_L[72x72]';
		$data['dirS']='Inventory_S[42x42]';
		$data['imgL']=$this->bg->imgInTheDir($data['dirL']);
		$data['imgS']=$this->bg->imgInTheDir($data['dirS']);
		echo view('headerBountify');
		echo view('bountify',$data);
		//$this->printr($data['imgL']);
		echo view('footer',$js);
	}
}
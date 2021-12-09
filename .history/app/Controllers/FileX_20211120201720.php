<?php namespace App\Controllers;

use CodeIgniter\Files\File;
use diceRoller\DiceRoll;

class FileX extends BaseController
{
	public function index()
	{
		//return redirect()->to(base_url('login'));
		// $data['js']='handout';
		// helper('filesystem');
		$controllers = get_filenames(APPPATH.'../assets/img/inventory/Inventory_L[72x72]/Kopia fin/');
		// $ni = get_filenames($url);

		// $file = new File($url);
		// echo $file->getBasename();
		$this->printr($controllers);
		// echo view('header');
		// echo view('home');
		// echo view('footer');
		// return $this->audio();

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

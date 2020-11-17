<?php namespace App\Controllers;

use Roller\Roll;

class Roller extends BaseController
{
	public function index()
	{
		$roll = new Roll();
		$roll->showRoll();
		//return redirect()->to(base_url('login'));

		// $data['js']='handout';
		// echo view('headerRoll');
		// echo view('home');
		// echo view('footerRoll');
		// return $this->audio();

	}
}

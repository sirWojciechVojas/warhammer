<?php namespace App\Controllers;

use App\Models\ChatsModel;

class Gui extends BaseController
{
	public function index()
	{
		//return redirect()->to(base_url('login'));
		// $data['js']='handout';
		echo view('header');
		echo view('home');
		echo view('footer');
		// return $this->audio();

	}
	public function UmZd()
	{
		$model = new ChatsModel();

		$allMySkills

		echo view('headerH');

		echo view('footerH');
	}
	//--------------------------------------------------------------------

}

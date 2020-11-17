<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		//return redirect()->to(base_url('login'));

		// $data['js']='handout';
		echo view('headerRoll');
		echo view('home');
		echo view('footerRoll');
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

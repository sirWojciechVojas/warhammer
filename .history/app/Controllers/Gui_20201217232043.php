<?php namespace App\Controllers;

use App\Models\ChatsModel;

class Gui extends BaseController
{
	public function index()
	{
		//return redirect()->to(base_url('login'));
		// $data['js']='handout';
		// echo view('header');
		// echo view('home');
		// echo view('footer');
		// return $this->audio();
		$this->umzd();
	}
	public function umzd($what)
	{
		$model = new ChatsModel();

		$data['allMySkills'] = $model->getSorTCurrent('um','umiejetnosci');
		$data['allMyTalents'] = $model->getSorTCurrent('zd','zdolnosci');
		$data['PD'] = $model->getPD();
		$data['what'] = $what;
		// $this->printr($data['allMyTalents']);
		// echo view('headerH');
		ob_clean();
		return view('gui',$data);
		// echo view('footerH');
	}
	//--------------------------------------------------------------------

}

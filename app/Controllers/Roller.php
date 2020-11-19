<?php namespace App\Controllers;

use diceRoller\DiceRoll;

class Roller extends BaseController
{
	public function index()
	{
		$roll = new DiceRoll();
		echo $roll->showRoll();
		$js['js']='chat.inc.js';
		$js['wsAddress']= preg_replace('#http#','ws',substr(base_url('../..'),0,-1));
		$js['controller']=$this;
		// $js['controllerName']=$this->router->controllerName();
		// $js['methodName']=$this->router->methodName();

		echo view('footerRoll');
	}
}

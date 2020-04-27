<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{
	public function __construct() {
		$session = \Config\Services::session();
		$request = \Config\Services::request();
	}
	public function metody($x){
		$class_name = get_class($x);
		$methods = get_class_methods($class_name);
		foreach($methods as $method)
		{
    		var_dump($method);
    		echo "<br>";
		}
	}
	public function printr($x){
		echo'<pre>';
		print_r($x);
		echo'</pre>';
	}
	public function vardump($x){
		echo'<pre>';
		var_dump($x);
		echo'</pre>';
	}
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

}

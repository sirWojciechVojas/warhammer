<?php namespace App\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\Chat;

class Server extends BaseController
{
	public function index()
	{

		$wsServer = new WsServer(new Chat());

		$server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new Chat()
				)
			),
			PORT_WS
		);
		$db = db_connect();
		$builder = $db->table('connections');
		$builder->where(['c_id >' => 0])->delete();

		$wsServer->enableKeepAlive($server->loop, 30);

		$server->run();

	}

	//--------------------------------------------------------------------

}

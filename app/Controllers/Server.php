<?php namespace App\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\OriginCheck;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\Chat;

class Server extends BaseController
{
	public function index()
	{

		//$loop = React\EventLoop\Factory::create();
		//$loop->run();
		$checkedApp = new WsServer( new Chat() );
		//$checkedApp->enableKeepAlive($loop, 5);
		//$checkedApp = new OriginCheck(new WsServer( new Chat() ), array('localhost'));
		$checkedAppToPass = new OriginCheck($checkedApp);
		$checkedAppToPass->allowedOrigins[] = BASE;
		// $checkedAppToPass->allowedOrigins[] = BASE_WS;

		$server = IoServer::factory(
			new HttpServer(
				$checkedAppToPass
			),
			PORT_WS
		);
		$checkedApp->enableKeepAlive($server->loop, 10);

		//works, so loop works
		/*
		$server->loop->addPeriodicTimer(5, function () use ($server) {
			foreach ($server->app->clients as $client) {
					$client->send("hello client");
			}
		});
		*/
		$db = db_connect();
		$builder = $db->table('connections');
		$builder->where(['c_id >' => 0])->delete();

		$server->run();

	}

	//--------------------------------------------------------------------

}
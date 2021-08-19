<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use ChatServer\Chat;

$server = IoServer::factory(
    new \Ratchet\Http\HttpServer(new \Ratchet\WebSocket\WsServer(new Chat())),
    8080
);

$server->run();

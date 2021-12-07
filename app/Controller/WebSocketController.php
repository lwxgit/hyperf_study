<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Redis\Redis;
use Hyperf\SocketIOServer\Annotation\Event;
use Hyperf\SocketIOServer\Annotation\SocketIONamespace;
use Hyperf\SocketIOServer\BaseNamespace;
use Hyperf\SocketIOServer\Socket;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Codec\Json;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;


class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{

    public function onMessage($server, Frame $frame): void
    {
//        var_dump($frame->data);

        $container = ApplicationContext::getContainer();

        $redis = $container->get(Redis::class);
        $redis->set($frame->data, $frame->fd);

        $server->push($frame->fd, 'Recv: ' . $frame->data);
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        var_dump('closed');
    }

    public function onOpen($server, Request $request): void
    {

        $server->push($request->fd, 'Opened');
    }
}

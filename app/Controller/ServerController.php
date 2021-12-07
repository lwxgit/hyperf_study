<?php


namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\WebSocketServer\Sender;

/**
 * @AutoController
 */
class ServerController
{
    /**
     * @Inject
     * @var Sender
     */
    protected $sender;

    public function close(int $fd)
    {
        go(function () use ($fd) {
            sleep(1);
            $this->sender->disconnect($fd);
        });

        return '';
    }

    public function send(int $fd, $data)
    {
        $l = $this->sender->push($fd, $data);
        var_dump($l);
        return '';
    }
}

<?php

declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketClient\ClientFactory;
use Hyperf\WebSocketClient\Frame;

class ExampleJob extends Job
{
    public $params;

    /**
     * 任务执行失败后的重试次数，即最大执行次数为 $maxAttempts+1 次
     *
     * @var int
     */
    protected $maxAttempts = 2;

    /**
     * @Inject
     * @var ClientFactory
     */
    protected $clientFactory;

    public function __construct($params)
    {
        // 这里最好是普通数据，不要使用携带 IO 的对象，比如 PDO 对象
        $this->params = $params;
    }

    public function handle()
    {
        // 根据参数处理具体逻辑
        // 通过具体参数获取模型等
        // 这里的逻辑会在 ConsumerProcess 进程中执行

//        $client->push('HttpServer 中使用 WebSocket Client 发送数据。');
//        // 获取服务端响应的消息，服务端需要通过 push 向本客户端的 fd 投递消息，才能获取；以下设置超时时间 2s，接收到的数据类型为 Frame 对象。
//        /** @var Frame $msg */
//        $msg = $client->recv(2);

//        var_dump($this->params);
    }
}

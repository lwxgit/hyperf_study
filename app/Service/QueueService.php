<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\ServerController;
use Hyperf\AsyncQueue\Annotation\AsyncQueueMessage;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Hyperf\WebSocketClient\ClientFactory;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;
use Hyperf\AsyncQueue\Job;


class QueueService
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }


    public function push(Job $job, int $delay = 0): bool
    {
        // 这里的 `ExampleJob` 会被序列化存到 Redis 中，所以内部变量最好只传入普通数据
        // 同理，如果内部使用了注解 @Value 会把对应对象一起序列化，导致消息体变大。
        // 所以这里也不推荐使用 `make` 方法来创建 `Job` 对象。
        return $this->driver->push($job, $delay);


    }


    /**
     * @Inject
     * @var ClientFactory
     */
    protected $clientFactory;

//    public function

    /**
     * @AsyncQueueMessage(delay=10)
     */
    public function example($params)
    {
        // TODO: Implement handle() method.
//        $host = '127.0.0.1:9504';
////        通过 ClientFactory 创建 Client 对象，创建出来的对象为短生命周期对象
//        $client = $this->clientFactory->create($host);
////        向 WebSocket 服务端发送消息
//
//        $client->push('建造完成');

        $container = ApplicationContext::getContainer();
        $redis = $container->get(Redis::class);
        $fd = $redis->get('50');
//        $client->push($fd);
//        var_dump($fd);
        $data = 'finish: ' . $params['time'];
        (new ServerController())->send((int) $fd, $data);
        return 'success';
    }


}

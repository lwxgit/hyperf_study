<?php


namespace App\Job;
//use App\Model\User\UserBuildModel;
//use App\Model\User\UserCityModel;
use App\Controller\ServerController;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Hyperf\SocketIOServer\SocketIO;
use Hyperf\Utils\ApplicationContext;
use Hyperf\WebSocketClient\ClientFactory;


class UserBuildJob extends Job
{
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @Inject
     * @var ClientFactory
     */
    protected $clientFactory;

    public function handle()
    {
        // TODO: Implement handle() method.
        $host = '127.0.0.1:9504';
//        通过 ClientFactory 创建 Client 对象，创建出来的对象为短生命周期对象
        $client = $this->clientFactory->create($host);
//        向 WebSocket 服务端发送消息

        $client->push('建造完成');

        $container = ApplicationContext::getContainer();
        $redis = $container->get(Redis::class);
        $fd = $redis->get('50');
        $client->push($fd);

        (new ServerController())->send($fd);

    }
}

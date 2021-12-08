<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller\Api;

use App\Controller\AbstractController;
use App\Controller\ServerController;
use App\Job\UserBuildJob;
use App\Service\QueueService;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Coroutine;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

/**
 * @AutoController
 */
class GameController extends AbstractController
{
    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    /**
     * @param ResponseInterface $response
     * @return Psr7ResponseInterface
     */
    public function buildBases(ResponseInterface $response): Psr7ResponseInterface
    {
        $data = [
            'key' => 'value',
            'time' => time()
        ];
        $this->service->example($data);
        return $response->json($data);
    }

    /**
     * @param ResponseInterface $response
     * @return Psr7ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testCoroutine(ResponseInterface $response): Psr7ResponseInterface
    {

        $id = Db::table('users')->insertGetId(
            ['email' => 'john@example.com', 'votes' => 0]
        );
        $data = [
            'key' => 'value',
            'time' => time(),
//            'id' => $id
        ];

        $container = ApplicationContext::getContainer();
        $redis = $container->get(Redis::class);
        $fd = $redis->get('50');

        $webSocket = (new ServerController());
//        run(function () use($fd, $webSocket) {
        for ($c = 50; $c--;) {

            Coroutine::create(function () use ($c, $fd, $webSocket) {
//                $tmp_filename = "/tmp/test-{$c}.php";
//                usleep(500);
                for ($n = 100; $n--;) {

                    Db::table('users')->insert(
                        ['email' => "john_{$c}_{$n}@example.com", 'votes' => 0]
                    );
//                    $self = file_get_contents(__FILE__);
//                    file_put_contents($tmp_filename, $self);
//                    assert(file_get_contents($tmp_filename) === $self);
                }

//                $webSocket->send((int) $fd, $c);
//                unlink($tmp_filename);
            });


        }
//        });
//        $this->service->example($data);
        return $response->json($data);
    }
}

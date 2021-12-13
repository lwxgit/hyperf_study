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
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Coroutine;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

/**
 * @AutoController
 */
class RedisController extends AbstractController
{
    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return Psr7ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function set(RequestInterface $request, ResponseInterface $response): Psr7ResponseInterface
    {
        $container = ApplicationContext::getContainer();
        $redis = $container->get(Redis::class);

        $key = $request->input('key',null);
        $value = $request->input('value',null);


        $res = $redis->set($key, $value);
        $result = [
            'code' => 200,
            'msg'  => 'success',
            'data' => $res
        ];
        return $response->json($result);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return Psr7ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function get(RequestInterface $request, ResponseInterface $response): Psr7ResponseInterface
    {
        $container = ApplicationContext::getContainer();
        $redis = $container->get(Redis::class);

        $key = $request->input('key',null);
        $value = $request->input('value',null);


        $res = $redis->get($key);
        $result = [
            'code' => 200,
            'msg'  => 'success',
            'data' => $res
        ];
        return $response->json($result);
    }
}

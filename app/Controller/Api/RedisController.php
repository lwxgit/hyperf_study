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

    const REDIS_NOT_FOUND       = 0;
    const REDIS_STRING          = 1;
    const REDIS_SET             = 2;
    const REDIS_LIST            = 3;
    const REDIS_ZSET            = 4;
    const REDIS_HASH            = 5;
    const REDIS_STREAM          = 6;

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

        $type = $request->input('type',self::REDIS_STRING);
        $key = $request->input('key',null);
        $value = $request->input('value',null);
        if(empty($key) || empty($value)){
            $result = [
                'code' => 400,
                'msg'  => 'fail',
            ];
            return $response->json($result);
        }

        switch ($type){
            case self::REDIS_STRING:
            default:
                $res = $redis->set($key, $value);
            break;
            case self::REDIS_HASH:
                $hashKey = $request->input('hash_key',null);
                $res = $redis->hSet($key, $hashKey, $value);
                break;
        }
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
        $type = $request->input('type',self::REDIS_STRING);
        $key = $request->input('key',null);
        $value = $request->input('value',null);
        if(empty($key)){
            $result = [
                'code' => 400,
                'msg'  => 'fail',
            ];
            return $response->json($result);
        }

        switch ($type){
            case self::REDIS_STRING:
            default:
                $res = $redis->get($key);
                break;
            case self::REDIS_HASH:
                $hashKey = $request->input('hash_key',null);
                $res = $redis->hGet($key, $hashKey);
                break;
        }


        $result = [
            'code' => 200,
            'msg'  => 'success',
            'data' => $res
        ];
        return $response->json($result);
    }
}

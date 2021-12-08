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
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::addRoute(['GET', 'HEAD'], '/actual', 'App\Controller\LinController@index');

// 视图
Router::addRoute(['GET', 'HEAD'], '/chat', 'App\Controller\View\ChatController@index');

// 接口
Router::addRoute(['POST'], '/game/build_bases', 'App\Controller\Api\GameController@buildBases');
Router::addRoute(['POST'], '/game/test_coroutine', 'App\Controller\Api\GameController@testCoroutine');

Router::addServer('ws', function () {
    Router::get('/', 'App\Controller\WebSocketController');
});
Router::get('/favicon.ico', function () {
    return '';
});

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
namespace App\Controller\View;

use App\Controller\AbstractController;
use App\Service\UserService;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\View\RenderInterface;
use App\Service\QueueService;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController
 */
class ChatController extends AbstractController
{
    public function index(RenderInterface $render)
    {
        $res_data = [];
//        $this->example();
        return $render->render('chat/index', $res_data);
    }

    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    /**
     * 注解模式投递消息
     */
    public function example()
    {
        $this->service->example([
            'group@hyperf.io',
            'https://doc.hyperf.io',
            'https://www.hyperf.io',
        ]);

        return 'success';
    }
}

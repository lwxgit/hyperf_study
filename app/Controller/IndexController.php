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
namespace App\Controller;

use App\Service\UserService;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\View\RenderInterface;

/**
 * @AutoController
 */
class IndexController extends AbstractController
{
    public function index_bak()
    {
//        $user = $this->request->input('user', 'Hyperf');
//        $method = $this->request->getMethod();
//
//        return [
//            'method' => $method,
//            'message' => "Hello {$user}.",
//        ];

        $userService = new UserService();
        return $userService->register();
    }
    public function index(RenderInterface $render)
    {
        return $render->render('lin/index', ['name' => 'Hyperf']);
    }
}
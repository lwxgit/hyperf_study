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
namespace App\Controller\Interfaces;

use App\Controller\AbstractController;
use App\Job\UserBuildJob;
use App\Service\QueueService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\ResponseInterface;
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

    public function buildBases(ResponseInterface $response): Psr7ResponseInterface
    {
        $data = [
            'key' => 'value',
            'time' => time()
        ];
        $this->service->example($data);
        return $response->json($data);
    }
}

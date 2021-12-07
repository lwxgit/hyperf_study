<?php


namespace App\Event;


use App\Utils\Log;
use Psr\Log\LoggerInterface;

class UserLogined
{
    // 建议这里定义成 public 属性，以便监听器对该属性的直接使用，或者你提供该属性的 Getter
    public $user;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct($user)
    {
        $this->user = $user;
        $this->logger = Log::get('app');
    }

    public function login(){
        $this->logger->info('login');
    }
}

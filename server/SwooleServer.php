<?php
/**
 * Created by PhpStorm.
 * User: lwx(502510773@qq.com)
 * Date: 2019/10/7
 * Time: 下午 14:09
 */
$serv = new \Swoole\Server("127.0.0.1", 9510);//监听本机8888端口

//swoole配置信息

$serv->set([

    // 一般设置为服务器CPU数的1-4倍

    'worker_num'      => 12,

    // task进程的数量（一般任务都是同步阻塞的，可以设置为单进程单线程）

    'task_worker_num' => 20,

    'daemonize'       => true,

    'open_eof_split'  => true,//打开eof_split检测

    'package_eof'     => PHP_EOL,//设置EOF

    // 以守护进程执行

    //  'task_ipc_mode' => 1,  // 使用unix socket通信，默认模式

    'log_file'        => './runtime/swoole_log/debug.log',

    // swoole日志

    // 数据包分发策略（dispatch_mode=1/3时，底层会屏蔽onConnect/onClose事件，

    // 原因是这2种模式下无法保证onConnect/onClose/onReceive的顺序，非请求响应式的服务器程序，请不要使用模式1或3）

    //  'dispatch_mode' => 2,        // 固定模式，根据连接的文件描述符分配worker。这样可以保证同一个连接发来的数据只会被同一个worker处理

]);

$serv->on('Receive', function($serv, $fd, $from_id, $data) {

    $task_id = $serv->task("Async");

    echo "Dispath AsyncTask: id=$task_id\n";

});

$serv->on('Task', function ($serv, $task_id, $from_id, $data) {

    echo "New AsyncTask[id=$task_id]".PHP_EOL;

    $serv->finish("$data -> OK");

});

$serv->on('Finish', function ($serv, $task_id, $data) {

    echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;

});

$serv->start();

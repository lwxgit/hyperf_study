<?php
use Swoole\Coroutine;
use Swoole\Runtime;
use function Swoole\Coroutine\run;
use function Swoole\Coroutine\go;
use \Swoole\Coroutine\Client as SClient;

Runtime::enableCoroutine();
$s = microtime(true);


$b = [
    'type' => 'User',
    'data' => [
        'uid' => 1
    ]
];
$a = json_encode($b);
run(function () use ($a) {
    // i just want to sleep...
//    for ($c = 100; $c--;) {
//        Coroutine::create(function () {
//            for ($n = 100; $n--;) {
////                echo "1\n";
//                usleep(1000);
//            }
//        });
//    }

    for ($c = 100; $c--;) {
        Coroutine::create(function () use ($c) {
            $tmp_filename = "/tmp/test-{$c}.php";
            for ($n = 100; $n--;) {
                $self = file_get_contents(__FILE__);
                file_put_contents($tmp_filename, $self);
                assert(file_get_contents($tmp_filename) === $self);
            }
            unlink($tmp_filename);
        });
    }

//    for ($i = 0; $i<20; $i++){
//        echo $i . "\n";
//        Coroutine::create(function () use ($a,$i) {
//            $client = new SClient(SWOOLE_SOCK_TCP);
//            if (!$client->connect('127.0.0.1', 9510, 0.5)) {
//                echo "connect failed. Error: {$client->errCode}\n";
//            }
//            for ($j = 0; $j<5; $j++) {
//                echo $i . "-".$j . "\n";
//                $client->send("{$a}\n");
//                \Co::sleep(1);
//            }
//            $client->close();
//        });
//    }


});
echo 'use ' . (microtime(true) - $s) . ' s';
echo "finish\n";

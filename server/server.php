<?php
$server = new swoole_server("0.0.0.0",9527,SWOOLE_PROCESS,SWOOLE_SOCK_TCP);

$server->on('connect', function ($serv, $fd){
    echo $fd . ' Connected' . "\n";
});

$server->on('receive', function ($serv, $fd, $from_id, $data){
    echo "received message: {$data} from {$fd}";
});

$server->on('close', function ($serv, $fd){ });

$server->start();

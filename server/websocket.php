<?php
/**
 * websocket 长连接服务
 *
 */
$server = new Swoole\WebSocket\Server("0.0.0.0", 9501);
$server->set(array(
    'worker_num' => 1,   //工作进程数量
    // 'daemonize' => true, //是否作为守护进程
));

$server->on('open', function($server, $request) {
    // echo "server: handshake success with fd{$request->fd}\n";
    swoole_timer_tick(2000, function() use ($server, $request) {
        echo "server: handshake success with fd{$request->fd}\n";
        $server->push($request->fd, "this is server");
    });
});

$server->on('message', function($server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();

<?php

require __DIR__.'/vendor/autoload.php';

$log = new Monolog\Logger('log');

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);

$socket->on('connection', function($client) use ($log, $loop) {
    $log->addInfo('connection '.$client->getRemoteAddress());
    $client->on('data', function($data) use ($log, $loop) {
        // write heavy process here
        $log->addInfo($data);
    });

    $client->on('end', function() {
    });
});

$socket->listen(1337);
$log->addInfo('Server running port:1337');
$loop->run();

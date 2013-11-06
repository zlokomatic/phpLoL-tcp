<?php

require 'vendor/autoload.php';


$client = new zlokomatic\phpLoL\LoLClient('User', 'Password', 'EUW' );

$loop = React\EventLoop\Factory::create();

$socket = new React\Socket\Server($loop);
$socket->on('connection', function ($conn) use ($client) {
    $conn->on('data', function ($data) use ($conn, $client) {
        $data = unserialize($data);
        $resp = serialize(call_user_func_array(array($client, $data['method']), array($data['params']))->toArray());

        $conn->write($resp);
        $conn->getBuffer()->on('full-drain', function () use ($conn) {
            $conn->close();
        });
    });
});
$socket->listen(1337);
echo "Server listening on port 1337\n";

$loop->run();

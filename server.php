<?php

require 'vendor/autoload.php';


$client = new zlokomatic\phpLoL\LoLClient('User', 'Password', 'EUW' );

$loop = React\EventLoop\Factory::create();

$socket = new React\Socket\Server($loop);
$socket->on('connection', function ($conn) use ($client) {
    $conn->on('data', function ($data) use ($conn, $client) {
        $data = unserialize($data);
        $resp = serialize($client->$data['method']($data['params'])->toArray());

        $conn->write($resp);

    });
});
$socket->listen(1337);
echo "Server listening on port 1337\n";

$loop->run();

<?php

require 'vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$client = stream_socket_client('tcp://127.0.0.1:1337');
$conn = new React\Socket\Connection($client, $loop);
$conn->write(serialize(array('method' => 'getSummonerByName',
                             'params' => 'Summoner')));


$conn->on('data', function ($data) use ($conn) {
    $data = unserialize($data);
    print_r($data);
    $conn->close();
});

$loop->run();

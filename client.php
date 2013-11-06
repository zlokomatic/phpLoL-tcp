<?php

require 'vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$client = stream_socket_client('tcp://127.0.0.1:1337');
$conn = new React\Socket\Connection($client, $loop);
$conn->write(serialize(array('method' => 'getMasteryBook',
                             'params' => '12345')));


$outputData = "";
$conn->on('data', function ($data) use ($conn, &$outputData) {
    $outputData .= $data;
});

$loop->run();

print_r(unserialize($outputData));

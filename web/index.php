<?php

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!@socket_connect($sock, 'localhost', 1337)) {
    http_response_code(500);
    echo json_encode([
        'error' => 'cannot connect queue server'
    ]);
    exit;
}
$fileKey = time().rand(1, 10000000);
socket_write($sock, $fileKey, strlen($fileKey));
socket_close($sock);

http_response_code(202);
header('Content-Type: application/json');

echo json_encode([
    'key' => $fileKey
]);

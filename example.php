<?php

use Ubitcorp\DebugHost\Client;

require __DIR__ . '/vendor/autoload.php';

$client = new Client("Your Api Key", "Your Api Secret");

$data = $client->storeLogs(
    'Exam Completed', // Message 
    404, // Status Code 
    '{"code": 0, "file": "Debughost/src/Application.php", "line": 1065}', // Detail
    'examinee-api', // From
    'Symfony\Component\HttpKernel\Exception\HttpException' // Class
);

print_r($data);

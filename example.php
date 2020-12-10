<?php

use Ubitcorp\DebugHost\Client;

require __DIR__ . '/vendor/autoload.php';


$client = new Client("DEBUGHOST API KEY","DEBUGHOST API SECRET");
$data = $client->storeLogs("https://github.com/Ubitcorp/debughost-php-client");

print_r($data);

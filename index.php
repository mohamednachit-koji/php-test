<?php

require __DIR__ . '/vendor/autoload.php';

$name =  $_GET['name'] ?? 'John doe';
$timeout = $_GET['wait'] ?? 0;

$licenseKey = getenv("NEW_RELIC_LICENSE_KEY");
// Send an asynchronous request.
$client = new \GuzzleHttp\Client();
$request = new \GuzzleHttp\Psr7\Request(
    'POST',
    "https://log-api.newrelic.com/log/v1?Api-Key=$licenseKey",
    [
        'json' => ["timestamp" => time(), "message" => "$name => $timeout"],
        'headers' => [
            'Content-Type' => 'application/json',
        ]
    ]
);
$promise = $client->sendAsync($request)->then(function ($response) {
    echo 'I completed! ' . $response->getBody();
});

$promise->wait();

echo "Welcome $name";

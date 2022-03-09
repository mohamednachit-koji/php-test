<?php


$name =  $_GET['name'] ?? 'John doe';
$timeout = $_GET['wait'] ?? 0;

sleep($timeout)

echo "Welcome $name";


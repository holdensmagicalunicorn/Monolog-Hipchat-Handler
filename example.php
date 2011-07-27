<?php

if ($argc < 2) {
    exit('Usage: php example.php <token> <room_id>'.PHP_EOL);
}

if (!isset($argv[1])) {
    throw new \InvalidArgumentException('Please provide a valid hipchat token.');
}

if (!isset($argv[2])) {
    throw new \InvalidArgumentException('Please provide a valid room id');
}

require_once __DIR__.'/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Palleas\HipChat\Monolog\RoomHandler;

$client = new \HipChat($argv[1]);

$log = new Logger('awesome');
$log->pushHandler(new RoomHandler($client, (int)$argv[2]));

$log->addInfo('Palleas is a really nice guy.');
$log->addDebug('Just so you know, it works.');
$log->addWarning("Don't want to scare you, but there is a weird speaking-cat right behing you.");
$log->addError("So, you're using Zend frameworl heh?");
$log->addCritical('We are out of coffee.');
$log->addAlert('Today is tuesday.');

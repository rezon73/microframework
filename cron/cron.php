<?php

require __DIR__ . '/../vendor/autoload.php';

$app = ConsoleApp::me()
    ->setArgs($argv)
    ->start();

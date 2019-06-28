<?php

require __DIR__ . '/../vendor/autoload.php';

$app = WebApp::me();
$app->getRequest()->setGet($_GET);
$app->getRequest()->setPost(
    array_merge(
        $_POST,
        (array) json_decode(file_get_contents('php://input'), true)
    )
);
$app->start();

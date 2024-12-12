<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$router = new \app\Router();
$db = new \app\DB();

$router->addRoute('/', fn () => file_get_contents(__DIR__ . '/home.html'));
$router->addRoute('healthz', fn () => 'ok');
$router->addRoute('search', new \app\SearchController($db)->formatSearchResults(...));

echo $router->parseQueryString();

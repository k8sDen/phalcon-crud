<?php

global $di;
$router = $di->getRouter();

$router->handle($_SERVER['REQUEST_URI']);

$router->add(
    '/users',
    [
        'controller' => 'user',
        'action'     => 'index',
    ],
    ['methods' => ['GET']]
);

$router->add(
    '/users/{id:[0-9]+}',
    [
        'controller' => 'user',
        'action'     => 'show',
    ],
    ['methods' => ['GET']]
);

$router->add(
    '/users',
    [
        'controller' => 'user',
        'action'     => 'create',
    ],
    ['methods' => ['POST']]
);

$router->add(
    '/users/{id:[0-9]+}',
    [
        'controller' => 'user',
        'action'     => 'delete',
    ],
    ['methods' => ['DELETE']]
);

$router->add(
    '/users/{id:[0-9]+}',
    [
        'controller' => 'user',
        'action'     => 'update',
    ],
    ['methods' => ['PUT']]
);
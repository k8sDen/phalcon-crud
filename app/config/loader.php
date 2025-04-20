<?php

use Phalcon\Autoload\Loader;

$loader = new Loader();

$loader->setNamespaces([
    'App\Controllers'  => APP_PATH . '/controllers/',
    'App\Models'       => APP_PATH . '/models/',
    'App\Services'     => APP_PATH . '/services/',
    'App\Repositories' => APP_PATH . '/repositories/',
    'App\Exceptions'   => APP_PATH . '/exceptions/',
    'App\Validations'  => APP_PATH . '/validations/',
]);

$loader->register();

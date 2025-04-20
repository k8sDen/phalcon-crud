<?php
require_once __DIR__ . '/vendor/autoload.php';

use Phalcon\Autoload\Loader;
use Phalcon\Cli\Console;
use Phalcon\Cli\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault\Cli as CliDI;

// Автозагрузка классов
$loader = new Loader();
$loader->setNamespaces([
    'App\Tasks' => __DIR__ . '/app/tasks',
]);
$loader->register();

// DI контейнер
$container = new CliDI();

// 👇 Подключение БД
$container->setShared('db', function () {
    return new Mysql([
        'host'     => 'db',
        'username' => 'user',
        'password' => 'pass',
        'dbname'   => 'phalcon',
        'charset'  => 'utf8',
    ]);
});

// Диспетчер
$dispatcher = new Dispatcher();
$dispatcher->setDefaultNamespace('App\Tasks');
$container ->setShared('dispatcher', $dispatcher);

// Консоль
$console = new Console($container);

// Парсинг аргументов
$arguments = [];
foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

// Выполнение
$console->handle($arguments);

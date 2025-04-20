<?php
declare(strict_types=1);
namespace App\Tasks;

use Phalcon\Cli\Task;

/**
 * Пример CLI задачи.
 */
class MainTask extends Task
{
    public function mainAction(): void
    {
        echo "Привет! Это CLI приложение на Phalcon.\n";
    }
}

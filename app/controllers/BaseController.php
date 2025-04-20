<?php
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    protected function validationErrorsToArray($messages): array
    {
        $errors = [];

        foreach ($messages as $message) {
            $errors[$message->getField()] = $message->getMessage();
        }

        return $errors;
    }
}

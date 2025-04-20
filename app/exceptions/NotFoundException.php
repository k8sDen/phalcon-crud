<?php
declare(strict_types=1);
namespace App\Exceptions;

use Phalcon\Http\Response\Exception as HttpException;

class NotFoundException extends HttpException
{
    /**
     * Статус код 404
     * @var int
     */
    protected $code = 404;

    /**
     * Сообщение об ошибке
     * @var string
     */
    protected $message = 'Not Found';

    public function __construct(string $message = 'Not Found')
    {
        parent::__construct($message, $this->code);
    }
}
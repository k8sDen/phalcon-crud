<?php

namespace App\validations;

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;

class UserCreateValidation extends Validation
{
    public function initialize(): void
    {
        $this->add('name', new PresenceOf([
            'message' => 'Поле name обязательно для заполнения'
        ]));

        $this->add('email', new PresenceOf([
            'message' => 'Поле email обязательно'
        ]));

        $this->add('email', new Email([
            'message' => 'Указан некорректный email'
        ]));

        $this->add('country', new PresenceOf([
            'message' => 'Поле country обязательно для заполнения'
        ]));

        $this->add('city', new PresenceOf([
            'message' => 'Поле city обязательно для заполнения'
        ]));
    }
}


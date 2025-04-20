<?php
declare(strict_types=1);
namespace App\Models;

use Phalcon\Mvc\Model;

/**
 * Пользователь
 */
class User extends Model
{
    /**
     * Идентификатор
     */
    protected ?int $id = null;
    /**
     * Имя
     */
    protected string $name;
    /**
     * E-mail
     */
    protected string $email;
    /**
     * Дата регистрации
     */
    protected ?string $timestamp = null;
    /**
     * Телефон
     */
    protected string $phone;
    /**
     * Город
     */
    protected string $city;
    /**
     * Страна
     */
    protected string $country;

    public function initialize(): void
    {
        $this->setSource('users');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp ? new \DateTime($this->timestamp) : null;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function beforeSave(): void
    {
        $this->timestamp = date('Y-m-d H:i:s');
    }
}
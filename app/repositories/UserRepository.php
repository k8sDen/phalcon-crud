<?php
declare(strict_types=1);
namespace App\Repositories;


use App\Models\User;

/**
 * Репозиторий для работы с пользователями
 */
class UserRepository extends BaseRepository
{
    /**
     * Модель пользователей, с которой будет работать репозиторий
     */
    protected function model(): string
    {
        return User::class;
    }

}
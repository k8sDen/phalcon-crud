<?php
declare(strict_types=1);
namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Phalcon\Paginator\RepositoryInterface;

/**
 * Сервис для работы с пользователями
 */
readonly class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    /**
     * Получает всех пользователей с пагинацией
     * @throws Exception
     */
    public function getPaginatedUsers(int $page, int $perPage): RepositoryInterface
    {
        return $this->userRepository->paginate($page, $perPage);
    }

    /**
     * Получает пользователя по ID
     * @throws Exception
     */
    public function getUserById(int $id): array
    {
        return $this->userRepository->getById($id)->toArray();
    }

    /**
     * Создает нового пользователя
     * @throws Exception
     */
    public function createUser(array $data): array
    {
        $user = $this->userRepository->create($data);
        return $user->toArray();
    }

    /**
     * Удаляет пользователя по ID
     * @throws Exception
     */
    public function deleteUser(int $id): void
    {
        $this->userRepository->delete($id);
    }

    /**
     * Обновляет пользователя по ID
     * @throws Exception
     */
    public function updateUser(int $id, array $data): array
    {
        $user = $this->userRepository->update($id, $data);
        return $user->toArray();
    }
}
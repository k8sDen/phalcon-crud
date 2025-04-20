<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Exceptions\NotFoundException;
use Exception;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Paginator\Adapter\Model;
use Phalcon\Paginator\RepositoryInterface;

/**
 * Базовый класс репозитория
 *
 * @package App\Repositories
 */
abstract class BaseRepository
{
    /**
     * Возвращает имя модели, с которой работает репозиторий
     */
    abstract protected function model(): string;

    /**
     * Пагинация по модели
     */
    public function paginate(int $page = 1, int $perPage = 50, array $parameters = []): RepositoryInterface
    {
        return (new Model([
            'model'      => $this->model(),
            'parameters' => $parameters,
            'limit'      => $perPage,
            'page'       => $page,
        ]))->paginate();
    }

    /**
     * Получает пользователя по ID
     * @throws Exception
     */
    public function getById(int $id): ModelInterface
    {
        /** @var class-string<ModelInterface> $model */
        $model    = $this->model();
        $instance = $model::findFirst($id);

        if (!$instance) {
            throw new NotFoundException("$model not found with ID: $id");
        }

        return $instance;
    }

    /**
     * Создает новую запись в базе данных
     * @throws Exception
     */
    public function create(array $data): ModelInterface
    {
        /** @var class-string<ModelInterface> $model */
        $model    = $this->model();
        $instance = new $model();
        $instance->assign($data);

        if (!$instance->save()) {
            throw new Exception('Failed to create record: ' . implode(', ', $instance->getMessages()));
        }

        return $instance;
    }

    /**
     * Удаляет запись по ID
     * @throws Exception
     */
    public function delete(int $id): void
    {
        /** @var class-string<ModelInterface> $model */
        $model    = $this->model();
        $instance = $model::findFirst($id);

        if (!$instance) {
            throw new NotFoundException("$model not found with ID: $id");
        }

        if (!$instance->delete()) {
            throw new Exception('Failed to delete record: ' . implode(', ', $instance->getMessages()));
        }
    }

    /**
     * Обновляет запись по ID
     * @throws Exception
     */
    public function update(int $id, array $data): ModelInterface
    {
        /** @var class-string<ModelInterface> $model */
        $model    = $this->model();
        $instance = $model::findFirst($id);

        if (!$instance) {
            throw new NotFoundException("$model not found with ID: $id");
        }

        $instance->assign($data);

        if (!$instance->save()) {
            throw new Exception('Failed to update record: ' . implode(', ', $instance->getMessages()));
        }

        return $instance;
    }
}

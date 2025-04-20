<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\UserService;
use App\Validations\UserCreateValidation;
use App\Validations\UserUpdateValidation;
use Exception;
use Phalcon\Http\ResponseInterface;

/**
 * Контроллер для работы с пользователями
 */
class UserController extends BaseController
{
    /**
     * Сервис для работы с пользователями
     */
    protected UserService $userService;
    /**
     * Request объект
     */
    protected \Phalcon\Http\RequestInterface $request;

    public function onConstruct(): void
    {
        $di = $this->getDI();

        $this->userService = $di->get(UserService::class);
        $this->request     = $di->get('request');
    }


    /**
     * Получает всех пользователей с пагинацией
     * @throws Exception
     */
    public function indexAction(): ResponseInterface
    {
        $page       = (int)($this->request->getQuery('page', 'int', 1));
        $perPage    = (int)($this->request->getQuery('per_page', 'int', 50));
        $pagination = $this->userService->getPaginatedUsers($page, $perPage);

        return $this->response->setJsonContent([
            'data'  => $pagination->getItems(),
            'page'  => $pagination->getCurrent(),
            'total' => $pagination->getTotalItems(),
        ]);
    }

    /**
     * Получает пользователя по ID
     * @throws Exception
     */
    public function showAction(int $id): ResponseInterface
    {
        try {
            $user = $this->userService->getUserById($id);

            return $this->response->setJsonContent([
                'data' => $user,
            ]);
        } catch (NotFoundException $e) {
            return $this->response
                ->setStatusCode(404, 'Not Found')
                ->setJsonContent(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(500, 'Server Error')
                ->setJsonContent(['error' => 'Что-то пошло не так']);
        }
    }

    /**
     * Создает нового пользователя
     * @throws Exception
     */
    public function createAction(): ResponseInterface
    {
        $rawBody = $this->request->getJsonRawBody(true);

        if (!is_array($rawBody)) {
            return $this->response
                ->setStatusCode(400, 'Bad Request')
                ->setJsonContent(['error' => 'Невалидный JSON']);
        }

        $validation = new UserCreateValidation();
        $messages   = $validation->validate($rawBody);

        if (count($messages)) {
            return $this->response
                ->setStatusCode(422, 'Unprocessable Entity')
                ->setJsonContent(['errors' => $this->validationErrorsToArray($messages)]);
        }

        $user = $this->userService->createUser($rawBody);

        return $this->response
            ->setStatusCode(201, 'Created')
            ->setJsonContent([
                'message' => 'Пользователь успешно создан',
                'data'    => $user,
            ]);
    }

    /**
     * Удаляет пользователя по ID
     * @throws Exception
     */

    public function deleteAction(int $id): ResponseInterface
    {
        try {
            $this->userService->deleteUser($id);

            return $this->response
                ->setStatusCode(204, 'No Content');
        } catch (NotFoundException $e) {
            return $this->response
                ->setStatusCode(404, 'Not Found')
                ->setJsonContent(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(500, 'Server Error')
                ->setJsonContent(['error' => 'Что-то пошло не так']);
        }
    }

    /**
     * Обновляет пользователя по ID
     * @throws Exception
     */
    public function updateAction(int $id): ResponseInterface
    {
        $rawBody = $this->request->getJsonRawBody(true);

        if (!is_array($rawBody)) {
            return $this->response
                ->setStatusCode(400, 'Bad Request')
                ->setJsonContent(['error' => 'Невалидный JSON']);
        }

        $validation = new UserUpdateValidation();
        $messages   = $validation->validate($rawBody);

        if (count($messages)) {
            return $this->response
                ->setStatusCode(422, 'Unprocessable Entity')
                ->setJsonContent(['errors' => $this->validationErrorsToArray($messages)]);
        }

        try {
            $user = $this->userService->updateUser($id, $rawBody);

            return $this->response
                ->setStatusCode(200, 'OK')
                ->setJsonContent([
                    'message' => 'Пользователь успешно обновлен',
                    'data'    => $user,
                ]);
        } catch (NotFoundException $e) {
            return $this->response
                ->setStatusCode(404, 'Not Found')
                ->setJsonContent(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            return $this->response
                ->setStatusCode(500, 'Server Error')
                ->setJsonContent(['error' => 'Что-то пошло не так']);
        }
    }
}
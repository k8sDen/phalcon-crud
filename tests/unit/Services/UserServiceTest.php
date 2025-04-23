<?php

namespace Tests\Unit\Services;

use App\Repositories\UserRepository;
use App\Services\UserService;
use Exception;
use Phalcon\Paginator\RepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class UserServiceTest extends \Codeception\Test\Unit
{
    private UserRepository&MockObject $userRepository;
    private UserService $userService;

    protected function _before(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userService    = new UserService($this->userRepository);
    }

    /**
     * @throws Exception
     */
    public function testGetPaginatedUsers(): void
    {
        $page      = 1;
        $perPage   = 10;
        $paginator = $this->createMock(RepositoryInterface::class);

        $this->userRepository
            ->expects($this->once())
            ->method('paginate')
            ->with($page, $perPage)
            ->willReturn($paginator);

        $result = $this->userService->getPaginatedUsers($page, $perPage);

        $this->assertSame($paginator, $result);
    }

    /**
     * @throws Exception
     */
    public function testGetUserById(): void
    {
        $userId   = 1;
        $userMock = $this->createMock(\Phalcon\Mvc\Model::class);
        $userMock->method('toArray')->willReturn(['id' => $userId]);

        $this->userRepository
            ->expects($this->once())
            ->method('getById')
            ->with($userId)
            ->willReturn($userMock);

        $result = $this->userService->getUserById($userId);

        $this->assertSame($userId, $result['id']);
    }

    /**
     * @throws Exception
     */
    public function testCreateUser(): void
    {
        $data     = ['name' => 'John Doe'];
        $mockUser = $this->createMock(\Phalcon\Mvc\Model::class);
        $mockUser->method('toArray')->willReturn($data);

        $this->userRepository
            ->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($mockUser);

        $result = $this->userService->createUser($data);

        $this->assertSame($data, $result);
    }

    /**
     * @throws Exception
     */
    public function testDeleteUser(): void
    {
        $userId = 1;

        $this->userRepository
            ->expects($this->once())
            ->method('delete')
            ->with($userId);

        $this->userService->deleteUser($userId);
        
        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     */
    public function testUpdateUser(): void
    {
        $userId   = 1;
        $data     = ['name' => 'Jane Doe'];
        $userMock = $this->createMock(\Phalcon\Mvc\Model::class);
        $userMock->method('toArray')->willReturn($data);

        $this->userRepository
            ->expects($this->once())
            ->method('update')
            ->with($userId, $data)
            ->willReturn($userMock);

        $result = $this->userService->updateUser($userId, $data);

        $this->assertSame($data, $result);
    }
}
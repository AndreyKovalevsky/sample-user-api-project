<?php

declare(strict_types=1);

namespace App\Tests\Service;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\DTO\UserRequest;
use App\DTO\UserResponse;
use App\Entity\User;

class UserServiceTest extends TestCase
{
    public function testGetAll(): void
    {
        $user1 = $this->getUser(true)->setFirstName('Name1');
        $user2 = $this->getUser(true)->setFirstName('Name2');
        $user3 = $this->getUser(true)->setFirstName('Name3');
        $userArray = [$user1, $user2, $user3];

        $userResponse1 = new UserResponse($user1);
        $userResponse2 = new UserResponse($user2);
        $userResponse3 = new UserResponse($user3);
        $userResponseExpectedArray = [$userResponse1, $userResponse2, $userResponse3];

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects(static::once())
            ->method('findAll')
            ->willReturn($userArray);

        $userService = new UserService();
        $userService->userRepository = $userRepository;

        $userResponseArray = $userService->getAll();

        static::assertCount(3, $userResponseArray);
        static::assertEquals($userResponseExpectedArray[0], $userResponseArray[0]);
        static::assertEquals($userResponseExpectedArray[1], $userResponseArray[1]);
        static::assertEquals($userResponseExpectedArray[2], $userResponseArray[2]);
    }

    public function testCreate(): void
    {
        $userRequest = $this->getUserRequest();
        $user = $this->getUser(true);

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects(static::once())
            ->method('store')
            ->willReturnCallback(function (User $user) {
                $user->setId(7);
                return $user;
            })
            ->with(static::equalTo($this->getUser()));

        $userService = new UserService();
        $userService->userRepository = $userRepository;

        static::assertEquals(new UserResponse($user), $userService->create($userRequest));
    }

    public function testUpdate(): void
    {
        $userRequest = $this->getUserRequest();
        $userRequest->lastName = 'AnotherLastName';
        $userRequest->phoneNumber = '01223202020';

        $user = $this->getUser(true);
        $user->setLastName('AnotherLastName')
            ->setPhoneNumber('01223202020');

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects(static::once())
            ->method('store')
            ->with(static::equalTo($user));

        $userService = new UserService();
        $userService->userRepository = $userRepository;

        static::assertEquals(new UserResponse($user), $userService->update($userRequest, $this->getUser(true)));
    }

    public function testDelete(): void
    {
        $user = $this->getUser();

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects(static::once())
            ->method('remove')
            ->with(static::equalTo($user));

        $userService = new UserService();
        $userService->userRepository = $userRepository;

        $userService->delete($user);
    }

    private function getUser(bool $withId = false): User
    {
        $user = (new User())
            ->setFirstName('John')
            ->setLastName('Smith')
            ->setPhoneNumber('+19709587456')
            ->setBirthDate(new DateTime('2011-01-09'));

        if ($withId) {
            $user->setId(7);
        }

        return $user;
    }

    private function getUserRequest(): UserRequest
    {
        $userRequest = new UserRequest();
        $userRequest->firstName = 'John';
        $userRequest->lastName = 'Smith';
        $userRequest->phoneNumber = '+19709587456';
        $userRequest->birthDate = '2011-01-09';
        return $userRequest;
    }
}

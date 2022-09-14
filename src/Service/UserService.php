<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use Exception;
use Symfony\Contracts\Service\Attribute\Required;
use App\Entity\User;
use App\Repository\UserRepository;
use App\DTO\UserRequest;
use App\DTO\UserResponse;

class UserService
{
    #[Required]
    public UserRepository $userRepository;

    public function getAll(): array
    {
        $users = $this->userRepository->findAll();

        return array_map(static function (User $user) {
            return new UserResponse($user);
        }, $users);
    }

    /**
     * @throws Exception
     */
    public function create(UserRequest $userRequest): UserResponse
    {
        $user = $this->setFields($userRequest, new User());
        $this->userRepository->store($user);
        return new UserResponse($user);
    }

    /**
     * @throws Exception
     */
    public function update(UserRequest $userRequest, User $user): UserResponse
    {
        $user = $this->setFields($userRequest, $user);
        $this->userRepository->store($user);
        return new UserResponse($user);
    }

    /**
     * @throws Exception
     */
    public function delete(User $user): void
    {
        $this->userRepository->remove($user);
    }

    /**
     * @throws Exception
     */
    private function setFields(UserRequest $userRequest, User $user): User
    {
        $user->setFirstName($userRequest->firstName)
            ->setLastName($userRequest->lastName)
            ->setPhoneNumber($userRequest->phoneNumber);

        if ($userRequest->birthDate) {
            $user->setBirthDate(new DateTime($userRequest->birthDate));
        }

        return $user;
    }
}

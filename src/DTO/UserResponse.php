<?php

declare(strict_types=1);

namespace App\DTO;

use DateTime;
use App\Entity\User;

class UserResponse
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public ?DateTime $birthDate;
    public ?string $phoneNumber;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
        $this->birthDate = $user->getBirthDate();
        $this->phoneNumber = $user->getPhoneNumber();
    }
}

<?php

declare(strict_types=1);

namespace App\DTO;

use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\SerializedName as Type;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    /**
     * @OA\Property(property="firstName", type="string", example="John"),
     */
    #[Type('string')]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public mixed $firstName;

    /**
     * @OA\Property(property="lastName", type="string", example="Smith"),
     */
    #[Type('string')]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public mixed $lastName;

    /**
     * @OA\Property(property="birthDate", type="string", example="2011-01-09"),
     */
    #[Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Date]
    public mixed $birthDate = null;

    /**
     * @OA\Property(property="phoneNumber", type="string", example="01223202020"),
     */
    #[Type('string')]
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Type('string')]
    #[Assert\Length(max: 255)]
    public mixed $phoneNumber = null;
}

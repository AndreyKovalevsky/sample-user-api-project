<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Exception\ValidationException;
use App\Service\UserService;
use App\Entity\User;
use App\DTO\UserRequest;
use App\DTO\UserResponse;

#[Route('/user')]
class UserController extends ApiController
{
    #[Required]
    public UserService $userService;

    /**
     * Returns all Users
     *
     * @OA\Response(
     *     response=200,
     *     description="All Users",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="success", type="boolean"),
     *        @OA\Property(property="data", type="array", @OA\Items(ref=@Model(type=UserResponse::class)))
     *     )
     * )
     * @OA\Tag(name="Users")
     *
     * @throws Exception
     */
    #[Route('/', name: 'get_all_user', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $usersResponse = $this->userService->getAll();
        return $this->response($usersResponse);
    }

    /**
     * Returns User by ID
     *
     * @OA\Response(
     *     response=200,
     *     description="User",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="success", type="boolean"),
     *        @OA\Property(property="data", type="object", ref=@Model(type=UserResponse::class))
     *     )
     * )
     * @OA\Response(response=404, description="User Not Found")
     * @OA\Tag(name="Users")
     */
    #[Route('/{id}', name: 'get_user', methods: ['GET'])]
    public function getById(User $user): JsonResponse
    {
        return $this->response(new UserResponse($user));
    }

    /**
     * Create User
     *
     * @OA\RequestBody(
     *     required=true,
     *     description="Data to create a new User",
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=UserRequest::class))
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="User",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="success", type="boolean"),
     *        @OA\Property(property="data", type="object", ref=@Model(type=UserResponse::class))
     *     )
     * )
     * @OA\Response(response=400, description="Validation error")
     * @OA\Tag(name="Users")
     */
    #[Route('/', name: 'create_user', methods: ['POST'])]
    #[ParamConverter('userRequest', UserRequest::class, converter: 'fos_rest.request_body')]
    public function create(UserRequest $userRequest, ConstraintViolationListInterface $validationErrors): JsonResponse
    {
        if (count($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        $userResponse = $this->userService->create($userRequest);
        return $this->response($userResponse, Response::HTTP_CREATED);
    }

    /**
     * Update User
     *
     * @OA\RequestBody(
     *     required=true,
     *     description="Data to update User",
     *     @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(ref=@Model(type=UserRequest::class))
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="User",
     *     @OA\JsonContent(
     *        type="object",
     *        @OA\Property(property="success", type="boolean"),
     *        @OA\Property(property="data", type="object", ref=@Model(type=UserResponse::class))
     *     )
     * )
     * @OA\Response(response=400, description="Validation error")
     * @OA\Response(response=404, description="User Not Found")
     * @OA\Tag(name="Users")
     *
     * @throws Exception
     */
    #[Route('/{id}', name: 'update_user', methods: ['PUT'])]
    #[ParamConverter('userRequest', UserRequest::class, converter: 'fos_rest.request_body')]
    public function update(
        User $user,
        UserRequest $userRequest,
        ConstraintViolationListInterface $validationErrors
    ): JsonResponse {
        if (count($validationErrors)) {
            throw new ValidationException($validationErrors);
        }

        $userResponse = $this->userService->update($userRequest, $user);
        return $this->response($userResponse);
    }

    /**
     * Delete User
     *
     * @OA\Response(
     *     response=204,
     *     description="No Content"
     * )
     * @OA\Response(response=404, description="User Not Found")
     * @OA\Tag(name="Users")
     *
     * @throws Exception
     */
    #[Route('/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function delete(User $user): JsonResponse
    {
        $this->userService->delete($user);
        return $this->response(status: Response::HTTP_NO_CONTENT);
    }
}

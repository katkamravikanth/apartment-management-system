<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/users')]
class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    )
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;
    }

    #[Route('', name: 'user_index', methods: ['GET'])]
    #[OA\Get(
        summary: "Get all users",
        responses: [
            new OA\Response(
                response: 200,
                description: "List of users",
                content: new OA\JsonContent(type: "array", items: new OA\Items(ref: new Model(type: User::class)))
            )
        ]
    )]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->json($users, 200, [], ['groups' => ['user']]);
    }

    #[Route('/new', name: 'user_create', methods: ['POST'])]
    #[OA\Post(
        summary: "Create a new user",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "name", type: "string", example: "user name"),
                    new OA\Property(property: "email", type: "string", example: "user@example.com"),
                    new OA\Property(property: "password", type: "string", example: "password123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "User created!"),
            new OA\Response(response: 400, description: "Invalid data"),
            new OA\Response(response: 406, description: "Name, email, and password are required fields"),
            new OA\Response(response: 409, description: "A user with this email already exists."),
            new OA\Response(response: 500, description: "An error occurred while creating the user.")
        ]
    )]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        // Validate required fields
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            return $this->json(['message' => 'Name, email, and password are required fields'], Response::HTTP_NOT_ACCEPTABLE);
        }

        $hashedPassword = $this->passwordHasher->hashPassword(new User(
            $data['name'],
            $data['email'],
            $data['password']
        ), $data['password']);

        $user = new User($data['name'], $data['email'], $hashedPassword);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $this->json(['message' => 'A user with this email already exists.'], Response::HTTP_CONFLICT);
        } catch (\Exception $e) {
            return $this->json(['message' => 'An error occurred while creating the user.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['status' => 'User created!'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    #[OA\Get(
        summary: "Get a user by ID",
        parameters: [
            new OA\Parameter(name: "id", in: "path", description: "User ID", required: true, schema: new OA\Schema(type: "integer"), example: 1)
        ],
        responses: [
            new OA\Response(response: 200, description: "", content: new OA\JsonContent(ref: new Model(type: User::class))),
            new OA\Response(response: 400, description: "Invalid ID type. ID must be a positive integer."),
            new OA\Response(response: 404, description: "User not found.")
        ]
    )]
    public function getUserById($id, UserRepository $userRepository): Response
    {
        $intId = (int) $id;
        if (!is_numeric($id) || $intId <= 0) {
            return $this->json(['message' => 'Invalid ID type. ID must be a positive integer.'], Response::HTTP_BAD_REQUEST);
        }

        $user = $userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);
        }

        if ($user->isDeleted()) {
            return $this->json(['message' => 'This user has been deleted.'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($user, 200, [], ['groups' => ['user']]);
    }

    #[Route('/{id}', name: 'user_update', methods: ['PUT'])]
    #[OA\Put(
        summary: "Update an existing user",
        parameters: [
            new OA\Parameter(name: "id", in: "path", description: "User ID", required: true, schema: new OA\Schema(type: "integer"), example: 1)
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "name", type: "string", example: "user name"),
                    new OA\Property(property: "email", type: "string", example: "user@example.com"),
                    new OA\Property(property: "password", type: "string", example: "password123")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "User updated!"),
            new OA\Response(response: 400, description: "Invalid ID type. ID must be a positive integer."),
            new OA\Response(response: 404, description: "User not found."),
            new OA\Response(response: 406, description: "Name and email are required fields"),
            new OA\Response(response: 409, description: "A user with this email already exists."),
            new OA\Response(response: 500, description: "An error occurred while creating the user.")
        ]
    )]
    public function updateUser(Request $request, $id, UserRepository $userRepository): Response
    {
        $intId = (int) $id;
        if (!is_numeric($id) || $intId <= 0) {
            return $this->json(['message' => 'Invalid ID type. ID must be a positive integer.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        // Fetch user entity
        $user = $userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);
        }

        // Validate required fields
        if (empty($data['name']) || empty($data['email'])) {
            return $this->json(['message' => 'Name and email are required fields'], Response::HTTP_NOT_ACCEPTABLE);
        }

        if (!empty($data['password'])) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword); // Hash the password in a real application
        }

        $user->setName($data['name']);
        $user->setEmail($data['email']);

        try {
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $this->json(['message' => 'A user with this email already exists.'], Response::HTTP_CONFLICT);
        } catch (\Exception $e) {
            return $this->json(['message' => 'An error occurred while updating the user.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['status' => 'User updated!']);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    #[OA\Delete(
        summary: "Delete a user",
        parameters: [
            new OA\Parameter(name: "id", in: "path", description: "User ID", required: true, schema: new OA\Schema(type: "integer"), example: 1)
        ],
        responses: [
            new OA\Response(response: 200, description: "User deleted!"),
            new OA\Response(response: 404, description: "User not found."),
            new OA\Response(response: 400, description: "Foreign key constraint violation."),
            new OA\Response(response: 500, description: "An error occurred while deleting the user."),
        ]
    )]
    public function deleteUser(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);
        }

        try {
            $user->setStatus(false);

            $this->entityManager->remove($user);
            $this->entityManager->flush();
        } catch (ForeignKeyConstraintViolationException $e) {
            return $this->json(['message' => 'Foreign key constraint violation.'], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $this->json(['message' => 'An error occurred while deleting the user.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['status' => 'User deleted!']);
    }
}
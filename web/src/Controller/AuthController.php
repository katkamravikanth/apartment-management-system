<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    #[OA\Post(
        path: '/api/login',
        summary: 'Logs in a user and returns a JWT token',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                type: 'object',
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'password', type: 'string'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'JWT token',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'token', type: 'string')
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Invalid credentials',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'error', type: 'string')
                    ]
                )
            )
        ]
    )]
    public function login(Request $request, UserProviderInterface $userProvider, UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $jwtManager)
    {
        $credentials = json_decode($request->getContent(), true);
        $user = $userProvider->loadUserByUsername($credentials['email']);

        if (!$user || !$encoder->isPasswordValid($user, $credentials['password'])) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
        }

        $token = $jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }

    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    #[OA\Post(
        path: '/api/logout',
        summary: 'Logs out a user',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logged out successfully',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string')
                    ]
                )
            )
        ]
    )]
    public function logout()
    {
        // Handle the logout logic if needed, such as invalidating the token
        // For JWT, this is typically done client-side by simply removing the token from storage
        return new JsonResponse(['message' => 'Logged out successfully'], 200);
    }
}
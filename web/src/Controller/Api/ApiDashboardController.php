<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiDashboardController extends AbstractController
{
    #[Route('/api/dashboard', name: 'app_api_dashboard')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'JWT Authentication Successful! Welcome to dashboard!',
            'path' => 'src/Controller/ApiDashboardController.php',
        ]);
    }
}

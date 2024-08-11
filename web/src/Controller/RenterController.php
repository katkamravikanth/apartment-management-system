<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RenterController extends AbstractController
{
    #[Route('/renter', name: 'app_renter')]
    public function index(): Response
    {
        return $this->render('renter/index.html.twig', [
            'controller_name' => 'RenterController',
        ]);
    }
}

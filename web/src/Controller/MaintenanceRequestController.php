<?php

namespace App\Controller;

use App\Entity\MaintenanceRequest;
use App\Form\MaintenanceRequestType;
use App\Repository\MaintenanceRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/maintenance/request')]
class MaintenanceRequestController extends AbstractController
{
    #[Route('/', name: 'app_maintenance_request_index', methods: ['GET'])]
    public function index(MaintenanceRequestRepository $maintenanceRequestRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('maintenance_request/index.html.twig', [
            'maintenance_requests' => $maintenanceRequestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_maintenance_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $maintenanceRequest = new MaintenanceRequest();
        $form = $this->createForm(MaintenanceRequestType::class, $maintenanceRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($maintenanceRequest);
            $entityManager->flush();

            return $this->redirectToRoute('app_maintenance_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maintenance_request/new.html.twig', [
            'maintenance_request' => $maintenanceRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maintenance_request_show', methods: ['GET'])]
    public function show(MaintenanceRequest $maintenanceRequest): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('maintenance_request/show.html.twig', [
            'maintenance_request' => $maintenanceRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_maintenance_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MaintenanceRequest $maintenanceRequest, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(MaintenanceRequestType::class, $maintenanceRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_maintenance_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maintenance_request/edit.html.twig', [
            'maintenance_request' => $maintenanceRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maintenance_request_delete', methods: ['POST'])]
    public function delete(Request $request, MaintenanceRequest $maintenanceRequest, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$maintenanceRequest->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($maintenanceRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_maintenance_request_index', [], Response::HTTP_SEE_OTHER);
    }
}

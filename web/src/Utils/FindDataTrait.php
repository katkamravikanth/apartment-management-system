<?php

namespace App\Utils;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

trait FindDataTrait
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function findData(string $entityClass, $id): JsonResponse
    {
        $record = $this->em->getRepository($entityClass)->getIdNameArray($id);

        if (!$record) {
            return $this->json(['error' => 'Record not found'], 404);
        }

        return $this->json($record);
    }
}
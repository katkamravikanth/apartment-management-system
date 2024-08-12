<?php

namespace App\Entity;

use App\Enum\MaintenanceRequestStatus;
use App\Repository\MaintenanceRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceRequestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class MaintenanceRequest
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', enumType: MaintenanceRequestStatus::class)]
    private MaintenanceRequestStatus $status = MaintenanceRequestStatus::OPEN;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'maintenanceRequests')]
    private ?User $requester = null;
    
    #[ORM\ManyToOne(targetEntity: Apartment::class, inversedBy: 'maintenanceRequests')]
    private ?Apartment $apartment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?MaintenanceRequestStatus
    {
        return $this->status;
    }

    public function setStatus(MaintenanceRequestStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getRequester(): ?User
    {
        return $this->requester;
    }

    public function setRequester(?User $requester): self
    {
        $this->requester = $requester;

        return $this;
    }

    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    public function setApartment(?Apartment $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }
}

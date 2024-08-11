<?php

namespace App\Entity;

use App\Repository\ApartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApartmentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Apartment
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $rentAmount = null;

    #[ORM\ManyToOne(targetEntity: Building::class, inversedBy: 'apartments')]
    private ?Building $building = null;
    
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'apartments')]
    private ?User $owner = null;
    
    #[ORM\OneToMany(targetEntity: Lease::class, mappedBy: 'apartment')]
    private Collection $leases;
    
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'apartment')]
    private Collection $payments;
    
    #[ORM\OneToMany(targetEntity: MaintenanceRequest::class, mappedBy: 'apartment')]
    private Collection $maintenanceRequests;
    
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'apartment')]
    private Collection $documents;
    
    // Constructor to initialize the collections
    public function __construct()
    {
        $this->leases = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->maintenanceRequests = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getRentAmount(): ?string
    {
        return $this->rentAmount;
    }

    public function setRentAmount(string $rentAmount): static
    {
        $this->rentAmount = $rentAmount;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }
}

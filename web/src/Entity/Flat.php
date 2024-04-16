<?php

namespace App\Entity;

use App\Repository\FlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlatRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Flat
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'flats')]
    private ?Apartment $apartment = null;

    #[ORM\Column(length: 255)]
    private ?string $flat_number = null;

    #[ORM\Column(length: 255)]
    private ?string $floor = null;

    #[ORM\OneToOne(inversedBy: 'flat', cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'flats')]
    private Collection $tenent;

    #[ORM\Column]
    private ?int $rooms = null;

    #[ORM\Column]
    private ?int $baths = null;

    #[ORM\Column(nullable: true)]
    private ?int $balcony = null;

    #[ORM\Column]
    private ?int $flat_sft = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $furnished_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $flat_facing = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $water_connections = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gas_connections = null;

    #[ORM\Column(nullable: true)]
    private ?int $rent = null;

    #[ORM\Column(nullable: true)]
    private ?int $maintenance_fee = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'flat', targetEntity: Files::class)]
    private Collection $files;

    #[ORM\OneToMany(mappedBy: 'flat', targetEntity: UserFlatHistory::class)]
    private Collection $userFlatHistories;

    public function __construct()
    {
        $this->tenent = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->userFlatHistories = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->flat_number . ' (' . $this->getApartment()->getName() . ')';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    public function setApartment(?Apartment $apartment): static
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getFlatNumber(): ?string
    {
        return $this->flat_number;
    }

    public function setFlatNumber(string $flat_number): static
    {
        $this->flat_number = $flat_number;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(string $floor): static
    {
        $this->floor = $floor;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getTenent(): Collection
    {
        return $this->tenent;
    }

    public function addTenent(User $tenent): static
    {
        if (!$this->tenent->contains($tenent)) {
            $this->tenent->add($tenent);
        }

        return $this;
    }

    public function removeTenent(User $tenent): static
    {
        $this->tenent->removeElement($tenent);

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): static
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBaths(): ?int
    {
        return $this->baths;
    }

    public function setBaths(int $baths): static
    {
        $this->baths = $baths;

        return $this;
    }

    public function getBalcony(): ?int
    {
        return $this->balcony;
    }

    public function setBalcony(?int $balcony): static
    {
        $this->balcony = $balcony;

        return $this;
    }

    public function getFlatSft(): ?int
    {
        return $this->flat_sft;
    }

    public function setFlatSft(int $flat_sft): static
    {
        $this->flat_sft = $flat_sft;

        return $this;
    }

    public function getFurnishedType(): ?string
    {
        return $this->furnished_type;
    }

    public function setFurnishedType(?string $furnished_type): static
    {
        $this->furnished_type = $furnished_type;

        return $this;
    }

    public function getFlatFacing(): ?string
    {
        return $this->flat_facing;
    }

    public function setFlatFacing(?string $flat_facing): static
    {
        $this->flat_facing = $flat_facing;

        return $this;
    }

    public function getWaterConnections(): ?string
    {
        return $this->water_connections;
    }

    public function setWaterConnections(?string $water_connections): static
    {
        $this->water_connections = $water_connections;

        return $this;
    }

    public function getGasConnections(): ?string
    {
        return $this->gas_connections;
    }

    public function setGasConnections(?string $gas_connections): static
    {
        $this->gas_connections = $gas_connections;

        return $this;
    }

    public function getRent(): ?int
    {
        return $this->rent;
    }

    public function setRent(?int $rent): static
    {
        $this->rent = $rent;

        return $this;
    }

    public function getMaintenanceFee(): ?int
    {
        return $this->maintenance_fee;
    }

    public function setMaintenanceFee(?int $maintenance_fee): static
    {
        $this->maintenance_fee = $maintenance_fee;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Files>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(Files $file): static
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setFlat($this);
        }

        return $this;
    }

    public function removeFile(Files $file): static
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getFlat() === $this) {
                $file->setFlat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserFlatHistory>
     */
    public function getUserFlatHistories(): Collection
    {
        return $this->userFlatHistories;
    }

    public function addUserFlatHistory(UserFlatHistory $userFlatHistory): static
    {
        if (!$this->userFlatHistories->contains($userFlatHistory)) {
            $this->userFlatHistories->add($userFlatHistory);
            $userFlatHistory->setFlat($this);
        }

        return $this;
    }

    public function removeUserFlatHistory(UserFlatHistory $userFlatHistory): static
    {
        if ($this->userFlatHistories->removeElement($userFlatHistory)) {
            // set the owning side to null (unless already changed)
            if ($userFlatHistory->getFlat() === $this) {
                $userFlatHistory->setFlat(null);
            }
        }

        return $this;
    }
}

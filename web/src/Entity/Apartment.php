<?php

namespace App\Entity;

use App\Repository\ApartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?string $address_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $village = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mandal = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $pincode = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_number = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $president = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $secretary = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $tresurer = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $security = null;

    #[ORM\OneToMany(mappedBy: 'apartment', targetEntity: Flat::class)]
    private Collection $flats;

    public function __construct()
    {
        $this->flats = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getAddress1(): ?string
    {
        return $this->address_1;
    }

    public function setAddress1(string $address_1): static
    {
        $this->address_1 = $address_1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address_2;
    }

    public function setAddress2(?string $address_2): static
    {
        $this->address_2 = $address_2;

        return $this;
    }

    public function getVillage(): ?string
    {
        return $this->village;
    }

    public function setVillage(?string $village): static
    {
        $this->village = $village;

        return $this;
    }

    public function getMandal(): ?string
    {
        return $this->mandal;
    }

    public function setMandal(?string $mandal): static
    {
        $this->mandal = $mandal;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPincode(): ?string
    {
        return $this->pincode;
    }

    public function setPincode(string $pincode): static
    {
        $this->pincode = $pincode;

        return $this;
    }

    public function getContactNumber(): ?string
    {
        return $this->contact_number;
    }

    public function setContactNumber(string $contact_number): static
    {
        $this->contact_number = $contact_number;

        return $this;
    }

    public function getPresident(): ?User
    {
        return $this->president;
    }

    public function setPresident(?User $president): static
    {
        $this->president = $president;

        return $this;
    }

    public function getSecretary(): ?User
    {
        return $this->secretary;
    }

    public function setSecretary(?User $secretary): static
    {
        $this->secretary = $secretary;

        return $this;
    }

    public function getTresurer(): ?User
    {
        return $this->tresurer;
    }

    public function setTresurer(?User $tresurer): static
    {
        $this->tresurer = $tresurer;

        return $this;
    }

    public function getSecurity(): ?User
    {
        return $this->security;
    }

    public function setSecurity(?User $security): static
    {
        $this->security = $security;

        return $this;
    }

    /**
     * @return Collection<int, Flat>
     */
    public function getFlats(): Collection
    {
        return $this->flats;
    }

    public function addFlat(Flat $flat): static
    {
        if (!$this->flats->contains($flat)) {
            $this->flats->add($flat);
            $flat->setApartment($this);
        }

        return $this;
    }

    public function removeFlat(Flat $flat): static
    {
        if ($this->flats->removeElement($flat)) {
            // set the owning side to null (unless already changed)
            if ($flat->getApartment() === $this) {
                $flat->setApartment(null);
            }
        }

        return $this;
    }
}

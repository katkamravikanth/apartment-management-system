<?php

namespace App\Entity;

use App\Repository\UserFlatHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserFlatHistoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UserFlatHistory
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $from_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $to_date = null;

    #[ORM\ManyToOne(inversedBy: 'userFlatHistories')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userFlatHistories')]
    private ?Flat $flat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->from_date;
    }

    public function setFromDate(\DateTimeInterface $from_date): static
    {
        $this->from_date = $from_date;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->to_date;
    }

    public function setToDate(?\DateTimeInterface $to_date): static
    {
        $this->to_date = $to_date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFlat(): ?Flat
    {
        return $this->flat;
    }

    public function setFlat(?Flat $flat): static
    {
        $this->flat = $flat;

        return $this;
    }
}

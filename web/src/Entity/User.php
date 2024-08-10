<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alternate_phone = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?UserType $user_type = null;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?Flat $flat = null;

    #[ORM\ManyToMany(targetEntity: Flat::class, mappedBy: 'tenent')]
    private Collection $flats;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserFlatHistory::class)]
    private Collection $userFlatHistories;

    #[ORM\OneToMany(mappedBy: 'payer', targetEntity: Transaction::class)]
    private Collection $payerTransactions;

    #[ORM\OneToMany(mappedBy: 'payee', targetEntity: Transaction::class)]
    private Collection $payeeTransactions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Announcement::class)]
    private Collection $announcements;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->roles = ['ROLE_USER'];
        $this->status = true;
        $this->flats = new ArrayCollection();
        $this->userFlatHistories = new ArrayCollection();
        $this->payerTransactions = new ArrayCollection();
        $this->payeeTransactions = new ArrayCollection();
        $this->announcements = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAlternatePhone(): ?string
    {
        return $this->alternate_phone;
    }

    public function setAlternatePhone(?string $alternate_phone): static
    {
        $this->alternate_phone = $alternate_phone;

        return $this;
    }

    public function getUserType(): ?UserType
    {
        return $this->user_type;
    }

    public function setUserType(?UserType $user_type): static
    {
        $this->user_type = $user_type;

        return $this;
    }

    public function getFlat(): ?Flat
    {
        return $this->flat;
    }

    public function setFlat(?Flat $flat): static
    {
        // unset the owning side of the relation if necessary
        if ($flat === null && $this->flat !== null) {
            $this->flat->setOwner(null);
        }

        // set the owning side of the relation if necessary
        if ($flat !== null && $flat->getOwner() !== $this) {
            $flat->setOwner($this);
        }

        $this->flat = $flat;

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
            $flat->addTenent($this);
        }

        return $this;
    }

    public function removeFlat(Flat $flat): static
    {
        if ($this->flats->removeElement($flat)) {
            $flat->removeTenent($this);
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
            $userFlatHistory->setUser($this);
        }

        return $this;
    }

    public function removeUserFlatHistory(UserFlatHistory $userFlatHistory): static
    {
        if ($this->userFlatHistories->removeElement($userFlatHistory)) {
            // set the owning side to null (unless already changed)
            if ($userFlatHistory->getUser() === $this) {
                $userFlatHistory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getPayerTransactions(): Collection
    {
        return $this->payerTransactions;
    }

    public function addPayerTransaction(Transaction $payerTransaction): static
    {
        if (!$this->payerTransactions->contains($payerTransaction)) {
            $this->payerTransactions->add($payerTransaction);
            $payerTransaction->setPayer($this);
        }

        return $this;
    }

    public function removePayerTransaction(Transaction $payerTransaction): static
    {
        if ($this->payerTransactions->removeElement($payerTransaction)) {
            // set the owning side to null (unless already changed)
            if ($payerTransaction->getPayer() === $this) {
                $payerTransaction->setPayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getPayeeTransactions(): Collection
    {
        return $this->payeeTransactions;
    }

    public function addPayeeTransaction(Transaction $payeeTransaction): static
    {
        if (!$this->payeeTransactions->contains($payeeTransaction)) {
            $this->payeeTransactions->add($payeeTransaction);
            $payeeTransaction->setPayee($this);
        }

        return $this;
    }

    public function removePayeeTransaction(Transaction $payeeTransaction): static
    {
        if ($this->payeeTransactions->removeElement($payeeTransaction)) {
            // set the owning side to null (unless already changed)
            if ($payeeTransaction->getPayee() === $this) {
                $payeeTransaction->setPayee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getAnnouncements(): Collection
    {
        return $this->announcements;
    }

    public function addAnnouncement(Announcement $announcement): static
    {
        if (!$this->announcements->contains($announcement)) {
            $this->announcements->add($announcement);
            $announcement->setUser($this);
        }

        return $this;
    }

    public function removeAnnouncement(Announcement $announcement): static
    {
        if ($this->announcements->removeElement($announcement)) {
            // set the owning side to null (unless already changed)
            if ($announcement->getUser() === $this) {
                $announcement->setUser(null);
            }
        }

        return $this;
    }
}

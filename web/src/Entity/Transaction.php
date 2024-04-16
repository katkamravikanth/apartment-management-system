<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Transaction
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $transaction_id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?TransactionType $transaction_type = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\ManyToOne(inversedBy: 'payerTransactions')]
    private ?User $payer = null;

    #[ORM\ManyToOne(inversedBy: 'payeeTransactions')]
    private ?User $payee = null;

    #[ORM\Column(length: 255)]
    private ?string $mode = null;

    #[ORM\Column(nullable: true, type: "text", length: 16777215)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionId(): ?string
    {
        return $this->transaction_id;
    }

    public function setTransactionId(string $transaction_id): static
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    public function getTransactionType(): ?TransactionType
    {
        return $this->transaction_type;
    }

    public function setTransactionType(?TransactionType $transaction_type): static
    {
        $this->transaction_type = $transaction_type;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPayer(): ?User
    {
        return $this->payer;
    }

    public function setPayer(?User $payer): static
    {
        $this->payer = $payer;

        return $this;
    }

    public function getPayee(): ?User
    {
        return $this->payee;
    }

    public function setPayee(?User $payee): static
    {
        $this->payee = $payee;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: BankAccountRepository::class)]
class BankAccount
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Bank::class)]
    #[ORM\JoinColumn(name: 'bank_id', referencedColumnName: 'id')]
    private ?Bank $bank = null;

    #[ORM\ManyToOne(targetEntity: BankBranch::class)]
    #[ORM\JoinColumn(name: 'branch_id', referencedColumnName: 'id')]
    private ?BankBranch $branch = null;

    #[ORM\Column]
    private ?bool $account_type = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $account_number = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $account_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBank(): ?Bank
    {
        return $this->bank;
    }

    public function setBank(?Bank $bank): static
    {
        $this->bank = $bank;

        return $this;
    }

    public function getBranch(): ?BankBranch
    {
        return $this->branch;
    }

    public function setBranch(?BankBranch $branch): static
    {
        $this->branch = $branch;

        return $this;
    }

    public function isAccountType(): ?bool
    {
        return $this->account_type;
    }

    public function setAccountType(bool $account_type): static
    {
        $this->account_type = $account_type;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->account_number;
    }

    public function setAccountNumber(?string $account_number): static
    {
        $this->account_number = $account_number;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->account_name;
    }

    public function setAccountName(?string $account_name): static
    {
        $this->account_name = $account_name;

        return $this;
    }
}

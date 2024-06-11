<?php

namespace App\Entity;

use App\Repository\BankRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: BankRepository::class)]
class Bank
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $bank_name = null;

    #[ORM\Column(length: 4)]
    private ?string $bank_code = null;

    #[ORM\OneToMany(mappedBy: 'bankId', targetEntity: BankBranch::class)]
    private $bankBranch;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankName(): ?string
    {
        return $this->bank_name;
    }

    public function setBankName(string $bank_name): static
    {
        $this->bank_name = $bank_name;

        return $this;
    }

    public function getBankCode(): ?string
    {
        return $this->bank_code;
    }

    public function setBankCode(string $bank_code): static
    {
        $this->bank_code = $bank_code;

        return $this;
    }

    public function getBankBranch()
    {
        return $this->bankBranch;
    }
}

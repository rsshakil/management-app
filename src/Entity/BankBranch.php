<?php

namespace App\Entity;

use App\Repository\BankBranchRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: BankBranchRepository::class)]
class BankBranch
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $branch_name = null;

    #[ORM\Column(length: 4)]
    private ?string $branch_code = null;

    #[ORM\ManyToOne(targetEntity: Bank::class)]
    #[ORM\JoinColumn(name: 'bank_id', referencedColumnName: 'id')]
    private $bank;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBranchName(): ?string
    {
        return $this->branch_name;
    }

    public function setBranchName(string $branch_name): static
    {
        $this->branch_name = $branch_name;

        return $this;
    }

    public function getBranchCode(): ?string
    {
        return $this->branch_code;
    }

    public function setBranchCode(string $branch_code): static
    {
        $this->branch_code = $branch_code;

        return $this;
    }

    public function getBank()
    {
        return $this->bank;
    }

    public function setBank($bank)
    {
        $this->bank = $bank;
        return $this;
    }
}

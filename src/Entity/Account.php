<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    use TimestampableEntity;
    use SoftDeleteableEntity;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Deposit::class)]
    private $deposits;

    // Virtual property for total deposits
    private $totalDeposits;

    public function __construct()
    {
        $this->deposits = new ArrayCollection();
    }

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nidno = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ranking = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photos = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shareno = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getNidno(): ?string
    {
        return $this->nidno;
    }

    public function setNidno(?string $nidno): static
    {
        $this->nidno = $nidno;

        return $this;
    }

    public function getRanking(): ?string
    {
        return $this->ranking;
    }

    public function setRanking(?string $ranking): static
    {
        $this->ranking = $ranking;

        return $this;
    }

    public function getPhotos(): ?string
    {
        return $this->photos;
    }

    public function setPhotos(?string $photos): static
    {
        $this->photos = $photos;

        return $this;
    }

    public function getShareno(): ?string
    {
        return $this->shareno;
    }

    public function setShareno(?string $shareno): static
    {
        $this->shareno = $shareno;

        return $this;
    }

    // other properties and methods...

    public function getDeposits(): Collection
    {
        return $this->deposits;
    }

    public function setTotalDeposits(int $totalDeposits): self
    {
        $this->totalDeposits = $totalDeposits;
        return $this;
    }

    public function getTotalDeposits(): ?int
    {
        return $this->totalDeposits;
    }

       /**
     * Calculate the total deposit amount associated with this account.
     */
    public function getTotalDepositAmount(): float
    {
        $total = 0;
        foreach ($this->deposits as $deposit) {
            // Assuming 'account_id' is the foreign key in the Deposit entity
            // dd($deposit->getAccount()->id);
            if ($deposit->getAccount()->id === $this->id) {
                $total += $deposit->getAmount();
            }
        }
        return $total;
    }

    // Implement __toString() method
    public function __toString(): string
    {
        // Return a meaningful string representation, such as the account name
        return $this->getFirstname();
    }
}

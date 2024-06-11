<?php

namespace App\Entity;

use App\Repository\BankTransferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BankTransferRepository::class)]
class BankTransfer
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "bigint")]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $transfer_request_id = null;

    #[ORM\Column]
    private ?int $bank_id = null;

    #[ORM\Column]
    private ?int $bank_branch_id = null;

    #[ORM\Column]
    private ?int $account_type  = null;

    #[ORM\Column(length: 7)]
    private ?string $account_number = null;

    #[ORM\Column(length: 50)]
    private ?string $transfer_name = null;

    #[ORM\Column]
    private ?int $transfer_amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $transfer_date = null;

    #[ORM\Column]
    private ?bool $transfer_status = null;

    #[ORM\Column]
    private ?bool $notify_status = null;

    #[ORM\Column]
    private ?bool $notify_count = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $transferred_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $notified_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransferRequestId(): ?int
    {
        return $this->transfer_request_id;
    }

    public function setTransferRequestId(int $transfer_request_id): static
    {
        $this->transfer_request_id = $transfer_request_id;

        return $this;
    }

    public function getBankId(): ?int
    {
        return $this->bank_id;
    }

    public function setBankId(int $bank_id): static
    {
        $this->bank_id = $bank_id;

        return $this;
    }

    public function getBankBranchId(): ?int
    {
        return $this->bank_branch_id;
    }

    public function setBankBranchId(int $bank_branch_id): static
    {
        $this->bank_branch_id = $bank_branch_id;

        return $this;
    }

    public function getAccountType(): ?int
    {
        return $this->account_type;
    }

    public function setAccountType(int $account_type): static
    {
        $this->account_type = $account_type;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->account_number;
    }

    public function setAccountNumber(string $account_number): static
    {
        $this->account_number = $account_number;

        return $this;
    }

    public function getTransferName(): ?string
    {
        return $this->transfer_name;
    }

    public function setTransferName(string $transfer_name): static
    {
        $this->transfer_name = $transfer_name;

        return $this;
    }

    public function getTransferAmount(): ?int
    {
        return $this->transfer_amount;
    }

    public function setTransferAmount(int $transfer_amount): static
    {
        $this->transfer_amount = $transfer_amount;

        return $this;
    }

    public function getTransferDate(): ?\DateTimeInterface
    {
        return $this->transfer_date;
    }

    public function setTransferDate(\DateTimeInterface $transfer_date): static
    {
        $this->transfer_date = $transfer_date;

        return $this;
    }

    public function isTransferStatus(): ?bool
    {
        return $this->transfer_status;
    }

    public function setTransferStatus(bool $transfer_status): static
    {
        $this->transfer_status = $transfer_status;

        return $this;
    }

    public function isNotifyStatus(): ?bool
    {
        return $this->notify_status;
    }

    public function setNotifyStatus(bool $notify_status): static
    {
        $this->notify_status = $notify_status;

        return $this;
    }

    public function isNotifyCount(): ?bool
    {
        return $this->notify_count;
    }

    public function setNotifyCount(bool $notify_count): static
    {
        $this->notify_count = $notify_count;

        return $this;
    }

    public function getTransferredAt(): ?\DateTimeInterface
    {
        return $this->transferred_at;
    }

    public function setTransferredAt(?\DateTimeInterface $transferred_at): static
    {
        $this->transferred_at = $transferred_at;

        return $this;
    }

    public function getNotifiedAt(): ?\DateTimeInterface
    {
        return $this->notified_at;
    }

    public function setNotifiedAt(?\DateTimeInterface $notified_at): static
    {
        $this->notified_at = $notified_at;

        return $this;
    }
}

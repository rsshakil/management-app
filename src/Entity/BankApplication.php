<?php

namespace App\Entity;

use App\Repository\BankApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BankApplicationRepository::class)]
class BankApplication
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "bigint")]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $request_log_id = null;

    #[ORM\Column]
    private ?int $app_id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $app_user_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $app_user_email = null;

    #[ORM\Column(length: 50)]
    private ?int $app_request_id = null;

    #[ORM\Column]
    private ?int $bank_account_id = null;

    #[ORM\Column]
    private ?int $estimate_amount = null;

    #[ORM\Column(length: 20)]
    private ?string $estimate_name = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $balance = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $free = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestLogId(): ?string
    {
        return $this->request_log_id;
    }

    public function setRequestLogId(string $request_log_id): static
    {
        $this->request_log_id = $request_log_id;

        return $this;
    }

    public function getAppId(): ?int
    {
        return $this->app_id;
    }

    public function setAppId(int $app_id): static
    {
        $this->app_id = $app_id;

        return $this;
    }

    public function getAppUserId(): ?string
    {
        return $this->app_user_id;
    }

    public function setAppUserId(?string $app_user_id): static
    {
        $this->app_user_id = $app_user_id;

        return $this;
    }

    public function getAppUserEmail(): ?string
    {
        return $this->app_user_email;
    }

    public function setAppUserEmail(?string $app_user_email): static
    {
        $this->app_user_email = $app_user_email;

        return $this;
    }

    public function getAppRequestId(): ?string
    {
        return $this->app_request_id;
    }

    public function setAppRequestId(?string $app_request_id): static
    {
        $this->app_request_id = $app_request_id;

        return $this;
    }

    public function getBankAccountId(): ?int
    {
        return $this->bank_account_id;
    }

    public function setBankAccountId(int $bank_account_id): static
    {
        $this->bank_account_id = $bank_account_id;

        return $this;
    }

    public function getEstimateAmount(): ?int
    {
        return $this->estimate_amount;
    }

    public function setEstimateAmount(int $estimate_amount): static
    {
        $this->estimate_amount = $estimate_amount;

        return $this;
    }

    public function getEstimateName(): ?string
    {
        return $this->estimate_name;
    }

    public function setEstimateName(string $estimate_name): static
    {
        $this->estimate_name = $estimate_name;

        return $this;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(?int $balance): static
    {
        $this->balance = $balance;

        return $this;
    }

    public function getFree(): ?string
    {
        return $this->free;
    }

    public function setFree(?string $free): static
    {
        $this->free = $free;

        return $this;
    }
}

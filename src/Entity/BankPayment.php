<?php

namespace App\Entity;

use App\Repository\BankPaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BankPaymentRepository::class)]
#[UniqueEntity('bank_statement_id')]
class BankPayment
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "bigint")]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $app_id = null;

    #[ORM\ManyToOne(targetEntity: App::class)]
    #[ORM\JoinColumn(name: "app_id", referencedColumnName: "id")]
    private ?App $app = null;

    #[ORM\Column(type: "bigint")]
    private ?int $bank_application_id = null;

    #[ORM\ManyToOne(targetEntity: BankApplication::class)]
    #[ORM\JoinColumn(name: "bank_application_id", referencedColumnName: "id")]
    private ?BankApplication $bankApplication = null;

    #[ORM\Column(type: Types::BIGINT, unique: true)]
    private ?string $bank_statement_id = null;

    #[ORM\Column]
    private ?int $bank_account_id = null;

    #[ORM\ManyToOne(targetEntity: BankAccount::class)]
    #[ORM\JoinColumn(name: "bank_account_id", referencedColumnName: "id")]
    private ?BankAccount $bankAccount = null;
    
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $app_user_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $app_user_email = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $app_request_id = null;

    #[ORM\Column(length: 50)]
    private ?string $transfer_name = null;

    #[ORM\Column]
    private ?int $transfer_amount = null;

    #[ORM\Column]
    private ?int $amount_status = null;

    #[ORM\Column]
    private ?bool $notify_status = null;

    #[ORM\Column]
    private ?bool $is_paid = null;

    #[ORM\Column]
    private ?bool $notify_count = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppId(): ?int
    {
        return $this->app_id;
    }

    public function setAppId(?int $app_id): self
    {
        $this->app_id = $app_id;

        return $this;
    }

    public function getApp(): ?App
    {
        return $this->app;
    }

    public function setApp(?App $app): self
    {
        $this->app = $app;

        return $this;
    }

    public function getBankApplicationId(): ?int
    {
        return $this->bank_application_id;
    }

    public function setBankApplicationId(?int $bank_application_id): self
    {
        $this->bank_application_id = $bank_application_id;

        return $this;
    }

    public function getBankApplication(): ?BankApplication
    {
        return $this->bankApplication;
    }

    public function setBankApplication(?BankApplication $bankApplication): self
    {
        $this->bankApplication = $bankApplication;

        return $this;
    }

    public function getBankAccountId(): ?int
    {
        return $this->bank_account_id;
    }

    public function setBankAccountId(?int $bank_account_id): self
    {
        $this->bank_account_id = $bank_account_id;

        return $this;
    }

    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(?BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    public function getBankStatementId(): ?int
    {
        return $this->bank_statement_id;
    }

    public function setBankStatementId(int $bank_statement_id): static
    {
        $this->bank_statement_id = $bank_statement_id;

        return $this;
    }

    public function getAppUserId(): ?string
    {
        return $this->app_user_id;
    }

    public function setAppUserId(string $app_user_id): static
    {
        $this->app_user_id = $app_user_id;

        return $this;
    }

    public function getAppUserEmail(): ?string
    {
        return $this->app_user_email;
    }

    public function setAppUserEmail(string $app_user_email): static
    {
        $this->app_user_email = $app_user_email;

        return $this;
    }

    public function getAppRequestId(): ?string
    {
        return $this->app_request_id;
    }

    public function setAppRequestId(string $app_request_id): static
    {
        $this->app_request_id = $app_request_id;

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

    public function getAmountStatus(): ?int
    {
        return $this->amount_status;
    }

    public function setAmountStatus(int $amount_status): static
    {
        $this->amount_status = $amount_status;

        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->is_paid;
    }

    public function setIsPaid(bool $is_paid): static
    {
        $this->is_paid = $is_paid;

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
}

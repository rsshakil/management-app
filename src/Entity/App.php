<?php

namespace App\Entity;

use App\Repository\AppRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: AppRepository::class)]
class App
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $client_id = null;

    #[ORM\Column(length: 10)]
    private ?string $app_id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::BINARY)]
    private $password;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $secret_key = null;

    #[ORM\Column]
    private ?int $bank_account_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $payment_notice_url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $transfer_notice_url = null;

    #[ORM\Column(nullable: true)]
    private ?bool $notice_email_status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notice_emails = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?int
    {
        return $this->client_id;
    }

    public function setClientId(int $client_id): static
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getAppId(): ?string
    {
        return $this->app_id;
    }

    public function setAppId(string $app_id): static
    {
        $this->app_id = $app_id;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSecretKey(): ?string
    {
        return $this->secret_key;
    }

    public function setSecretKey(?string $secret_key): static
    {
        $this->secret_key = $secret_key;

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

    public function getPaymentNoticeUrl(): ?string
    {
        return $this->payment_notice_url;
    }

    public function setPaymentNoticeUrl(?string $payment_notice_url): static
    {
        $this->payment_notice_url = $payment_notice_url;

        return $this;
    }

    public function getTransferNoticeUrl(): ?string
    {
        return $this->transfer_notice_url;
    }

    public function setTransferNoticeUrl(?string $transfer_notice_url): static
    {
        $this->transfer_notice_url = $transfer_notice_url;

        return $this;
    }

    public function isNoticeEmailStatus(): ?bool
    {
        return $this->notice_email_status;
    }

    public function setNoticeEmailStatus(?bool $notice_email_status): static
    {
        $this->notice_email_status = $notice_email_status;

        return $this;
    }

    public function getNoticeEmails(): ?string
    {
        return $this->notice_emails;
    }

    public function setNoticeEmails(?string $notice_emails): static
    {
        $this->notice_emails = $notice_emails;

        return $this;
    }
}

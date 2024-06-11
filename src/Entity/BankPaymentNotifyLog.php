<?php

namespace App\Entity;

use App\Repository\BankPaymentNotifyLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: BankPaymentNotifyLogRepository::class)]
class BankPaymentNotifyLog
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?int $bank_payment_id = null;

    #[ORM\ManyToOne(targetEntity: BankPayment::class)]
    #[ORM\JoinColumn(name: "bank_payment_id", referencedColumnName: "id")]
    private ?BankPayment $bankPayment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $notify_status = null;

    #[ORM\Column(length: 255)]
    private ?string $notify_url = null;

    #[ORM\Column]
    private array $notify_data = [];

    #[ORM\Column(nullable: true)]
    private ?bool $notify_count = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $notified_at = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $response_code = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $response_body = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $response_verbose = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankPaymentId(): ?string
    {
        return $this->bank_payment_id;
    }

    public function setBankPaymentId(string $bank_payment_id): static
    {
        $this->bank_payment_id = $bank_payment_id;

        return $this;
    }

    public function getBankPayment(): ?BankPayment
    {
        return $this->bankPayment;
    }

    public function setBankPayment(?BankPayment $bankPayment): static
    {
        $this->bankPayment = $bankPayment;

        return $this;
    }

    public function isNotifyStatus(): ?bool
    {
        return $this->notify_status;
    }

    public function setNotifyStatus(?bool $notify_status): static
    {
        $this->notify_status = $notify_status;

        return $this;
    }

    public function getNotifyUrl(): ?string
    {
        return $this->notify_url;
    }

    public function setNotifyUrl(string $notify_url): static
    {
        $this->notify_url = $notify_url;

        return $this;
    }

    public function getNotifyData(): array
    {
        return $this->notify_data;
    }

    public function setNotifyData(array $notify_data): static
    {
        $this->notify_data = $notify_data;

        return $this;
    }

    public function isNotifyCount(): ?bool
    {
        return $this->notify_count;
    }

    public function setNotifyCount(?bool $notify_count): static
    {
        $this->notify_count = $notify_count;

        return $this;
    }

    public function getNotifiedAt(): ?\DateTimeInterface
    {
        return $this->notified_at;
    }

    public function setNotifiedAt(\DateTimeInterface $notified_at): static
    {
        $this->notified_at = $notified_at;

        return $this;
    }

    public function getResponseCode(): ?int
    {
        return $this->response_code;
    }

    public function setResponseCode(int $response_code): static
    {
        $this->response_code = $response_code;

        return $this;
    }

    public function getResponseBody(): ?string
    {
        return $this->response_body;
    }

    public function setResponseBody(string $response_body): static
    {
        $this->response_body = $response_body;

        return $this;
    }

    public function getResponseVerbose(): ?string
    {
        return $this->response_verbose;
    }

    public function setResponseVerbose(string $response_verbose): static
    {
        $this->response_verbose = $response_verbose;

        return $this;
    }
}

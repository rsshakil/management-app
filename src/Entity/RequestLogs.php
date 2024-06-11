<?php

namespace App\Entity;

use App\Repository\RequestLogsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequestLogsRepository::class)]
class RequestLogs
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "bigint")]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $request_time = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $request_data = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestTime(): ?\DateTimeInterface
    {
        return $this->request_time;
    }

    public function setRequestTime(\DateTimeInterface $request_time): static
    {
        $this->request_time = $request_time;

        return $this;
    }

    public function getRequestData(): ?string
    {
        return $this->request_data;
    }

    public function setRequestData(?string $request_data): static
    {
        $this->request_data = $request_data;

        return $this;
    }
}

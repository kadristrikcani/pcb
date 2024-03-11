<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: RequestRepository::class)]
class Request
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(nullable: true)]
    private ?int $ownerStatus = null;

    #[ORM\Column(nullable: true)]
    private ?int $sellingReason = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $utmData = null;

    #[ORM\Column(nullable: true, options: ['default' => 1])]
    private ?int $partialConversion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $podioId = null;

    #[ORM\Column(nullable: true)]
    private ?int $listed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getOwnerStatus(): ?int
    {
        return $this->ownerStatus;
    }

    public function setOwnerStatus(?int $ownerStatus): self
    {
        $this->ownerStatus = $ownerStatus;

        return $this;
    }

    public function getSellingReason(): ?int
    {
        return $this->sellingReason;
    }

    public function setSellingReason(?int $sellingReason): self
    {
        $this->sellingReason = $sellingReason;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUtmData(): ?string
    {
        return $this->utmData;
    }

    public function setUtmData(?string $utmData): self
    {
        $this->utmData = $utmData;

        return $this;
    }

    public function getPartialConversion(): ?int
    {
        return $this->partialConversion;
    }

    public function setPartialConversion(?int $partialConversion): static
    {
        $this->partialConversion = $partialConversion;

        return $this;
    }

    public function getPodioId(): ?string
    {
        return $this->podioId;
    }

    public function setPodioId(?string $podioId): static
    {
        $this->podioId = $podioId;

        return $this;
    }

    public function getListed(): ?int
    {
        return $this->listed;
    }

    public function setListed(?int $listed): static
    {
        $this->listed = $listed;

        return $this;
    }

}
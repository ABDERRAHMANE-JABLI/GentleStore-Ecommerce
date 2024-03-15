<?php

namespace App\Entity;

use App\Repository\PayementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayementRepository::class)]
class Payement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $test_public_api_key = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $test_private_api_key = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prod_public_api_key = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prod_private_api_key = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getTestPublicApiKey(): ?string
    {
        return $this->test_public_api_key;
    }

    public function setTestPublicApiKey(?string $test_public_api_key): static
    {
        $this->test_public_api_key = $test_public_api_key;

        return $this;
    }

    public function getTestPrivateApiKey(): ?string
    {
        return $this->test_private_api_key;
    }

    public function setTestPrivateApiKey(?string $test_private_api_key): static
    {
        $this->test_private_api_key = $test_private_api_key;

        return $this;
    }

    public function getProdPublicApiKey(): ?string
    {
        return $this->prod_public_api_key;
    }

    public function setProdPublicApiKey(?string $prod_public_api_key): static
    {
        $this->prod_public_api_key = $prod_public_api_key;

        return $this;
    }

    public function getProdPrivateApiKey(): ?string
    {
        return $this->prod_private_api_key;
    }

    public function setProdPrivateApiKey(?string $prod_private_api_key): static
    {
        $this->prod_private_api_key = $prod_private_api_key;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $storeName = null;

    #[ORM\Column(length: 255)]
    private ?string $Descrription = null;

    #[ORM\Column(length: 20)]
    private ?string $currency = null;

    #[ORM\Column(nullable: true)]
    private ?int $taxRate = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 20)]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $facebookLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagramLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $YoutubeLink = null;

    public function __construct()
    {
        $this->setCreateAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStoreName(): ?string
    {
        return $this->storeName;
    }

    public function setStoreName(string $storeName): static
    {
        $this->storeName = $storeName;

        return $this;
    }

    public function getDescrription(): ?string
    {
        return $this->Descrription;
    }

    public function setDescrription(string $Descrription): static
    {
        $this->Descrription = $Descrription;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTaxRate(): ?int
    {
        return $this->taxRate;
    }

    public function setTaxRate(?int $taxRate): static
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebookLink;
    }

    public function setFacebookLink(?string $facebookLink): static
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    public function getInstagramLink(): ?string
    {
        return $this->instagramLink;
    }

    public function setInstagramLink(?string $instagramLink): static
    {
        $this->instagramLink = $instagramLink;

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->YoutubeLink;
    }

    public function setYoutubeLink(?string $YoutubeLink): static
    {
        $this->YoutubeLink = $YoutubeLink;

        return $this;
    }
}

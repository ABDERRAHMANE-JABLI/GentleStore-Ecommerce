<?php

namespace App\Entity;

use App\Repository\SlidersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SlidersRepository::class)]
class Sliders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $btnLink = null;

    #[ORM\Column(length: 255)]
    private ?string $btnText = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function getBtnLink(): ?string
    {
        return $this->btnLink;
    }

    public function setBtnLink(string $btnLink): static
    {
        $this->btnLink = $btnLink;

        return $this;
    }

    public function getBtnText(): ?string
    {
        return $this->btnText;
    }

    public function setBtnText(string $btnText): static
    {
        $this->btnText = $btnText;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}

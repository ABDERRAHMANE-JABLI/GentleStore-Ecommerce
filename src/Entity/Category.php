<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;



#[ORM\Entity(repositoryClass: CategoryRepository::class)]

class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isMega = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'categories')]
    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     * @Groups({"category"})
     */
    private Collection $products;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->products = new ArrayCollection();
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
        $this->setSlug((new Slugify())->slugify($name));
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function isIsMega(): ?bool
    {
        return $this->isMega;
    }

    public function setIsMega(?bool $isMega): static
    {
        $this->isMega = $isMega;

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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}

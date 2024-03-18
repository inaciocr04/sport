<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(targetEntity: Basket::class, mappedBy: 'category')]
    private Collection $basket;

    public function __construct()
    {
        $this->basket = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Basket>
     */
    public function getBasket(): Collection
    {
        return $this->basket;
    }

    public function addBasket(Basket $basket): static
    {
        if (!$this->basket->contains($basket)) {
            $this->basket->add($basket);
            $basket->setCategory($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): static
    {
        if ($this->basket->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getCategory() === $this) {
                $basket->setCategory(null);
            }
        }

        return $this;
    }
}

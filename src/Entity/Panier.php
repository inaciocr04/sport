<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Basket;



#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_panier = null;

    #[ORM\ManyToOne(inversedBy: 'panier')]
    private ?Basket $basket = null;

    #[ORM\ManyToOne(inversedBy: 'panier')]
    private ?User $user = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPanier(): ?string
    {
        return $this->nom_panier;
    }

    public function setNomPanier(?string $nom_panier): static
    {
        $this->nom_panier = $nom_panier;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(?Basket $basket): static
    {
        $this->basket = $basket;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
}

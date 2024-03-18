<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'basket')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Couleur::class, inversedBy: 'basket')]
    private Collection $couleurs;

    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'basket')]
    private Collection $tailles;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $sous_titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo4 = null;

    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'basket')]
    private Collection $paniers;

    


    public function __construct()
    {
        $this->couleurs = new ArrayCollection();
        $this->tailles = new ArrayCollection();
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Couleur>
     */
    public function getCouleurs(): Collection
    {
        return $this->couleurs;
    }

    public function addCouleur(Couleur $couleur): static
    {
        if (!$this->couleurs->contains($couleur)) {
            $this->couleurs->add($couleur);
            $couleur->addBasket($this);
        }

        return $this;
    }

    public function removeCouleur(Couleur $couleur): static
    {
        if ($this->couleurs->removeElement($couleur)) {
            $couleur->removeBasket($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): static
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles->add($taille);
            $taille->addBasket($this);
        }

        return $this;
    }

    public function removeTaille(Taille $taille): static
    {
        if ($this->tailles->removeElement($taille)) {
            $taille->removeBasket($this);
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSousTitre(): ?string
    {
        return $this->sous_titre;
    }

    public function setSousTitre(string $sous_titre): static
    {
        $this->sous_titre = $sous_titre;

        return $this;
    }

    public function getPhoto2(): ?string
    {
        return $this->photo2;
    }

    public function setPhoto2(?string $photo2): static
    {
        $this->photo2 = $photo2;

        return $this;
    }

    public function getPhoto3(): ?string
    {
        return $this->photo3;
    }

    public function setPhoto3(?string $photo3): static
    {
        $this->photo3 = $photo3;

        return $this;
    }

    public function getPhoto4(): ?string
    {
        return $this->photo4;
    }

    public function setPhoto4(?string $photo4): static
    {
        $this->photo4 = $photo4;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setBasket($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getBasket() === $this) {
                $panier->setBasket(null);
            }
        }

        return $this;
    }



}

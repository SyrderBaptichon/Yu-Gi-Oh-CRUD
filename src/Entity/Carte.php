<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteRepository::class)]
class Carte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $carte_nom = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $carte_attribut = null;

    #[ORM\Column(length: 10)]
    private ?string $carte_categorie = null;

    #[ORM\Column(nullable: true)]
    private ?int $carte_niveau = null;

    #[ORM\Column(length: 255)]
    private ?string $carte_image = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $carte_type = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $carte_specificite = null;

    #[ORM\Column(nullable: true)]
    private ?int $carteATK = null;

    #[ORM\Column(nullable: true)]
    private ?int $carteDEF = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $carte_description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarteNom(): ?string
    {
        return $this->carte_nom;
    }

    public function setCarteNom(string $carte_nom): static
    {
        $this->carte_nom = $carte_nom;

        return $this;
    }

    public function getCarteAttribut(): ?string
    {
        return $this->carte_attribut;
    }

    public function setCarteAttribut(?string $carte_attribut): static
    {
        $this->carte_attribut = $carte_attribut;

        return $this;
    }

    public function getCarteCategorie(): ?string
    {
        return $this->carte_categorie;
    }

    public function setCarteCategorie(string $carte_categorie): static
    {
        $this->carte_categorie = $carte_categorie;

        return $this;
    }

    public function getCarteNiveau(): ?int
    {
        return $this->carte_niveau;
    }

    public function setCarteNiveau(?int $carte_niveau): static
    {
        $this->carte_niveau = $carte_niveau;

        return $this;
    }

    public function getCarteImage(): ?string
    {
        return $this->carte_image;
    }

    public function setCarteImage(string $carte_image): static
    {
        $this->carte_image = $carte_image;

        return $this;
    }

    public function getCarteType(): ?string
    {
        return $this->carte_type;
    }

    public function setCarteType(?string $carte_type): static
    {
        $this->carte_type = $carte_type;

        return $this;
    }

    public function getCarteSpecificite(): ?string
    {
        return $this->carte_specificite;
    }

    public function setCarteSpecificite(?string $carte_specificite): static
    {
        $this->carte_specificite = $carte_specificite;

        return $this;
    }

    public function getCarteATK(): ?int
    {
        return $this->carteATK;
    }

    public function setCarteATK(?int $carteATK): static
    {
        $this->carteATK = $carteATK;

        return $this;
    }

    public function getCarteDEF(): ?int
    {
        return $this->carteDEF;
    }

    public function setCarteDEF(?int $carteDEF): static
    {
        $this->carteDEF = $carteDEF;

        return $this;
    }

    public function getCarteDescription(): ?string
    {
        return $this->carte_description;
    }

    public function setCarteDescription(?string $carte_description): static
    {
        $this->carte_description = $carte_description;

        return $this;
    }
}

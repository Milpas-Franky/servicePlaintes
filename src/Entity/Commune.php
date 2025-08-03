<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
#[ORM\Table(name: "communes")]

class Commune
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $rue_et_numero = null;

    #[ORM\Column(length: 60)]
    private ?string $quartier = null;

    #[ORM\Column(length: 60)]
    private ?string $ville = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRueEtNumero(): ?string
    {
        return $this->rue_et_numero;
    }

    public function setRueEtNumero(string $rue_et_numero): static
    {
        $this->rue_et_numero = $rue_et_numero;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }
}
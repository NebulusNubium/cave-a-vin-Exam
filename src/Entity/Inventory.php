<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\ManyToOne(inversedBy: 'cave')]
    private ?Cave $caves = null;

    #[ORM\ManyToOne(inversedBy: 'inventories')]
    private ?Bouteilles $bouteille = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCaves(): ?Cave
    {
        return $this->caves;
    }

    public function setCaves(?Cave $caves): static
    {
        $this->caves = $caves;

        return $this;
    }

    public function getBouteille(): ?Bouteilles
    {
        return $this->bouteille;
    }

    public function setBouteille(?Bouteilles $bouteille): static
    {
        $this->bouteille = $bouteille;

        return $this;
    }
}

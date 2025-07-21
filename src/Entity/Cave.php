<?php
// src/Entity/Cave.php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Bouteilles;
use App\Entity\Inventory;
use App\Repository\CaveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaveRepository::class)]
class Cave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Many Caves belong to One User.
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'caves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * Many Caves ↔ Many Bouteilles (wines) with extra stock managed in Inventory join-entity.
     */
    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'cave', cascade: ['persist','remove'], orphanRemoval: true)]
    private Collection $inventoryItems;

    #[ORM\ManyToMany(targetEntity: Bouteilles::class, inversedBy: 'caves')]
    #[ORM\JoinTable(name: 'cellar_items')]
    private Collection $bouteilles;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->inventoryItems = new ArrayCollection();
        $this->bouteilles     = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventoryItems(): Collection
    {
        return $this->inventoryItems;
    }

    public function addInventoryItem(Inventory $item): self
    {
        if (!$this->inventoryItems->contains($item)) {
            $this->inventoryItems->add($item);
            $item->setCaves($this);
        }
        return $this;
    }

    public function removeInventoryItem(Inventory $item): self
    {
        if ($this->inventoryItems->removeElement($item)) {
            if ($item->getCaves() === $this) {
                $item->setCaves(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Bouteilles>
     */
    public function getBouteilles(): Collection
    {
        return $this->bouteilles;
    }

    public function addBouteille(Bouteilles $bouteille): self
    {
        if (!$this->bouteilles->contains($bouteille)) {
            $this->bouteilles->add($bouteille);
            $bouteille->addCave($this);
        }
        return $this;
    }

    public function removeBouteille(Bouteilles $bouteille): self
    {
        if ($this->bouteilles->removeElement($bouteille)) {
            $bouteille->removeCave($this);
        }
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
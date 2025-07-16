<?php

namespace App\Entity;

use App\Repository\CaveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaveRepository::class)]
class Cave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Bouteilles>
     */
    #[ORM\ManyToMany(targetEntity: Bouteilles::class, inversedBy: 'caves')]
    private Collection $bouteilles;

    /**
     * @var Collection<int, Inventory>
     */
    #[ORM\OneToMany(targetEntity: Inventory::class, mappedBy: 'caves')]
    private Collection $caves;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'cave', cascade: ['persist', 'remove'])]
    private ?self $user = null;

    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?self $cave = null;
    
    public function __construct()
    {
        $this->caves = new ArrayCollection();
        $this->caves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Bouteilles>
     */
    public function getBouteilles(): Collection
    {
        return $this->bouteilles;
    }

    public function addBouteille(Bouteilles $bouteille): static
    {
        if (!$this->bouteilles->contains($bouteille)) {
            $this->bouteilles->add($bouteille);
        }

        return $this;
    }

    public function removeBouteille(Bouteilles $bouteille): static
    {
        $this->bouteilles->removeElement($bouteille);

        return $this;
    }

    /**
     * @return Collection<int, Inventory>
     */
    public function getCaves(): Collection
    {
        return $this->caves;
    }

    public function getUser(): ?self
    {
        return $this->user;
    }

    public function setUser(?self $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCave(): ?self
    {
        return $this->cave;
    }

    public function setCave(?self $cave): static
    {
        // unset the owning side of the relation if necessary
        if ($cave === null && $this->cave !== null) {
            $this->cave->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($cave !== null && $cave->getUser() !== $this) {
            $cave->setUser($this);
        }

        $this->cave = $cave;

        return $this;
    }
}

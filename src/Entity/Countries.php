<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountriesRepository::class)]
class Countries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Bouteilles>
     */
    #[ORM\OneToMany(targetEntity: Bouteilles::class, mappedBy: 'country')]
    private Collection $bouteilles;

    public function __construct()
    {
        $this->bouteilles = new ArrayCollection();
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

        return $this;
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
            $bouteille->setCountry($this);
        }

        return $this;
    }

    public function removeBouteille(Bouteilles $bouteille): static
    {
        if ($this->bouteilles->removeElement($bouteille)) {
            // set the owning side to null (unless already changed)
            if ($bouteille->getCountry() === $this) {
                $bouteille->setCountry(null);
            }
        }

        return $this;
    }

}

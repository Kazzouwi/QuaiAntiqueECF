<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isAllergen = null;

    #[ORM\ManyToMany(targetEntity: Meal::class, mappedBy: 'ingredients')]
    private Collection $mealList;

    public function __construct()
    {
        $this->mealList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isIsAllergen(): ?bool
    {
        return $this->isAllergen;
    }

    public function setIsAllergen(bool $isAllergen): self
    {
        $this->isAllergen = $isAllergen;

        return $this;
    }

    /**
    * @return Collection<int, Meal>
    */
    public function getMealList(): Collection
    {
        return $this->mealList;
    }

    public function addMealList(Meal $mealList): self
    {
        if (!$this->mealList->contains($mealList)) {
            $this->mealList->add($mealList);
            $mealList->addIngredient($this);
        }

        return $this;
    }

    public function removeIngredient(Meal $mealList): self
    {
        if ($this->mealList->removeElement($mealList)) {
            $mealList->removeIngredient($this);
        }

        return $this;
    }
}

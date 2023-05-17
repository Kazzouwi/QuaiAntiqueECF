<?php

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TableRepository::class)]
#[ORM\Table(name: '`table`')]
class Table
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Range([
        'min' => 2,
        'max' => 10,
        'minMessage' => 'Une table ne peut pas contenur moins de 2 places',
        'maxMessage' => 'Une table ne peut pas contenir plus de 10 places',
    ])]
    private ?int $places = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\OneToMany(mappedBy: 'reservationTable', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $tableReservation;

    public function __construct()
    {
        $this->tableReservation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getTableReservation(): Collection
    {
        return $this->tableReservation;
    }

    public function addTableReservation(Reservation $tableReservation): self
    {
        if (!$this->tableReservation->contains($tableReservation)) {
            $this->tableReservation->add($tableReservation);
            $tableReservation->setReservationTable($this);
        }

        return $this;
    }

    public function removeTableReservation(Reservation $tableReservation): self
    {
        if ($this->tableReservation->removeElement($tableReservation)) {
            // set the owning side to null (unless already changed)
            if ($tableReservation->getReservationTable() === $this) {
                $tableReservation->setReservationTable(null);
            }
        }

        return $this;
    }
}
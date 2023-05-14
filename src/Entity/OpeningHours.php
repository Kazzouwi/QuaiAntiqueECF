<?php

namespace App\Entity;

use App\Repository\OpeningHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpeningHoursRepository::class)]
class OpeningHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $openingHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closingHour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningHour(): ?\DateTimeInterface
    {
        return $this->openingHour;
    }

    public function setOpeningHour(?\DateTimeInterface $openingHour): self
    {
        $this->openingHour = $openingHour;

        return $this;
    }

    public function getClosingHour(): ?\DateTimeInterface
    {
        return $this->closingHour;
    }

    public function setClosingHour(?\DateTimeInterface $closingHour): self
    {
        $this->closingHour = $closingHour;

        return $this;
    }
}

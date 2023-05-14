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
    private ?\DateTimeInterface $morningOpeningHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $morningClosingHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $eveningOpeningHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $eveningClosingHour = null;

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

    public function getMorningOpeningHour(): ?\DateTimeInterface
    {
        return $this->morningOpeningHour;
    }

    public function setMorningOpeningHour(?\DateTimeInterface $morningOpeningHour): self
    {
        $this->morningOpeningHour = $morningOpeningHour;

        return $this;
    }

    public function getMorningClosingHour(): ?\DateTimeInterface
    {
        return $this->morningClosingHour;
    }

    public function setMorningClosingHour(?\DateTimeInterface $morningClosingHour): self
    {
        $this->morningClosingHour = $morningClosingHour;

        return $this;
    }

    public function getEveningOpeningHour(): ?\DateTimeInterface
    {
        return $this->eveningOpeningHour;
    }

    public function setEveningOpeningHour(?\DateTimeInterface $eveningOpeningHour): self
    {
        $this->eveningOpeningHour = $eveningOpeningHour;

        return $this;
    }

    public function getEveningClosingHour(): ?\DateTimeInterface
    {
        return $this->eveningClosingHour;
    }

    public function setEveningClosingHour(?\DateTimeInterface $eveningClosingHour): self
    {
        $this->eveningClosingHour = $eveningClosingHour;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PreviousTripsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreviousTripsRepository::class)]
class PreviousTrips
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $previousTripName = null;

    #[ORM\Column(length: 255)]
    private ?string $previousTripPicture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $previousTripContent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPreviousTripName(): ?string
    {
        return $this->previousTripName;
    }

    public function setPreviousTripName(string $previousTripName): static
    {
        $this->previousTripName = $previousTripName;

        return $this;
    }

    public function getPreviousTripPicture(): ?string
    {
        return $this->previousTripPicture;
    }

    public function setPreviousTripPicture(string $previousTripPicture): static
    {
        $this->previousTripPicture = $previousTripPicture;

        return $this;
    }

    public function getPreviousTripContent(): ?string
    {
        return $this->previousTripContent;
    }

    public function setPreviousTripContent(string $previousTripContent): static
    {
        $this->previousTripContent = $previousTripContent;

        return $this;
    }
}

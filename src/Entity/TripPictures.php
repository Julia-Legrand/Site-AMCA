<?php

namespace App\Entity;

use App\Repository\TripPicturesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripPicturesRepository::class)]
class TripPictures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tripPicture = null;

    #[ORM\ManyToOne(inversedBy: 'tripPictures')]
    private ?PreviousTrips $previousTrips = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTripPicture(): ?string
    {
        return $this->tripPicture;
    }

    public function setTripPicture(string $tripPicture): static
    {
        $this->tripPicture = $tripPicture;

        return $this;
    }

    public function getPreviousTrips(): ?PreviousTrips
    {
        return $this->previousTrips;
    }

    public function setPreviousTrips(?PreviousTrips $previousTrips): static
    {
        $this->previousTrips = $previousTrips;

        return $this;
    }
}

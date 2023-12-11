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

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?PreviousTrips $previousTrips = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

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

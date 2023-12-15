<?php

namespace App\Entity;

use App\Entity\TripPictures;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PreviousTripsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PreviousTripsRepository::class)]
class PreviousTrips
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $previousTripName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $previousTripContent = null;

    #[ORM\OneToMany(mappedBy: 'previousTrips', targetEntity: TripPictures::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $tripPictures;

    public function __construct()
    {
        $this->tripPictures = new ArrayCollection();
    }

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

    public function getPreviousTripContent(): ?string
    {
        return $this->previousTripContent;
    }

    public function setPreviousTripContent(string $previousTripContent): static
    {
        $this->previousTripContent = $previousTripContent;

        return $this;
    }

    /**
     * @return Collection<int, TripPictures>
     */
    public function getTripPictures(): Collection
    {
        return $this->tripPictures;
    }

    public function addTripPicture(TripPictures $tripPicture): static
    {
        if (!$this->tripPictures->contains($tripPicture)) {
            $this->tripPictures->add($tripPicture);
            $tripPicture->setPreviousTrips($this);
        }

        return $this;
    }

    public function removeTripPicture(TripPictures $tripPicture): static
    {
        if ($this->tripPictures->removeElement($tripPicture)) {
            // set the owning side to null (unless already changed)
            if ($tripPicture->getPreviousTrips() === $this) {
                $tripPicture->setPreviousTrips(null);
            }
        }

        return $this;
    }
}

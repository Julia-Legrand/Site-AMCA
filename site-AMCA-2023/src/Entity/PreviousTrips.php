<?php

namespace App\Entity;

use App\Repository\PreviousTripsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'previoustrips', targetEntity: Images::class)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setPrevioustrips($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPrevioustrips() === $this) {
                $image->setPrevioustrips(null);
            }
        }

        return $this;
    }
}

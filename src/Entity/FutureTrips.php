<?php

namespace App\Entity;

use App\Repository\FutureTripsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FutureTripsRepository::class)]
class FutureTrips
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $futureTripName = null;

    #[ORM\Column(length: 255)]
    private ?string $futureTripPicture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    private ?float $budget = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $futureTripContent = null;

    #[ORM\Column]
    private ?int $numberOfPlaces = null;

    #[ORM\Column]
    private ?float $futureTripLon = null;

    #[ORM\Column]
    private ?float $futureTripLat = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'futureTrips')]
    private Collection $users;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $presentationSheet = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFutureTripName(): ?string
    {
        return $this->futureTripName;
    }

    public function setFutureTripName(string $futureTripName): static
    {
        $this->futureTripName = $futureTripName;

        return $this;
    }

    public function getFutureTripPicture(): ?string
    {
        return $this->futureTripPicture;
    }

    public function setFutureTripPicture(string $futureTripPicture): static
    {
        $this->futureTripPicture = $futureTripPicture;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getFutureTripContent(): ?string
    {
        return $this->futureTripContent;
    }

    public function setFutureTripContent(string $futureTripContent): static
    {
        $this->futureTripContent = $futureTripContent;

        return $this;
    }

    public function getNumberOfPlaces(): ?int
    {
        return $this->numberOfPlaces;
    }

    public function setNumberOfPlaces(int $numberOfPlaces): static
    {
        $this->numberOfPlaces = $numberOfPlaces;

        return $this;
    }

    public function getFutureTripLon(): ?float
    {
        return $this->futureTripLon;
    }

    public function setFutureTripLon(float $futureTripLon): static
    {
        $this->futureTripLon = $futureTripLon;

        return $this;
    }

    public function getFutureTripLat(): ?float
    {
        return $this->futureTripLat;
    }

    public function setFutureTripLat(float $futureTripLat): static
    {
        $this->futureTripLat = $futureTripLat;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function getPresentationSheet(): ?string
    {
        return $this->presentationSheet;
    }

    public function setPresentationSheet(?string $presentationSheet): static
    {
        $this->presentationSheet = $presentationSheet;

        return $this;
    }
}

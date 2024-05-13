<?php

namespace App\Entity;

use App\Repository\PressReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PressReviewsRepository::class)]
class PressReviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $pressReviewTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $pressReviewPicture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $pressReviewDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPressReviewTitle(): ?string
    {
        return $this->pressReviewTitle;
    }

    public function setPressReviewTitle(string $pressReviewTitle): static
    {
        $this->pressReviewTitle = $pressReviewTitle;

        return $this;
    }

    public function getPressReviewPicture(): ?string
    {
        return $this->pressReviewPicture;
    }

    public function setPressReviewPicture(string $pressReviewPicture): static
    {
        $this->pressReviewPicture = $pressReviewPicture;

        return $this;
    }

    public function getPressReviewDate(): ?\DateTimeInterface
    {
        return $this->pressReviewDate;
    }

    public function setPressReviewDate(\DateTimeInterface $pressReviewDate): static
    {
        $this->pressReviewDate = $pressReviewDate;

        return $this;
    }
}

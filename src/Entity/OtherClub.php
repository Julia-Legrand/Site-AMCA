<?php

namespace App\Entity;

use App\Repository\OtherClubRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OtherClubRepository::class)]
class OtherClub
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $otherClubTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $otherClubPicture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $otherClubContent = null;

    #[ORM\Column(length: 255)]
    private ?string $otherClubWebsite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOtherClubTitle(): ?string
    {
        return $this->otherClubTitle;
    }

    public function setOtherClubTitle(string $otherClubTitle): static
    {
        $this->otherClubTitle = $otherClubTitle;

        return $this;
    }

    public function getOtherClubPicture(): ?string
    {
        return $this->otherClubPicture;
    }

    public function setOtherClubPicture(string $otherClubPicture): static
    {
        $this->otherClubPicture = $otherClubPicture;

        return $this;
    }

    public function getOtherClubContent(): ?string
    {
        return $this->otherClubContent;
    }

    public function setOtherClubContent(string $otherClubContent): static
    {
        $this->otherClubContent = $otherClubContent;

        return $this;
    }

    public function getOtherClubWebsite(): ?string
    {
        return $this->otherClubWebsite;
    }

    public function setOtherClubWebsite(string $otherClubWebsite): static
    {
        $this->otherClubWebsite = $otherClubWebsite;

        return $this;
    }
}

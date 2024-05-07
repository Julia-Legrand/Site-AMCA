<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $galleryPicture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $galleryComment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGalleryPicture(): ?string
    {
        return $this->galleryPicture;
    }

    public function setGalleryPicture(string $galleryPicture): static
    {
        $this->galleryPicture = $galleryPicture;

        return $this;
    }

    public function getGalleryComment(): ?string
    {
        return $this->galleryComment;
    }

    public function setGalleryComment(string $galleryComment): static
    {
        $this->galleryComment = $galleryComment;

        return $this;
    }
}

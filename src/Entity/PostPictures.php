<?php

namespace App\Entity;

use App\Repository\PostPicturesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostPicturesRepository::class)]
class PostPictures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postPicture = null;

    #[ORM\ManyToOne(inversedBy: 'postPicture')]
    private ?Posts $posts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostPicture(): ?string
    {
        return $this->postPicture;
    }

    public function setPostPicture(?string $postPicture): static
    {
        $this->postPicture = $postPicture;

        return $this;
    }

    public function getPosts(): ?Posts
    {
        return $this->posts;
    }

    public function setPosts(?Posts $posts): static
    {
        $this->posts = $posts;

        return $this;
    }
}

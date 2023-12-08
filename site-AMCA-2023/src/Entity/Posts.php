<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $postTitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $postContent = null;

    #[ORM\Column]
    private ?\DateTime $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'post')]
    private ?Themes $themes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostTitle(): ?string
    {
        return $this->postTitle;
    }

    public function setPostTitle(string $postTitle): static
    {
        $this->postTitle = $postTitle;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->postContent;
    }

    public function setPostContent(string $postContent): static
    {
        $this->postContent = $postContent;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getThemes(): ?Themes
    {
        return $this->themes;
    }

    public function setThemes(?Themes $themes): static
    {
        $this->themes = $themes;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemesRepository::class)]
class Themes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $themeTitle = null;

    #[ORM\ManyToOne(inversedBy: 'themes')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'themes', targetEntity: Posts::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $post;

    public function __construct()
    {
        $this->post = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThemeTitle(): ?string
    {
        return $this->themeTitle;
    }

    public function setThemeTitle(string $themeTitle): static
    {
        $this->themeTitle = $themeTitle;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Posts>
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Posts $post): static
    {
        if (!$this->post->contains($post)) {
            $this->post->add($post);
            $post->setThemes($this);
        }

        return $this;
    }

    public function removePost(Posts $post): static
    {
        if ($this->post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getThemes() === $this) {
                $post->setThemes(null);
            }
        }

        return $this;
    }
}

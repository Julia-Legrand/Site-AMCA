<?php

namespace App\Entity;

use App\Repository\MemoryDutyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemoryDutyRepository::class)]
class MemoryDuty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $memoryTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $memoryPicture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $memoryContent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemoryTitle(): ?string
    {
        return $this->memoryTitle;
    }

    public function setMemoryTitle(string $memoryTitle): static
    {
        $this->memoryTitle = $memoryTitle;

        return $this;
    }

    public function getMemoryPicture(): ?string
    {
        return $this->memoryPicture;
    }

    public function setMemoryPicture(string $memoryPicture): static
    {
        $this->memoryPicture = $memoryPicture;

        return $this;
    }

    public function getMemoryContent(): ?string
    {
        return $this->memoryContent;
    }

    public function setMemoryContent(string $memoryContent): static
    {
        $this->memoryContent = $memoryContent;

        return $this;
    }
}

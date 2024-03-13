<?php

namespace App\Entity;

use App\Repository\PurposesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurposesRepository::class)]
class Purposes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $purposeContent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurposeContent(): ?string
    {
        return $this->purposeContent;
    }

    public function setPurposeContent(string $purposeContent): static
    {
        $this->purposeContent = $purposeContent;

        return $this;
    }
}

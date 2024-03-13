<?php

namespace App\Entity;

use App\Repository\PresentationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresentationsRepository::class)]
class Presentations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $presentationTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $presentationPicture = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $presentationContent = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $statutesDoc = null;

    #[ORM\Column(length: 255)]
    private ?string $internalRulesDoc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentationTitle(): ?string
    {
        return $this->presentationTitle;
    }

    public function setPresentationTitle(string $presentationTitle): static
    {
        $this->presentationTitle = $presentationTitle;

        return $this;
    }

    public function getPresentationPicture(): ?string
    {
        return $this->presentationPicture;
    }

    public function setPresentationPicture(string $presentationPicture): static
    {
        $this->presentationPicture = $presentationPicture;

        return $this;
    }

    public function getPresentationContent(): ?string
    {
        return $this->presentationContent;
    }

    public function setPresentationContent(string $presentationContent): static
    {
        $this->presentationContent = $presentationContent;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getStatutesDoc(): ?string
    {
        return $this->statutesDoc;
    }

    public function setStatutesDoc(string $statutesDoc): static
    {
        $this->statutesDoc = $statutesDoc;

        return $this;
    }

    public function getInternalRulesDoc(): ?string
    {
        return $this->internalRulesDoc;
    }

    public function setInternalRulesDoc(string $internalRulesDoc): static
    {
        $this->internalRulesDoc = $internalRulesDoc;

        return $this;
    }
}

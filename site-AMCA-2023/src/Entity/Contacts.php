<?php

namespace App\Entity;

use App\Repository\ContactsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactsRepository::class)]
class Contacts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $contactName = null;

    #[ORM\Column(length: 100)]
    private ?string $contactMail = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contactMessage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): static
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactMail(): ?string
    {
        return $this->contactMail;
    }

    public function setContactMail(string $contactMail): static
    {
        $this->contactMail = $contactMail;

        return $this;
    }

    public function getContactMessage(): ?string
    {
        return $this->contactMessage;
    }

    public function setContactMessage(string $contactMessage): static
    {
        $this->contactMessage = $contactMessage;

        return $this;
    }
}

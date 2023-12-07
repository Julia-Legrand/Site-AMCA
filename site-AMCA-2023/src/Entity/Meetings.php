<?php

namespace App\Entity;

use App\Repository\MeetingsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetingsRepository::class)]
class Meetings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $meetingDate = null;

    #[ORM\Column(length: 255)]
    private ?string $meetingPicture = null;

    #[ORM\Column(length: 255)]
    private ?string $meetingAddress = null;

    #[ORM\Column]
    private ?float $meetingLon = null;

    #[ORM\Column]
    private ?float $meetingLat = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $meetingContent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetingDate(): ?\DateTime
    {
        return $this->meetingDate;
    }

    public function setMeetingDate(\DateTime $meetingDate): static
    {
        $this->meetingDate = $meetingDate;

        return $this;
    }

    public function getMeetingPicture(): ?string
    {
        return $this->meetingPicture;
    }

    public function setMeetingPicture(string $meetingPicture): static
    {
        $this->meetingPicture = $meetingPicture;

        return $this;
    }

    public function getMeetingAddress(): ?string
    {
        return $this->meetingAddress;
    }

    public function setMeetingAddress(string $meetingAddress): static
    {
        $this->meetingAddress = $meetingAddress;

        return $this;
    }

    public function getMeetingLon(): ?float
    {
        return $this->meetingLon;
    }

    public function setMeetingLon(float $meetingLon): static
    {
        $this->meetingLon = $meetingLon;

        return $this;
    }

    public function getMeetingLat(): ?float
    {
        return $this->meetingLat;
    }

    public function setMeetingLat(float $meetingLat): static
    {
        $this->meetingLat = $meetingLat;

        return $this;
    }

    public function getMeetingContent(): ?string
    {
        return $this->meetingContent;
    }

    public function setMeetingContent(string $meetingContent): static
    {
        $this->meetingContent = $meetingContent;

        return $this;
    }
}

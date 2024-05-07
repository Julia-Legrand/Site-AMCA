<?php

namespace App\Entity;

use App\Repository\MembershipsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembershipsRepository::class)]
class Memberships
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $membershipForm = null;

    #[ORM\Column]
    private ?int $driverFee = null;

    #[ORM\Column]
    private ?int $passengerFee = null;

    #[ORM\Column(length: 255)]
    private ?string $trombinoscope = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembershipForm(): ?string
    {
        return $this->membershipForm;
    }

    public function setMembershipForm(string $membershipForm): static
    {
        $this->membershipForm = $membershipForm;

        return $this;
    }

    public function getDriverFee(): ?int
    {
        return $this->driverFee;
    }

    public function setDriverFee(int $driverFee): static
    {
        $this->driverFee = $driverFee;

        return $this;
    }

    public function getPassengerFee(): ?int
    {
        return $this->passengerFee;
    }

    public function setPassengerFee(int $passengerFee): static
    {
        $this->passengerFee = $passengerFee;

        return $this;
    }

    public function getTrombinoscope(): ?string
    {
        return $this->trombinoscope;
    }

    public function setTrombinoscope(string $trombinoscope): static
    {
        $this->trombinoscope = $trombinoscope;

        return $this;
    }
}

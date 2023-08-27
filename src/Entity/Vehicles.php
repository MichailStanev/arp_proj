<?php

namespace App\Entity;

use App\Repository\VehiclesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiclesRepository::class)]
class Vehicles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicleName = null;

    #[ORM\Column(length: 255)]
    private ?string $plateNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $acquiringDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fuelType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getvehicleName(): ?string
    {
        return $this->vehicleName;
    }

    public function setvehicleName(string $vehicleName): static
    {
        $this->vehicleName = $vehicleName;

        return $this;
    }

    public function getPlateNumber(): ?string
    {
        return $this->plateNumber;
    }

    public function setPlateNumber(string $plateNumber): static
    {
        $this->plateNumber = $plateNumber;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAcquiringDate(): ?\DateTimeInterface
    {
        return $this->acquiringDate;
    }

    public function setAcquiringDate(?\DateTimeInterface $acquiringDate): static
    {
        $this->acquiringDate = $acquiringDate;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(?string $fuelType): static
    {
        $this->fuelType = $fuelType;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\PayementsRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayementsRepository::class)]
class Payements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'payements', cascade: ['persist', 'remove'])]
    private ?Reservations $reservation = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $paymentDate = null;

    #[ORM\Column(length: 255)]
    private ?string $paymentMethod = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['pending', 'confirmed', 'cancelled'], message: 'Invalid status')]
    private ?string $status = null;

    public final function getId(): ?int
    {
        return $this->id;
    }

    public final function getReservationId(): ?Reservations
    {
        return $this->reservation;
    }

    public final function setReservationId(?Reservations $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    public final function getAmount(): ?string
    {
        return $this->amount;
    }

    public final function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public final function getPaymentDate(): ?\DateTimeImmutable
    {
        return $this->paymentDate;
    }

    public final function setPaymentDate(\DateTimeImmutable $paymentDate): static
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public final function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public final function setPaymentMethod(string $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public final function getStatus(): ?string
    {
        return $this->status;
    }

    public final function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}

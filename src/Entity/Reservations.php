<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Guests::class, inversedBy: 'reservations')]
    #[Groups(["getRooms"])]
    private ?Guests $guestId = null;

    #[ORM\ManyToMany(targetEntity: Rooms::class, inversedBy: 'reservations')]
    #[ORM\JoinTable(name: 'reservation_room')]
    private Collection $rooms;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['pending', 'confirmed', 'cancelled'], message: 'Invalid status')]
    #[Groups(["getRooms"])]
    private ?string $status = null;

    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'reservationId', cascade: ['persist', 'remove'])]
    #[Groups(["getRooms"])]
    private ?Payements $payements = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $user = null;


    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }

    public final function getId(): ?int
    {
        return $this->id;
    }

    public final function getGuestId(): ?Guests
    {
        return $this->guestId;
    }

    public final function setGuestId(?Guests $guestId): static
    {
        $this->guestId = $guestId;

        return $this;
    }

    public final function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public final function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public final function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public final function setEndDate(\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

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

    public final function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public final function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public final function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public final function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public final function getPayements(): ?Payements
    {
        return $this->payements;
    }

    public final function setPayements(?Payements $payements): static
    {
        // unset the owning side of the relation if necessary
        if ($payements === null && $this->payements !== null) {
            $this->payements->setReservationId(null);
        }

        // set the owning side of the relation if necessary
        if ($payements !== null && $payements->getReservationId() !== $this) {
            $payements->setReservationId($this);
        }

        $this->payements = $payements;

        return $this;
    }

    public final function addRoom(Rooms $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->addReservation($this);
        }

        return $this;
    }

    public final function removeRoom(Rooms $room): static
    {
        if ($this->rooms->removeElement($room)) {
            $room->removeReservation($this);
        }

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

}

<?php

namespace App\Entity;

use App\Repository\GuestsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuestsRepository::class)]
class Guests
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"L'adresse mail est obligatoire")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le prénom est obligatoire")]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom est obligatoire")]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Reservations>
     */
    #[ORM\OneToMany(targetEntity: Reservations::class, mappedBy: 'guestId')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public final function getId(): ?int
    {
        return $this->id;
    }

    public final function getEmail(): ?string
    {
        return $this->email;
    }

    public final function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public final function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public final function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public final function getLastName(): ?string
    {
        return $this->lastName;
    }

    public final function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public final function getPhone(): ?string
    {
        return $this->phone;
    }

    public final function setPhone(?string $phone): static
    {
        $this->phone = $phone;

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

    /**
     * @return Collection<int, Reservations>
     */
    public final function getReservations(): Collection
    {
        return $this->reservations;
    }

    public final function addReservation(Reservations $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setGuestId($this);
        }

        return $this;
    }

    public final function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getGuestId() === $this) {
                $reservation->setGuestId(null);
            }
        }

        return $this;
    }
}

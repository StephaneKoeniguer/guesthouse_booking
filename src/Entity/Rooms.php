<?php

namespace App\Entity;

use App\Repository\RoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RoomsRepository::class)]
class Rooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRooms"])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["getRooms"])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    #[Groups(["getRooms"])]
    private ?string $pricePerNight = null;

    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?int $capacity = null;

    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Reservations::class, mappedBy: 'rooms')]
    #[Groups(["getRooms"])]
    private Collection $reservations;

    /**
     * @var Collection<int, RoomImage>
     */
    #[ORM\OneToMany(targetEntity: RoomImage::class, mappedBy: 'roomId', cascade: ['persist', 'remove'])]
    #[Groups(["getRooms"])]
    private Collection $roomImages;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'roomId', cascade: ['persist', 'remove'])]
    #[Groups(["getRooms"])]
    private Collection $reviews;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->roomImages = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public final function getId(): ?int
    {
        return $this->id;
    }

    public final function getName(): ?string
    {
        return $this->name;
    }

    public final function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public final function getDescription(): ?string
    {
        return $this->description;
    }

    public final function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public final function getPricePerNight(): ?string
    {
        return $this->pricePerNight;
    }

    public final function setPricePerNight(string $pricePerNight): static
    {
        $this->pricePerNight = $pricePerNight;

        return $this;
    }

    public final function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public final function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

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
            $reservation->addRoom($this);
        }

        return $this;
    }

    public final function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeRoom($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RoomImage>
     */
    public final function getRoomImages(): Collection
    {
        return $this->roomImages;
    }

    public final function addRoomImage(RoomImage $roomImage): static
    {
        if (!$this->roomImages->contains($roomImage)) {
            $this->roomImages->add($roomImage);
            $roomImage->setRoomId($this);
        }

        return $this;
    }

    public final function removeRoomImage(RoomImage $roomImage): static
    {
        if ($this->roomImages->removeElement($roomImage)) {
            // set the owning side to null (unless already changed)
            if ($roomImage->getRoomId() === $this) {
                $roomImage->setRoomId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public final function getReviews(): Collection
    {
        return $this->reviews;
    }

    public final function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setRoomId($this);
        }

        return $this;
    }

    public final function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getRoomId() === $this) {
                $review->setRoomId(null);
            }
        }

        return $this;
    }
}

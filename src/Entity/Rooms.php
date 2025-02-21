<?php

namespace App\Entity;

use App\Repository\RoomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RoomsRepository::class)]
class Rooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getRooms", "getReservations"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRooms", "getReservations"])]
    #[Assert\NotBlank(message:"Le nom est obligatoire")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["getRooms", "getReservations"])]
    #[Assert\NotBlank(message:"Las description est obligatoire")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    #[Groups(["getRooms", "getReservations"])]
    #[Assert\NotBlank(message:"Le prix est obligatoire")]
    private ?string $pricePerNight = null;

    #[ORM\Column]
    #[Groups(["getRooms", "getReservations"])]
    #[Assert\NotBlank(message:"La capacité d'accueil est obligatoire")]
    private ?int $capacity = null;

    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Reservations::class, mappedBy: 'rooms')]
    #[Groups(["getRooms"])]
    private Collection $reservations;

    /**
     * @var Collection<int, RoomImage>
     */
    #[ORM\OneToMany(targetEntity: RoomImage::class, mappedBy: 'room', cascade: ['persist', 'remove'])]
    #[Groups(["getRooms"])]
    private Collection $roomImages;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'room', cascade: ['persist', 'remove'])]
    #[Groups(["getRooms", "getReservations"])]
    private Collection $reviews;

    #[ORM\ManyToOne(inversedBy: 'room')]
    #[Groups(["getRooms", "getReservations"])]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRooms", "getReservations"])]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRooms", "getReservations"])]
    private ?string $city = null;

    #[ORM\Column]
    #[Groups(["getRooms", "getReservations"])]
    private ?int $zipCode = null;

    /**
     * @var Collection<int, Amenities>
     */
    #[ORM\ManyToMany(targetEntity: Amenities::class, mappedBy: 'room')]
    #[Groups(["getRooms"])]
    private Collection $amenities;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    #[Groups(["getRooms"])]
    private ?User $user = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->roomImages = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->amenities = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return Collection<int, Amenities>
     */
    public function getAmenities(): Collection
    {
        return $this->amenities;
    }

    public function addAmenity(Amenities $amenity): static
    {
        if (!$this->amenities->contains($amenity)) {
            $this->amenities->add($amenity);
            $amenity->addRoom($this);
        }

        return $this;
    }

    public function removeAmenity(Amenities $amenity): static
    {
        if ($this->amenities->removeElement($amenity)) {
            $amenity->removeRoom($this);
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

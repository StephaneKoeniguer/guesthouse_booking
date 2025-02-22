<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getRooms", "getReview"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?Rooms $room = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getRooms", "getReview"])]
    #[Assert\NotBlank(message:"La note est obligatoire")]
    private ?int $rating = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getRooms", "getReview"])]
    private ?string $comment = null;

    #[ORM\Column]
    #[Groups(["getRooms", "getReview"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[Groups(["getRooms", "getReview"])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[Groups(["getRooms", "getReview"])]
    private ?Guests $guest = null;

    public final function getId(): ?int
    {
        return $this->id;
    }

    public final function getRoomId(): ?Rooms
    {
        return $this->room;
    }

    public final function setRoomId(?Rooms $room): static
    {
        $this->room = $room;

        return $this;
    }

    public final function getRating(): ?int
    {
        return $this->rating;
    }

    public final function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public final function getComment(): ?string
    {
        return $this->comment;
    }

    public final function setComment(?string $comment): static
    {
        $this->comment = $comment;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getGuest(): ?Guests
    {
        return $this->guest;
    }

    public function setGuest(?Guests $guest): static
    {
        $this->guest = $guest;

        return $this;
    }
}

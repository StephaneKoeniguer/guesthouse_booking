<?php

namespace App\Entity;

use App\Repository\RoomImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomImageRepository::class)]
class RoomImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'roomImages')]
    private ?Rooms $roomId = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public final function getId(): ?int
    {
        return $this->id;
    }

    public final function getRoomId(): ?Rooms
    {
        return $this->roomId;
    }

    public final function setRoomId(?Rooms $roomId): static
    {
        $this->roomId = $roomId;

        return $this;
    }

    public final function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public final function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

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
}

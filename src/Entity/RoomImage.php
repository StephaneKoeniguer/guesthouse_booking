<?php

namespace App\Entity;

use App\Repository\RoomImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RoomImageRepository::class)]
class RoomImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'roomImages')]
    private ?Rooms $room = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRooms"])]
    private ?string $imageUrl = null;

    #[ORM\Column]
    #[Groups(["getRooms"])]
    private ?\DateTimeImmutable $createdAt = null;

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

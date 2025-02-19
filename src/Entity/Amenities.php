<?php

namespace App\Entity;

use App\Repository\AmenitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AmenitiesRepository::class)]
class Amenities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getRooms"])]
    private ?string $name = null;

    /**
     * @var Collection<int, Rooms>
     */
    #[ORM\ManyToMany(targetEntity: Rooms::class, inversedBy: 'amenities')]
    private Collection $room;

    public function __construct()
    {
        $this->room = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Rooms>
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom(Rooms $room): static
    {
        if (!$this->room->contains($room)) {
            $this->room->add($room);
        }

        return $this;
    }

    public function removeRoom(Rooms $room): static
    {
        $this->room->removeElement($room);

        return $this;
    }
}

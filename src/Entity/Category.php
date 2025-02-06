<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getCategory", "getRooms"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCategory", "getRooms"])]
    private ?string $name = null;

    /**
     * @var Collection<int, Rooms>
     */
    #[ORM\OneToMany(targetEntity: Rooms::class, mappedBy: 'category')]
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
            $room->setCategory($this);
        }

        return $this;
    }

    public function removeRoom(Rooms $room): static
    {
        if ($this->room->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getCategory() === $this) {
                $room->setCategory(null);
            }
        }

        return $this;
    }
}

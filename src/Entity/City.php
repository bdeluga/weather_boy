<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $lat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 7)]
    private ?string $lon = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $iso = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Forcast::class)]
    private Collection $forcast;

    public function __construct()
    {
        $this->forcast = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(string $lon): static
    {
        $this->lon = $lon;

        return $this;
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

    public function getIso(): ?string
    {
        return $this->iso;
    }

    public function setIso(string $iso): static
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * @return Collection<int, forcast>
     */
    public function getForcast(): Collection
    {
        return $this->forcast;
    }

    public function addForcast(Forcast $forcast): static
    {
        if (!$this->forcast->contains($forcast)) {
            $this->forcast->add($forcast);
            $forcast->setCity($this);
        }

        return $this;
    }

    public function removeForcast(Forcast $forcast): static
    {
        if ($this->forcast->removeElement($forcast)) {
            // set the owning side to null (unless already changed)
            if ($forcast->getCity() === $this) {
                $forcast->setCity(null);
            }
        }

        return $this;
    }
}

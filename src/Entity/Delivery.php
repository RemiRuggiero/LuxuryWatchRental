<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $tracking_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $country;

    /**
     * @ORM\Column(type="date")
     */
    private $returned_at;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DeliveryCompany", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $delivery_company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="delivery")
     */
    private $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->tracking_number;
    }

    public function setTrackingNumber(string $tracking_number): self
    {
        $this->tracking_number = $tracking_number;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getReturnedAt(): ?\DateTimeInterface
    {
        return $this->returned_at;
    }

    public function setReturnedAt(\DateTimeInterface $returned_at): self
    {
        $this->returned_at = $returned_at;

        return $this;
    }

    public function getDeliveryCompany(): ?DeliveryCompany
    {
        return $this->delivery_company;
    }

    public function setDeliveryCompany(DeliveryCompany $delivery_company): self
    {
        $this->delivery_company = $delivery_company;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setDelivery($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getDelivery() === $this) {
                $location->setDelivery(null);
            }
        }

        return $this;
    }

    
}

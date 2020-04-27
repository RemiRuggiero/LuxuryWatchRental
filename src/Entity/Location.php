<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location 
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
    private $location_number;

    /**
     * @ORM\Column(type="datetime")
     */
    private $starts_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ends_at;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_paid;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $bill_number;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\WatchEntity", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $watch_entity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Delivery", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $delivery;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationNumber(): ?string
    {
        return $this->location_number;
    }

    public function setLocationNumber(string $location_number): self
    {
        $this->location_number = $location_number;

        return $this;
    }

    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->starts_at;
    }

    public function setStartsAt(\DateTimeInterface $starts_at): self
    {
        $this->starts_at = $starts_at;

        return $this;
    }

    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->ends_at;
    }

    public function setEndsAt(\DateTimeInterface $ends_at): self
    {
        $this->ends_at = $ends_at;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIsPaid(): ?int
    {
        return $this->is_paid;
    }

    public function setIsPaid(int $is_paid): self
    {
        $this->is_paid = $is_paid;

        return $this;
    }

    public function getBillNumber(): ?string
    {
        return $this->bill_number;
    }

    public function setBillNumber(string $bill_number): self
    {
        $this->bill_number = $bill_number;

        return $this;
    }

    public function getWatchEntity(): ?WatchEntity
    {
        return $this->watch_entity;
    }

    public function setWatchEntity(WatchEntity $watch_entity): self
    {
        $this->watch_entity = $watch_entity;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }


}

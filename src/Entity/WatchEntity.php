<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WatchEntityRepository")
 */
class WatchEntity
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
    private $serial_number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WatchModel", inversedBy="watchEntities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $watch_model;

    /**
     * @ORM\Column(type="boolean", options={"default": true}
 )
     */
    private $available;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serial_number;
    }

    public function setSerialNumber(string $serial_number): self
    {
        $this->serial_number = $serial_number;

        return $this;
    }

    public function getWatchModel(): ?WatchModel
    {
        return $this->watch_model;
    }

    public function setWatchModel(?WatchModel $watch_model): self
    {
        $this->watch_model = $watch_model;

        return $this;
    }

    public function __toString()
    {
        return $this->serial_number;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

}

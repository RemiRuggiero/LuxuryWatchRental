<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WatchModelRepository")
 */
class WatchModel
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
    private $brand;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $gender;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $color;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $movement;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $diameter;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $waterproof;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $glass;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $function;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $watch_clasps;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $bracelet;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $watch_dial;

    /**
     * @ORM\Column(type="integer")
     */
    private $deposit;

   

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\WatchEntity", mappedBy="watch_model", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $watchEntities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Picture", mappedBy="watch_model", cascade={"persist", "remove"})
     */
    private $pictures;

    

    public function __construct()
    {
        $this->watchEntities = new ArrayCollection();
        $this->picture = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMovement(): ?string
    {
        return $this->movement;
    }

    public function setMovement(string $movement): self
    {
        $this->movement = $movement;

        return $this;
    }

    public function getDiameter(): ?string
    {
        return $this->diameter;
    }

    public function setDiameter(string $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getWaterproof(): ?string
    {
        return $this->waterproof;
    }

    public function setWaterproof(string $waterproof): self
    {
        $this->waterproof = $waterproof;

        return $this;
    }

    public function getGlass(): ?string
    {
        return $this->glass;
    }

    public function setGlass(string $glass): self
    {
        $this->glass = $glass;

        return $this;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(string $function): self
    {
        $this->function = $function;

        return $this;
    }

    public function getWatchClasps(): ?string
    {
        return $this->watch_clasps;
    }

    public function setWatchClasps(string $watch_clasps): self
    {
        $this->watch_clasps = $watch_clasps;

        return $this;
    }

    public function getBracelet(): ?string
    {
        return $this->bracelet;
    }

    public function setBracelet(string $bracelet): self
    {
        $this->bracelet = $bracelet;

        return $this;
    }

    public function getWatchDial(): ?string
    {
        return $this->watch_dial;
    }

    public function setWatchDial(string $watch_dial): self
    {
        $this->watch_dial = $watch_dial;

        return $this;
    }

    public function getDeposit(): ?int
    {
        return $this->deposit;
    }

    public function setDeposit(int $deposit): self
    {
        $this->deposit = $deposit;

        return $this;
    }

    

    /**
     * @return Collection|WatchEntity[]
     */
    public function getWatchEntities(): Collection
    {
        return $this->watchEntities;
    }

    public function addWatchEntity(WatchEntity $watchEntity): self
    {
        if (!$this->watchEntities->contains($watchEntity)) {
            $this->watchEntities[] = $watchEntity;
            $watchEntity->setWatchModel($this);
        }

        return $this;
    }

    public function removeWatchEntity(WatchEntity $watchEntity): self
    {
        if ($this->watchEntities->contains($watchEntity)) {
            $this->watchEntities->removeElement($watchEntity);
            // set the owning side to null (unless already changed)
            if ($watchEntity->getWatchModel() === $this) {
                $watchEntity->setWatchModel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setWatchModel($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getWatchModel() === $this) {
                $picture->setWatchModel(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->model;
    }

    
}

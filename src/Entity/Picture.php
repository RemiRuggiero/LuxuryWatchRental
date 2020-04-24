<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\WatchModel", inversedBy="pictures")
     */
    private $watch_model;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

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

<<<<<<< HEAD
   
=======
    public function __toString()
    {
        return $this->picture_1;
    }
>>>>>>> c0f3874901be48d8261f3559ffd78d2710abcde1
}

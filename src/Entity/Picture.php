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

    public function getName(){
        $pictureName = str_replace( '\\', '/',  $this->getPicture() );
        $pictureName = explode('/', $pictureName);
        /* dd($pictureName); */  
        return end($pictureName);
    }
}

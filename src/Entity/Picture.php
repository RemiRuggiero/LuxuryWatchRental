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
    private $picture_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_6;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture1(): ?string
    {
        return $this->picture_1;
    }

    public function setPicture1(string $picture_1): self
    {
        $this->picture_1 = $picture_1;

        return $this;
    }

    public function getPicture2(): ?string
    {
        return $this->picture_2;
    }

    public function setPicture2(string $picture_2): self
    {
        $this->picture_2 = $picture_2;

        return $this;
    }

    public function getPicture3(): ?string
    {
        return $this->picture_3;
    }

    public function setPicture3(string $picture_3): self
    {
        $this->picture_3 = $picture_3;

        return $this;
    }

    public function getPicture4(): ?string
    {
        return $this->picture_4;
    }

    public function setPicture4(string $picture_4): self
    {
        $this->picture_4 = $picture_4;

        return $this;
    }

    public function getPicture5(): ?string
    {
        return $this->picture_5;
    }

    public function setPicture5(string $picture_5): self
    {
        $this->picture_5 = $picture_5;

        return $this;
    }

    public function getPicture6(): ?string
    {
        return $this->picture_6;
    }

    public function setPicture6(string $picture_6): self
    {
        $this->picture_6 = $picture_6;

        return $this;
    }

    public function __toString()
    {
        return $this->picture_1;
    }
}

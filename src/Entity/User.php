<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @UniqueEntity("email", message = "Cette adresse email est déjà utilisée", groups={"registration"})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @Assert\NotBlank( message = "Vous devez saisir votre prénom" )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "Le prénom doit comporter au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

   /**
     * @Assert\NotBlank( message = "Vous devez saisir votre nom" )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "Le nom doit comporter au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @Assert\NotBlank( message = "Vous devez saisir votre date de naissance" )
     * @Assert\LessThanOrEqual("-18 years", message = "Vous devez être majeur pour créer un compte")
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="integer")
     */
    private $gender;

    /**
     * @Assert\NotBlank( message = "Vous devez saisir votre numéro de téléphone" )
     *@Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Le numéro de téléphone doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "Le numéro de téléphone doit comporter au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $phone_number;

    /**
     * @Assert\NotBlank( message = "Vous devez saisir votre adresse postale" )
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "L'adresse doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "L'adresse doit comporter au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @Assert\NotBlank( message = "Vous devez saisir votre ville" )
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "La ville doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "La ville nom doit comporter au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $town;

    /**
     * @Assert\NotBlank( message = "Vous devez saisir votre code postal" )
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le code postale doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "Le code postale doit comporter au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $zipcode;

    /**
     * @Assert\NotBlank( message = "Vous devez saisir votre pays" )
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $country;

     /**
     * @Assert\NotBlank( message = "Vous devez saisir une adresse e-mail" )
     * @Assert\Email(
     *     message = "L'adresse e-mail n'est pas valide"
     * )
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

     /**
     * @Assert\NotBlank( message = "Vous devez saisir un mot de passe", groups={"registration"} )
     * @Assert\Length(
     *      min = 6,
     *      max = 16,
     *      minMessage = "Le mot de passe doit comporter au minimum {{ limit }} caractères",
     *      maxMessage = "Le mot de passe doit comporter au maximum {{ limit }} caractères",
     *      groups={"registration"}
     * )
     */    
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identity_card;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="user")
     */
    private $locations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reset_token;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enable;

    /**
     *  @Assert\NotBlank( message = "Vous devez ajouter votre carte d'identité " )
      * @Assert\File(
      *     maxSize = "2M",
      *     maxSizeMessage = "Votre fichier est trop lourd, il ne doit pas dépasser {{ limit }}{{ suffix }}",
      *     mimeTypes = {"image/png", "image/jpeg" , "application/pdf"},
      *     mimeTypesMessage = "Seules les fichiers PNG, JPEG et PDF sont autorisées",
      * )
     */
    private $cardFile;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday($birthday): self
    {
        $this->birthday = $birthday;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getIdentityCard(): ?string
    {
        return $this->identity_card;
    }

    public function setIdentityCard(string $identity_card): self
    {
        $this->identity_card = $identity_card;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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
            $location->setUser($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getUser() === $this) {
                $location->setUser(null);
            }
        }

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials(){}

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

    public function __toString()
    {
        return $this->firstname.' '.$this->lastname;
    } 

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(?bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function getCardFile(): ?File
    {
        return $this->cardFile;
    }

    public function setCardFile(File $cardFile): self
    {
        $this->cardFile = $cardFile;

        return $this;
    }

    public function serialize()
    {
        return serialize(array( $this->id, $this->email, $this->password));
    }

    public function unserialize($serialized)
    {
        list ( $this->id, $this->email, $this->password) = unserialize($serialized, array('allowed_classes' => false));

    }

}

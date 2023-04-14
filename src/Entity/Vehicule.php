<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Immatriculation;
use App\Validator\TypeDuVehicule;
use App\Validator\Marque;
use App\Validator\CinConducteur;
use Symfony\Component\HttpFoundation\File\File;









/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule", uniqueConstraints={@ORM\UniqueConstraint(name="immatriculation", columns={"immatriculation"})})
 * @ORM\Entity
 */
class Vehicule
{




    /**
     * @ORM\Id
     * @ORM\Column(name="immatriculation", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(message="The immatriculation field cannot be empty.")
     * @Assert\Regex(
     *      pattern="/^\d{1,3}(TUNIS|TU|tunis|tu)\d{1,4}$/",
     *      message="Invalid format for immatriculation. It should be a number (1-999) followed by 'TUNIS' or 'TU' (case-insensitive) and a number (1-9999)."
     * )
     * @Immatriculation()
     */
    private $immatriculation;




    /**

     * @var string
     *
     * @ORM\Column(name="type_du_vehicule", type="string", length=255, nullable=false)
     * @TypeDuVehicule(allowedValues={"voiture", "van", "camion", "bus"})
     */
    private $typeDuVehicule;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Marque(
     *     type="voiture",
     *     allowedValues={
     *         "audi", "bmw", "chevrolet", "ferrari", "ford",
     *         "hyundai", "mercedes", "toyota", "volkswagen"
     *     },
     *     groups={"voiture"}
     * )
     * @Marque(
     *     type="van",
     *     allowedValues={
     *         "mercedes", "ford", "chevrolet", "dodge", "nissan",
     *         "ram", "toyota", "volkswagen", "fiat", "gmc"
     *     },
     *     groups={"van"}
     * )
     * @Marque(
     *     type="camion",
     *     allowedValues={
     *         "ford", "chevrolet", "ram", "gmc", "toyota",
     *         "nissan", "jeep", "dodge"
     *     },
     *     groups={"camion"}
     * )
     * @Marque(
     *     type="bus",
     *     allowedValues={
     *         "blue bird", "thomas built buses", "gillig", "new flyer",
     *         "prevost", "mci", "van hool"
     *     },
     *     groups={"bus"}
     * )
     */
    private $marque;

    /**
     * @var int
     *
     * @ORM\Column(name="cin_conducteur", type="integer", nullable=false)
     * @CinConducteur
     */
    private $cinConducteur;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      notInRangeMessage = "The etat value should be between {{ min }} and {{ max }}."
     * )
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometrage", type="integer", nullable=false)
     * @Assert\Range(
     *      min = 0,
     *      max = 600000,
     *      notInRangeMessage = "The etat value should be between {{ min }} and {{ max }}."
     * )
     */
    private $kilometrage;

    /**

     * @var string|null
     *
     * @ORM\Column(name="imageV", type="string", length=255, nullable=true)
     */
    private $imagev;

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }


    public function getTypeDuVehicule(): ?string
    {
        return $this->typeDuVehicule;
    }

    public function setTypeDuVehicule(string $typeDuVehicule): self
    {
        $this->typeDuVehicule = $typeDuVehicule;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getCinConducteur(): ?int
    {
        return $this->cinConducteur;
    }

    public function setCinConducteur(int $cinConducteur): self
    {
        $this->cinConducteur = $cinConducteur;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getImagev(): ?String
    {
        return $this->imagev;
    }

    public function setImagev(?String $imagev): self
    {
        $this->imagev = $imagev;

        return $this;
    }
}

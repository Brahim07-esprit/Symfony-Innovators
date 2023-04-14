<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conducteur
 *
 * @ORM\Table(name="conducteur")
 * @ORM\Entity
 */
class Conducteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_conducteur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idConducteur;

    /**
     * @var int
     *
     * @ORM\Column(name="cin_conducteur", type="integer", nullable=false)
     */
    private $cinConducteur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_conducteur", type="string", length=255, nullable=false)
     */
    private $nomConducteur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_conducteur", type="string", length=255, nullable=false)
     */
    private $prenomConducteur;

    /**
     * @var int
     *
     * @ORM\Column(name="num_permis", type="integer", nullable=false)
     */
    private $numPermis;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_conducteur", type="string", length=255, nullable=false)
     */
    private $villeConducteur;

    /**
     * @var int
     *
     * @ORM\Column(name="tel_conducteur", type="integer", nullable=false)
     */
    private $telConducteur;

    /**
     * @var string
     *
     * @ORM\Column(name="email_conducteur", type="string", length=255, nullable=false)
     */
    private $emailConducteur;

    public function getIdConducteur(): ?int
    {
        return $this->idConducteur;
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

    public function getNomConducteur(): ?string
    {
        return $this->nomConducteur;
    }

    public function setNomConducteur(string $nomConducteur): self
    {
        $this->nomConducteur = $nomConducteur;

        return $this;
    }

    public function getPrenomConducteur(): ?string
    {
        return $this->prenomConducteur;
    }

    public function setPrenomConducteur(string $prenomConducteur): self
    {
        $this->prenomConducteur = $prenomConducteur;

        return $this;
    }

    public function getNumPermis(): ?int
    {
        return $this->numPermis;
    }

    public function setNumPermis(int $numPermis): self
    {
        $this->numPermis = $numPermis;

        return $this;
    }

    public function getVilleConducteur(): ?string
    {
        return $this->villeConducteur;
    }

    public function setVilleConducteur(string $villeConducteur): self
    {
        $this->villeConducteur = $villeConducteur;

        return $this;
    }

    public function getTelConducteur(): ?int
    {
        return $this->telConducteur;
    }

    public function setTelConducteur(int $telConducteur): self
    {
        $this->telConducteur = $telConducteur;

        return $this;
    }

    public function getEmailConducteur(): ?string
    {
        return $this->emailConducteur;
    }

    public function setEmailConducteur(string $emailConducteur): self
    {
        $this->emailConducteur = $emailConducteur;

        return $this;
    }


}

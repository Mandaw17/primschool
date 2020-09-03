<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table(name="participer", indexes={@ORM\Index(name="fk_eleve_participer", columns={"idEleve"}), @ORM\Index(name="fk_sceance_participer", columns={"jour", "heure", "idMatiere"})})
 * @ORM\Entity
 */
class Participer
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="jour", type="date", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $jour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $heure;

    /**
     * @var int
     *
     * @ORM\Column(name="idMatiere", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idmatiere;

    /**
     * @var int
     *
     * @ORM\Column(name="idEleve", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ideleve;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="absence", type="boolean", nullable=true)
     */
    private $absence;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="retard", type="boolean", nullable=true)
     */
    private $retard;

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function getIdmatiere(): ?int
    {
        return $this->idmatiere;
    }

    public function getIdeleve(): ?int
    {
        return $this->ideleve;
    }

    public function getAbsence(): ?bool
    {
        return $this->absence;
    }

    public function setAbsence(?bool $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    public function getRetard(): ?bool
    {
        return $this->retard;
    }

    public function setRetard(?bool $retard): self
    {
        $this->retard = $retard;

        return $this;
    }


}

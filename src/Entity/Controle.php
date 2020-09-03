<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Controle
 *
 * @ORM\Table(name="controle", indexes={@ORM\Index(name="IDX_E39396EF46CD258", columns={"matiere_id"}), @ORM\Index(name="FK_E39396E8F5EA509", columns={"classe_id"})})
 * @ORM\Entity
 */
class Controle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateControl", type="date", nullable=false)
     */
    private $datecontrol;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duree", type="time", nullable=false)
     */
    private $duree;

    /**
     * @var \Classe
     *
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classe_id", referencedColumnName="id")
     * })
     */
    private $classe;

    /**
     * @var \Matiere
     *
     * @ORM\ManyToOne(targetEntity="Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matiere_id", referencedColumnName="id")
     * })
     */
    private $matiere;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Eleve", mappedBy="idcontrole")
     */
    private $idEleve;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEleve = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecontrol(): ?\DateTimeInterface
    {
        return $this->datecontrol;
    }

    public function setDatecontrol(\DateTimeInterface $datecontrol): self
    {
        $this->datecontrol = $datecontrol;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getIdEleve(): Collection
    {
        return $this->idEleve;
    }

    public function addIdEleve(Eleve $idEleve): self
    {
        if (!$this->idEleve->contains($idEleve)) {
            $this->idEleve[] = $idEleve;
            $idEleve->addIdcontrole($this);
        }

        return $this;
    }

    public function removeIdEleve(Eleve $idEleve): self
    {
        if ($this->idEleve->contains($idEleve)) {
            $this->idEleve->removeElement($idEleve);
            $idEleve->removeIdcontrole($this);
        }

        return $this;
    }

}

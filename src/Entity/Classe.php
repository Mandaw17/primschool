<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table(name="classe", indexes={@ORM\Index(name="fk_parent_eleve", columns={"idEns"})})
 * @ORM\Entity
 */
class Classe
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=25, nullable=false)
     */
    private $nom;

    /**
     * @var \Enseignant
     *
     * @ORM\ManyToOne(targetEntity="Enseignant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEns", referencedColumnName="id")
     * })
     */
    private $idens;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Eleve", mappedBy="idclasse")
     */
    private $ideleve;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Matiere", inversedBy="classe")
     * @ORM\JoinTable(name="classe_matiere",
     *   joinColumns={
     *     @ORM\JoinColumn(name="classe_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="matiere_id", referencedColumnName="id")
     *   }
     * )
     */
    private $matiere;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ideleve = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matiere = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIdens(): ?Enseignant
    {
        return $this->idens;
    }

    public function setIdens(?Enseignant $idens): self
    {
        $this->idens = $idens;

        return $this;
    }

    /**
     * @return Collection|Eleve[]
     */
    public function getIdeleve(): Collection
    {
        return $this->ideleve;
    }

    public function addIdeleve(Eleve $ideleve): self
    {
        if (!$this->ideleve->contains($ideleve)) {
            $this->ideleve[] = $ideleve;
            $ideleve->addIdclasse($this);
        }

        return $this;
    }

    public function removeIdeleve(Eleve $ideleve): self
    {
        if ($this->ideleve->contains($ideleve)) {
            $this->ideleve->removeElement($ideleve);
            $ideleve->removeIdclasse($this);
        }

        return $this;
    }

    /**
     * @return Collection|Matiere[]
     */
    public function getMatiere(): Collection
    {
        return $this->matiere;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matiere->contains($matiere)) {
            $this->matiere[] = $matiere;
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        if ($this->matiere->contains($matiere)) {
            $this->matiere->removeElement($matiere);
        }

        return $this;
    }

}

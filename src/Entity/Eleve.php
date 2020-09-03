<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Eleve
 *
 * @ORM\Table(name="eleve", indexes={@ORM\Index(name="IDX_ECA105F7598E2A0B", columns={"classe_in_id"}), @ORM\Index(name="IDX_ECA105F78F5EA509", columns={"classe_id"})})
 * @ORM\Entity
 */
class Eleve
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=25, nullable=false)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaiss", type="date", nullable=false)
     */
    private $datenaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaiss", type="string", length=50, nullable=false)
     */
    private $lieunaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_parent", type="string", length=255, nullable=false)
     */
    private $nomParent;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_parent", type="string", length=255, nullable=false)
     */
    private $prenomParent;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_parent", type="string", length=9, nullable=false)
     */
    private $telephoneParent;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="emailparent", type="string", length=255, nullable=true)
     */
    private $emailparent;

    /**
     * @var \Classe
     *
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classe_in_id", referencedColumnName="id")
     * })
     */
    private $classeIn;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Classe", inversedBy="ideleve")
     * @ORM\JoinTable(name="annescolaire",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idEleve", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idClasse", referencedColumnName="id")
     *   }
     * )
     */
    private $idclasse;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Controle", inversedBy="idEleve")
     * @ORM\JoinTable(name="passer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_eleve", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idControle", referencedColumnName="id")
     *   }
     * )
     */
    private $idcontrole;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Demande", mappedBy="eleve")
     */
    private $demandes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idclasse = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcontrole = new \Doctrine\Common\Collections\ArrayCollection();
        $this->demandes = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getLieunaiss(): ?string
    {
        return $this->lieunaiss;
    }

    public function setLieunaiss(string $lieunaiss): self
    {
        $this->lieunaiss = $lieunaiss;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNomParent(): ?string
    {
        return $this->nomParent;
    }

    public function setNomParent(string $nomParent): self
    {
        $this->nomParent = $nomParent;

        return $this;
    }

    public function getPrenomParent(): ?string
    {
        return $this->prenomParent;
    }

    public function setPrenomParent(string $prenomParent): self
    {
        $this->prenomParent = $prenomParent;

        return $this;
    }

    public function getTelephoneParent(): ?string
    {
        return $this->telephoneParent;
    }

    public function setTelephoneParent(string $telephoneParent): self
    {
        $this->telephoneParent = $telephoneParent;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmailparent(): ?string
    {
        return $this->emailparent;
    }

    public function setEmailparent(?string $emailparent): self
    {
        $this->emailparent = $emailparent;

        return $this;
    }

    public function getClasseIn(): ?Classe
    {
        return $this->classeIn;
    }

    public function setClasseIn(?Classe $classeIn): self
    {
        $this->classeIn = $classeIn;

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

    /**
     * @return Collection|Classe[]
     */
    public function getIdclasse(): Collection
    {
        return $this->idclasse;
    }

    public function addIdclasse(Classe $idclasse): self
    {
        if (!$this->idclasse->contains($idclasse)) {
            $this->idclasse[] = $idclasse;
        }

        return $this;
    }

    public function removeIdclasse(Classe $idclasse): self
    {
        if ($this->idclasse->contains($idclasse)) {
            $this->idclasse->removeElement($idclasse);
        }

        return $this;
    }

    /**
     * @return Collection|Controle[]
     */
    public function getIdcontrole(): Collection
    {
        return $this->idcontrole;
    }

    public function addIdcontrole(Controle $idcontrole): self
    {
        if (!$this->idcontrole->contains($idcontrole)) {
            $this->idcontrole[] = $idcontrole;
        }

        return $this;
    }

    public function removeIdcontrole(Controle $idcontrole): self
    {
        if ($this->idcontrole->contains($idcontrole)) {
            $this->idcontrole->removeElement($idcontrole);
        }

        return $this;
    }

    /**
     * @return Collection|Demande[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setEleve($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getEleve() === $this) {
                $demande->setEleve(null);
            }
        }

        return $this;
    }

}

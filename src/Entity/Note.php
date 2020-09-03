<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note", indexes={@ORM\Index(name="IDX_CFBDFA14A6CC7B2", columns={"eleve_id"}), @ORM\Index(name="IDX_CFBDFA14758926A6", columns={"controle_id"})})
 * @ORM\Entity
 */
class Note
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
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note;

    /**
     * @var \Controle
     *
     * @ORM\ManyToOne(targetEntity="Controle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="controle_id", referencedColumnName="id")
     * })
     */
    private $controle;

    /**
     * @var \Eleve
     *
     * @ORM\ManyToOne(targetEntity="Eleve")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="eleve_id", referencedColumnName="id")
     * })
     */
    private $eleve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getControle(): ?Controle
    {
        return $this->controle;
    }

    public function setControle(?Controle $controle): self
    {
        $this->controle = $controle;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): self
    {
        $this->eleve = $eleve;

        return $this;
    }


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnneeScolaire
 *
 * @ORM\Table(name="annee_scolaire")
 * @ORM\Entity
 */
class AnneeScolaire
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
     * @ORM\Column(name="annee", type="string", length=9, nullable=false)
     */
    private $annee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }


}

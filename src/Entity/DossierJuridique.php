<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\DossierJuridiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: DossierJuridiqueRepository::class)]
#[ORM\HasLifecycleCallbacks]
class DossierJuridique
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'dossierJuridique', cascade: ['persist', 'remove'])]
    #[JoinColumn(onDelete:'CASCADE')]
    private ?Demande $demande = null;

    #[ORM\OneToMany(mappedBy: 'dossierJuridique', targetEntity: Etape::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $etapes;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $statutBg = null;

    #[ORM\Column(nullable: true)]
    private ?bool $terminer = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $lastStatut = null;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        // unset the owning side of the relation if necessary
        if ($demande === null && $this->demande !== null) {
            $this->demande->setDossierJuridique(null);
        }

        // set the owning side of the relation if necessary
        if ($demande !== null && $demande->getDossierJuridique() !== $this) {
            $demande->setDossierJuridique($this);
        }

        $this->demande = $demande;

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setDossierJuridique($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getDossierJuridique() === $this) {
                $etape->setDossierJuridique(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getStatutBg(): ?string
    {
        return $this->statutBg;
    }

    public function setStatutBg(?string $statutBg): self
    {
        $this->statutBg = $statutBg;

        return $this;
    }

    public function isTerminer(): ?bool
    {
        return $this->terminer;
    }

    public function setTerminer(?bool $terminer): self
    {
        $this->terminer = $terminer;

        return $this;
    }

    public function getLastStatut(): ?string
    {
        return $this->lastStatut;
    }

    public function setLastStatut(?string $lastStatut): self
    {
        $this->lastStatut = $lastStatut;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}

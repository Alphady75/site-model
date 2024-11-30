<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\TarificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: TarificationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Tarification
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $cout = null;

    #[ORM\Column(length: 20)]
    private ?string $typeCout = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'tarification', targetEntity: Demande::class, cascade: ['persist'])]
    private Collection $demandes;

    #[ORM\Column]
    private ?bool $recommander = null;

    #[ORM\OneToMany(mappedBy: 'tarification', targetEntity: Formule::class, cascade: ['persist'])]
    private Collection $formules;

    #[ORM\Column(nullable: true)]
    private ?bool $online = null;

    #[ORM\ManyToOne(inversedBy: 'tarifications')]
    #[JoinColumn(onDelete:'CASCADE')]
    private ?Statut $statut = null;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->formules = new ArrayCollection();
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

    public function getCout(): ?int
    {
        return $this->cout;
    }

    public function setCout(int $cout): self
    {
        $this->cout = $cout;

        return $this;
    }

    public function getTypeCout(): ?string
    {
        return $this->typeCout;
    }

    public function setTypeCout(string $typeCout): self
    {
        $this->typeCout = $typeCout;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setTarification($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getTarification() === $this) {
                $demande->setTarification(null);
            }
        }

        return $this;
    }

    public function isRecommander(): ?bool
    {
        return $this->recommander;
    }

    public function setRecommander(bool $recommander): self
    {
        $this->recommander = $recommander;

        return $this;
    }

    /**
     * @return Collection<int, Formule>
     */
    public function getFormules(): Collection
    {
        return $this->formules;
    }

    public function addFormule(Formule $formule): self
    {
        if (!$this->formules->contains($formule)) {
            $this->formules->add($formule);
            $formule->setTarification($this);
        }

        return $this;
    }

    public function removeFormule(Formule $formule): self
    {
        if ($this->formules->removeElement($formule)) {
            // set the owning side to null (unless already changed)
            if ($formule->getTarification() === $this) {
                $formule->setTarification(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName() ?? '';
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(?bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}

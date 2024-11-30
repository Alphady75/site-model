<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\EtapeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Etape
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'etapes')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?DossierJuridique $dossierJuridique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'etape', targetEntity: DocumentJuridique::class, cascade: ['persist'])]
    private Collection $documentJuridiques;

    #[ORM\Column]
    private ?int $position = null;

    public function __construct()
    {
        $this->documentJuridiques = new ArrayCollection();
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

    public function getDossierJuridique(): ?DossierJuridique
    {
        return $this->dossierJuridique;
    }

    public function setDossierJuridique(?DossierJuridique $dossierJuridique): self
    {
        $this->dossierJuridique = $dossierJuridique;

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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, DocumentJuridique>
     */
    public function getDocumentJuridiques(): Collection
    {
        return $this->documentJuridiques;
    }

    public function addDocumentJuridique(DocumentJuridique $documentJuridique): self
    {
        if (!$this->documentJuridiques->contains($documentJuridique)) {
            $this->documentJuridiques->add($documentJuridique);
            $documentJuridique->setEtape($this);
        }

        return $this;
    }

    public function removeDocumentJuridique(DocumentJuridique $documentJuridique): self
    {
        if ($this->documentJuridiques->removeElement($documentJuridique)) {
            // set the owning side to null (unless already changed)
            if ($documentJuridique->getEtape() === $this) {
                $documentJuridique->setEtape(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}

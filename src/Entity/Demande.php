<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Demande
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'demandes', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $comptastart = null;

    #[ORM\ManyToOne(inversedBy: 'demandes', cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Service $service = null;

    #[ORM\ManyToOne(inversedBy: 'demandes', cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Tarification $tarification = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomSociete = null;

    #[ORM\ManyToOne(inversedBy: 'demandes', cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Activite $activite = null;

    #[ORM\ManyToOne(inversedBy: 'demandes', cascade: ['persist'])]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Statut $statut = null;

    #[ORM\Column(nullable: true)]
    private ?bool $validate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $payer = null;

    #[ORM\OneToOne(inversedBy: 'demande', cascade: ['persist', 'remove'])]
    private ?DossierJuridique $dossierJuridique = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(nullable: true)]
    private ?bool $completed = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $statutBg = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $demarche = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $redirect = null;

    #[ORM\Column(nullable: true)]
    private ?int $progress = null;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Fiche::class)]
    private Collection $fiches;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Questionnaire::class)]
    private Collection $questionnaires;

    #[ORM\OneToMany(mappedBy: 'demande', targetEntity: Document::class)]
    private Collection $documents;

    public function __construct()
    {
        $this->fiches = new ArrayCollection();
        $this->questionnaires = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isComptaStart(): ?string
    {
        return $this->comptastart;
    }

    public function setComptaStart(?string $comptastart): self
    {
        $this->comptastart = $comptastart;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getTarification(): ?Tarification
    {
        return $this->tarification;
    }

    public function setTarification(?Tarification $tarification): self
    {
        $this->tarification = $tarification;

        return $this;
    }

    public function getNomSociete(): ?string
    {
        return $this->nomSociete;
    }

    public function setNomSociete(?string $nomSociete): self
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

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

    public function isValidate(): ?bool
    {
        return $this->validate;
    }

    public function setValidate(?bool $validate): self
    {
        $this->validate = $validate;

        return $this;
    }

    public function isPayer(): ?bool
    {
        return $this->payer;
    }

    public function setPayer(?bool $payer): self
    {
        $this->payer = $payer;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(?bool $completed): self
    {
        $this->completed = $completed;

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

    public function getDemarche(): ?string
    {
        return $this->demarche;
    }

    public function setDemarche(?string $demarche): self
    {
        $this->demarche = $demarche;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    public function setRedirect(?string $redirect): self
    {
        $this->redirect = $redirect;

        return $this;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }

    public function setProgress(?int $progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * @return Collection<int, Fiche>
     */
    public function getFiches(): Collection
    {
        return $this->fiches;
    }

    public function addFich(Fiche $fich): self
    {
        if (!$this->fiches->contains($fich)) {
            $this->fiches->add($fich);
            $fich->setDemande($this);
        }

        return $this;
    }

    public function removeFich(Fiche $fich): self
    {
        if ($this->fiches->removeElement($fich)) {
            // set the owning side to null (unless already changed)
            if ($fich->getDemande() === $this) {
                $fich->setDemande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Questionnaire>
     */
    public function getQuestionnaires(): Collection
    {
        return $this->questionnaires;
    }

    public function addQuestionnaire(Questionnaire $questionnaire): self
    {
        if (!$this->questionnaires->contains($questionnaire)) {
            $this->questionnaires->add($questionnaire);
            $questionnaire->setDemande($this);
        }

        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self
    {
        if ($this->questionnaires->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getDemande() === $this) {
                $questionnaire->setDemande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setDemande($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getDemande() === $this) {
                $document->setDemande(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }
}

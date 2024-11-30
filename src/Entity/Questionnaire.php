<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\QuestionnaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Questionnaire
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fondateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fondateur2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fondateur3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $denomination = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siegesociale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $objetsocial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $capitalsocial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $partintervale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeraires = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nature = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $industrie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $part = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $president = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prestelephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sectadmin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sectadmintelephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tresorier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tresoriertelephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $civilite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomCommercial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sitmat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $actionnaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $actionnairepart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $actionnaire2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $actionnaire2part = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $actionnaire3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $actionnaire3part = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $modeAdmin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etatCivilNom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commisaireTitulaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commissaireSuppleant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gerantnom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gerantprenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gerantprofession = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $geranttelephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profession = null;

    #[ORM\ManyToOne(inversedBy: 'questionnaires')]
    private ?Demande $demande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFondateur(): ?string
    {
        return $this->fondateur;
    }

    public function setFondateur(?string $fondateur): self
    {
        $this->fondateur = $fondateur;

        return $this;
    }

    public function getFondateur2(): ?string
    {
        return $this->fondateur2;
    }

    public function setFondateur2(?string $fondateur2): self
    {
        $this->fondateur2 = $fondateur2;

        return $this;
    }

    public function getFondateur3(): ?string
    {
        return $this->fondateur3;
    }

    public function setFondateur3(?string $fondateur3): self
    {
        $this->fondateur3 = $fondateur3;

        return $this;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(?string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getSiegesociale(): ?string
    {
        return $this->siegesociale;
    }

    public function setSiegesociale(?string $siegesociale): self
    {
        $this->siegesociale = $siegesociale;

        return $this;
    }

    public function getObjetsocial(): ?string
    {
        return $this->objetsocial;
    }

    public function setObjetsocial(?string $objetsocial): self
    {
        $this->objetsocial = $objetsocial;

        return $this;
    }

    public function getCapitalsocial(): ?string
    {
        return $this->capitalsocial;
    }

    public function setCapitalsocial(?string $capitalsocial): self
    {
        $this->capitalsocial = $capitalsocial;

        return $this;
    }

    public function getPartintervale(): ?string
    {
        return $this->partintervale;
    }

    public function setPartintervale(?string $partintervale): self
    {
        $this->partintervale = $partintervale;

        return $this;
    }

    public function getNumeraires(): ?string
    {
        return $this->numeraires;
    }

    public function setNumeraires(?string $numeraires): self
    {
        $this->numeraires = $numeraires;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(?string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getIndustrie(): ?string
    {
        return $this->industrie;
    }

    public function setIndustrie(?string $industrie): self
    {
        $this->industrie = $industrie;

        return $this;
    }

    public function getPart(): ?string
    {
        return $this->part;
    }

    public function setPart(?string $part): self
    {
        $this->part = $part;

        return $this;
    }

    public function getPresident(): ?string
    {
        return $this->president;
    }

    public function setPresident(?string $president): self
    {
        $this->president = $president;

        return $this;
    }

    public function getPrestelephone(): ?string
    {
        return $this->prestelephone;
    }

    public function setPrestelephone(?string $prestelephone): self
    {
        $this->prestelephone = $prestelephone;

        return $this;
    }

    public function getSectadmin(): ?string
    {
        return $this->sectadmin;
    }

    public function setSectadmin(?string $sectadmin): self
    {
        $this->sectadmin = $sectadmin;

        return $this;
    }

    public function getSectadmintelephone(): ?string
    {
        return $this->sectadmintelephone;
    }

    public function setSectadmintelephone(?string $sectadmintelephone): self
    {
        $this->sectadmintelephone = $sectadmintelephone;

        return $this;
    }

    public function getTresorier(): ?string
    {
        return $this->tresorier;
    }

    public function setTresorier(?string $tresorier): self
    {
        $this->tresorier = $tresorier;

        return $this;
    }

    public function getTresoriertelephone(): ?string
    {
        return $this->tresoriertelephone;
    }

    public function setTresoriertelephone(?string $tresoriertelephone): self
    {
        $this->tresoriertelephone = $tresoriertelephone;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getNomCommercial(): ?string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(?string $nomCommercial): self
    {
        $this->nomCommercial = $nomCommercial;

        return $this;
    }

    public function getSitmat(): ?string
    {
        return $this->sitmat;
    }

    public function setSitmat(?string $sitmat): self
    {
        $this->sitmat = $sitmat;

        return $this;
    }

    public function getActionnaire(): ?string
    {
        return $this->actionnaire;
    }

    public function setActionnaire(?string $actionnaire): self
    {
        $this->actionnaire = $actionnaire;

        return $this;
    }

    public function getActionnairepart(): ?string
    {
        return $this->actionnairepart;
    }

    public function setActionnairepart(?string $actionnairepart): self
    {
        $this->actionnairepart = $actionnairepart;

        return $this;
    }

    public function getActionnaire2(): ?string
    {
        return $this->actionnaire2;
    }

    public function setActionnaire2(?string $actionnaire2): self
    {
        $this->actionnaire2 = $actionnaire2;

        return $this;
    }

    public function getActionnaire2part(): ?string
    {
        return $this->actionnaire2part;
    }

    public function setActionnaire2part(?string $actionnaire2part): self
    {
        $this->actionnaire2part = $actionnaire2part;

        return $this;
    }

    public function getActionnaire3(): ?string
    {
        return $this->actionnaire3;
    }

    public function setActionnaire3(?string $actionnaire3): self
    {
        $this->actionnaire3 = $actionnaire3;

        return $this;
    }

    public function getActionnaire3part(): ?string
    {
        return $this->actionnaire3part;
    }

    public function setActionnaire3part(?string $actionnaire3part): self
    {
        $this->actionnaire3part = $actionnaire3part;

        return $this;
    }

    public function getModeAdmin(): ?string
    {
        return $this->modeAdmin;
    }

    public function setModeAdmin(?string $modeAdmin): self
    {
        $this->modeAdmin = $modeAdmin;

        return $this;
    }

    public function getEtatCivilNom(): ?string
    {
        return $this->etatCivilNom;
    }

    public function setEtatCivilNom(?string $etatCivilNom): self
    {
        $this->etatCivilNom = $etatCivilNom;

        return $this;
    }

    public function getCommisaireTitulaire(): ?string
    {
        return $this->commisaireTitulaire;
    }

    public function setCommisaireTitulaire(?string $commisaireTitulaire): self
    {
        $this->commisaireTitulaire = $commisaireTitulaire;

        return $this;
    }

    public function getCommissaireSuppleant(): ?string
    {
        return $this->commissaireSuppleant;
    }

    public function setCommissaireSuppleant(?string $commissaireSuppleant): self
    {
        $this->commissaireSuppleant = $commissaireSuppleant;

        return $this;
    }

    public function getGerantnom(): ?string
    {
        return $this->gerantnom;
    }

    public function setGerantnom(?string $gerantnom): self
    {
        $this->gerantnom = $gerantnom;

        return $this;
    }

    public function getGerantprenom(): ?string
    {
        return $this->gerantprenom;
    }

    public function setGerantprenom(?string $gerantprenom): self
    {
        $this->gerantprenom = $gerantprenom;

        return $this;
    }

    public function getGerantprofession(): ?string
    {
        return $this->gerantprofession;
    }

    public function setGerantprofession(?string $gerantprofession): self
    {
        $this->gerantprofession = $gerantprofession;

        return $this;
    }

    public function getGeranttelephone(): ?string
    {
        return $this->geranttelephone;
    }

    public function setGeranttelephone(?string $geranttelephone): self
    {
        $this->geranttelephone = $geranttelephone;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\AproposRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AproposRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Apropos
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    /**
     * @var File|null
     **/
    #[Assert\Image(maxSize: '50M', maxSizeMessage: 'Image trop volumineuse maximum 10Mb')]
    #[Assert\Image(mimeTypes: ["image/jpeg", "image/jpg", "image/png", "image/avif"], mimeTypesMessage: "Mauvais format d'image (jpeg, jpg et png)")]
    #[Vich\UploadableField(mapping: 'auteurs', fileNameProperty: 'photo')]
    private $photoFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $presentation = null;

    #[ORM\ManyToOne(inversedBy: 'apropos')]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $online = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $anneeExperience = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fonction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bureau = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $whatsapp = null;

    #[ORM\OneToMany(mappedBy: 'apropos', targetEntity: Communaute::class, cascade: ['persist'])]
    private Collection $communautes;

    /**
     * @var File|null
     **/
    #[Assert\Image(maxSize: '50M', maxSizeMessage: 'Image trop volumineuse maximum 10Mb')]
    #[Assert\Image(mimeTypes: ["image/jpeg", "image/jpg", "image/png", "image/avif"], mimeTypesMessage: "Mauvais format d'image (jpeg, jpg et png)")]
    #[Vich\UploadableField(mapping: 'auteurs', fileNameProperty: 'image')]
    private $imageFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $historique = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $apropos = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motDgOperation = null;

    /**
     * @var File|null
     **/
    #[Assert\Image(maxSize: '50M', maxSizeMessage: 'Image trop volumineuse maximum 10Mb')]
    #[Assert\Image(mimeTypes: ["image/jpeg", "image/jpg", "image/png", "image/avif"], mimeTypesMessage: "Mauvais format d'image (jpeg, jpg et png)")]
    #[Vich\UploadableField(mapping: 'auteurs', fileNameProperty: 'photoDgOperation')]
    private $photoDgOperationFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoDgOperation = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $boitePostal = null;

    /**
     * @var File|null
     **/
    #[Assert\Image(maxSize: '50M', maxSizeMessage: 'Image trop volumineuse maximum 10Mb')]
    #[Assert\Image(mimeTypes: ["image/jpeg", "image/jpg", "image/png", "image/avif"], mimeTypesMessage: "Mauvais format d'image (jpeg, jpg et png)")]
    #[Vich\UploadableField(mapping: 'auteurs', fileNameProperty: 'logo')]
    private $logoFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $objectif = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $responsableName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mots = null;

    #[ORM\OneToMany(mappedBy: 'apropos', targetEntity: Contenu::class, cascade: ['persist'])]
    private Collection $contenus;

    #[ORM\Column(nullable: true)]
    private ?int $donsOfferts = null;

    #[ORM\Column(nullable: true)]
    private ?int $donsRecus = null;

    #[ORM\Column(nullable: true)]
    private ?int $partenariats = null;

    #[ORM\Column(nullable: true)]
    private ?int $projets = null;

    public function __construct()
    {
        $this->communautes = new ArrayCollection();
        $this->contenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $photoFile
     */
    public function setPhotoFile(?File $photoFile = null): void
    {
        $this->photoFile = $photoFile;

        if (null !== $photoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $photoDgOperationFile
     */
    public function setPhotoDgOperationFile(?File $photoDgOperationFile = null): void
    {
        $this->photoDgOperationFile = $photoDgOperationFile;

        if (null !== $photoDgOperationFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getPhotoDgOperationFile(): ?File
    {
        return $this->photoDgOperationFile;
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

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getAnneeExperience(): ?string
    {
        return $this->anneeExperience;
    }

    public function setAnneeExperience(?string $anneeExperience): self
    {
        $this->anneeExperience = $anneeExperience;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getBureau(): ?string
    {
        return $this->bureau;
    }

    public function setBureau(?string $bureau): self
    {
        $this->bureau = $bureau;

        return $this;
    }

    public function getWhatsapp(): ?string
    {
        return $this->whatsapp;
    }

    public function setWhatsapp(?string $whatsapp): self
    {
        $this->whatsapp = $whatsapp;

        return $this;
    }

    /**
     * @return Collection<int, Communaute>
     */
    public function getCommunautes(): Collection
    {
        return $this->communautes;
    }

    public function addCommunaute(Communaute $communaute): self
    {
        if (!$this->communautes->contains($communaute)) {
            $this->communautes->add($communaute);
            $communaute->setApropos($this);
        }

        return $this;
    }

    public function removeCommunaute(Communaute $communaute): self
    {
        if ($this->communautes->removeElement($communaute)) {
            // set the owning side to null (unless already changed)
            if ($communaute->getApropos() === $this) {
                $communaute->setApropos(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getHistorique(): ?string
    {
        return $this->historique;
    }

    public function setHistorique(?string $historique): self
    {
        $this->historique = $historique;

        return $this;
    }

    public function getApropos(): ?string
    {
        return $this->apropos;
    }

    public function setApropos(?string $apropos): self
    {
        $this->apropos = $apropos;

        return $this;
    }

    public function getMotDgOperation(): ?string
    {
        return $this->motDgOperation;
    }

    public function setMotDgOperation(?string $motDgOperation): self
    {
        $this->motDgOperation = $motDgOperation;

        return $this;
    }

    public function getPhotoDgOperation(): ?string
    {
        return $this->photoDgOperation;
    }

    public function setPhotoDgOperation(?string $photoDgOperation): self
    {
        $this->photoDgOperation = $photoDgOperation;

        return $this;
    }

    public function getBoitePostal(): ?string
    {
        return $this->boitePostal;
    }

    public function setBoitePostal(?string $boitePostal): self
    {
        $this->boitePostal = $boitePostal;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $logoFile
     */
    public function setLogoFile(?File $logoFile = null): void
    {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(?string $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
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

    public function getResponsableName(): ?string
    {
        return $this->responsableName;
    }

    public function setResponsableName(?string $responsableName): self
    {
        $this->responsableName = $responsableName;

        return $this;
    }

    public function getMots(): ?string
    {
        return $this->mots;
    }

    public function setMots(?string $mots): self
    {
        $this->mots = $mots;

        return $this;
    }

    /**
     * @return Collection<int, Contenu>
     */
    public function getContenus(): Collection
    {
        return $this->contenus;
    }

    public function addContenu(Contenu $contenu): self
    {
        if (!$this->contenus->contains($contenu)) {
            $this->contenus->add($contenu);
            $contenu->setApropos($this);
        }

        return $this;
    }

    public function removeContenu(Contenu $contenu): self
    {
        if ($this->contenus->removeElement($contenu)) {
            // set the owning side to null (unless already changed)
            if ($contenu->getApropos() === $this) {
                $contenu->setApropos(null);
            }
        }

        return $this;
    }

    public function getDonsOfferts(): ?int
    {
        return $this->donsOfferts;
    }

    public function setDonsOfferts(?int $donsOfferts): self
    {
        $this->donsOfferts = $donsOfferts;

        return $this;
    }

    public function getDonsRecus(): ?int
    {
        return $this->donsRecus;
    }

    public function setDonsRecus(?int $donsRecus): self
    {
        $this->donsRecus = $donsRecus;

        return $this;
    }

    public function getPartenariats(): ?int
    {
        return $this->partenariats;
    }

    public function setPartenariats(?int $partenariats): self
    {
        $this->partenariats = $partenariats;

        return $this;
    }

    public function getProjets(): ?int
    {
        return $this->projets;
    }

    public function setProjets(?int $projets): self
    {
        $this->projets = $projets;

        return $this;
    }
}

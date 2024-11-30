<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\FicheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FicheRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Fiche
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationalite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profession = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sitMat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $regimeMat = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $civilite = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $typePiece = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numPiece = null;

    /**
     * @var File|null
     **/
    #[Assert\Image(maxSize: '50M', maxSizeMessage: 'Image trop volumineuse maximum 10Mb')]
    #[Assert\Image(mimeTypes: ["image/jpeg", "image/jpg", "image/png", "image/avif"], mimeTypesMessage: "Mauvais format d'image (jpeg, jpg et png)")]
    #[Vich\UploadableField(mapping: 'pieces', fileNameProperty: 'pieceRecto')]
    private $rectoFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pieceRecto = null;

    /**
     * @var File|null
     **/
    #[Assert\Image(maxSize: '50M', maxSizeMessage: 'Image trop volumineuse maximum 10Mb')]
    #[Assert\Image(mimeTypes: ["image/jpeg", "image/jpg", "image/png", "image/avif"], mimeTypesMessage: "Mauvais format d'image (jpeg, jpg et png)")]
    #[Vich\UploadableField(mapping: 'pieces', fileNameProperty: 'pieceVerso')]
    private $versoFile;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pieceVerso = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $pieceDelivre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateLettre = null;

    #[ORM\ManyToOne(inversedBy: 'fiches')]
    private ?Demande $demande = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): self
    {
        $this->nationalite = $nationalite;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getSitMat(): ?string
    {
        return $this->sitMat;
    }

    public function setSitMat(?string $sitMat): self
    {
        $this->sitMat = $sitMat;

        return $this;
    }

    public function getRegimeMat(): ?string
    {
        return $this->regimeMat;
    }

    public function setRegimeMat(?string $regimeMat): self
    {
        $this->regimeMat = $regimeMat;

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

    public function getTypePiece(): ?string
    {
        return $this->typePiece;
    }

    public function setTypePiece(?string $typePiece): self
    {
        $this->typePiece = $typePiece;

        return $this;
    }

    public function getNumPiece(): ?string
    {
        return $this->numPiece;
    }

    public function setNumPiece(?string $numPiece): self
    {
        $this->numPiece = $numPiece;

        return $this;
    }

    public function getPieceRecto(): ?string
    {
        return $this->pieceRecto;
    }

    public function setPieceRecto(?string $pieceRecto): self
    {
        $this->pieceRecto = $pieceRecto;

        return $this;
    }

    public function getPieceVerso(): ?string
    {
        return $this->pieceVerso;
    }

    public function setPieceVerso(?string $pieceVerso): self
    {
        $this->pieceVerso = $pieceVerso;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $rectoFile
     */
    public function setRectoFile(?File $rectoFile = null): void
    {
        $this->rectoFile = $rectoFile;

        if (null !== $rectoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getRectoFile(): ?File
    {
        return $this->rectoFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $versoFile
     */
    public function setVersoFile(?File $versoFile = null): void
    {
        $this->versoFile = $versoFile;

        if (null !== $versoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getVersoFile(): ?File
    {
        return $this->versoFile;
    }

    public function getPieceDelivre(): ?\DateTimeInterface
    {
        return $this->pieceDelivre;
    }

    public function setPieceDelivre(?\DateTimeInterface $pieceDelivre): self
    {
        $this->pieceDelivre = $pieceDelivre;

        return $this;
    }

    public function getDateLettre(): ?string
    {
        return $this->dateLettre;
    }

    public function setDateLettre(?string $dateLettre): self
    {
        $this->dateLettre = $dateLettre;

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

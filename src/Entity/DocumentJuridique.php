<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\DocumentJuridiqueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DocumentJuridiqueRepository::class)]
#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
class DocumentJuridique
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var File|null
     **/
    #[Assert\Image(maxSize: '50M', maxSizeMessage: 'Fichier trop volumineux maximum 50Mb')]
    #[Vich\UploadableField(mapping: 'documents', fileNameProperty: 'document')]
    private $documentFile;

    #[ORM\Column(length: 255)]
    private ?string $document = null;

    #[ORM\ManyToOne(inversedBy: 'documentJuridiques')]
    private ?Etape $etape = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(string $document): self
    {
        $this->document = $document;

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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $documentFile
     */
    public function setDocumentFile(?File $documentFile = null): void
    {
        $this->documentFile = $documentFile;

        if (null !== $documentFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getDocumentFile(): ?File
    {
        return $this->documentFile;
    }

    public function getEtape(): ?Etape
    {
        return $this->etape;
    }

    public function setEtape(?Etape $etape): self
    {
        $this->etape = $etape;

        return $this;
    }
}

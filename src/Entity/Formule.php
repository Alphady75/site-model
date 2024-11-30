<?php

namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\FormuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: FormuleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Formule
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'formules')]
    #[JoinColumn(onDelete:'CASCADE')]
    private ?Tarification $tarification = null;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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

    public function __toString()
    {
        return $this->getName();
    }
}

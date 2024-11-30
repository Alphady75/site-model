<?php

namespace App\Twig\Runtime;

use App\Repository\ActiviteRepository;
use App\Repository\AproposRepository;
use App\Repository\MembreRepository;
use App\Repository\PartenaireRepository;
use App\Repository\ServiceRepository;
use App\Repository\StatutRepository;
use App\Repository\TarificationRepository;
use App\Repository\TemoignageRepository;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private AproposRepository $aproposRepository,
        private ServiceRepository $serviceRepository,
        private MembreRepository $membreRepository,
        private PartenaireRepository $partenaireRepository,
        private ActiviteRepository $activiteRepository,
        private TarificationRepository $tarificationRepository,
        private TemoignageRepository $temoignageRepository,
        private StatutRepository $statutRepository
    ) {
        // Inject dependencies if needed
    }

    public function getApropos()
    {
        return $this->aproposRepository->findOneBy(['online' => true]);
    }

    public function getServices(int $limit = null)
    {
        return $this->serviceRepository->findBy(['online' => true], ['name' => 'ASC'], $limit);
    }

    public function getTemoignages(int $limit = null)
    {
        return $this->temoignageRepository->findBy(['online' => true], ['created' => 'DESC'], $limit);
    }

    public function getMembres()
    {
        return $this->membreRepository->findBy(['online' => true], ['created' => 'DESC']);
    }

    public function getPartenaires()
    {
        return $this->partenaireRepository->findBy(['online' => true], ['name' => 'DESC']);
    }

    public function getTarifications()
    {
        return $this->tarificationRepository->findBy(['online' => true], ['name' => 'ASC']);
    }

    public function getActivites()
    {
        return $this->activiteRepository->findBy([], ['name' => 'DESC']);
    }

    public function getStatuts()
    {
        return $this->statutRepository->findBy([], ['name' => 'DESC']);
    }

    public function getTarificationByStatut($statut)
    {
        return $this->tarificationRepository->findBy(['statut' => $statut], ['name' => 'DESC']);
    }
}

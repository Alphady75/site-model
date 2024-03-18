<?php

namespace App\Twig\Runtime;

use App\Repository\AproposRepository;
use App\Repository\CategorieRepository;
use App\Repository\MembreRepository;
use App\Repository\ProjetRepository;
use App\Repository\ServiceRepository;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private AproposRepository $aproposRepository,
        private ServiceRepository $serviceRepository,
        private CategorieRepository $categorieRepository,
        private ProjetRepository $projetRepository,
        private MembreRepository $membreRepository
    ) {
        // Inject dependencies if needed
    }

    public function getApropos()
    {
        return $this->aproposRepository->findOneBy(['online' => true]);
    }

    public function getServices()
    {
        return $this->serviceRepository->findBy(['online' => true], ['position' => 'ASC']);
    }

    public function getCategories()
    {
        return $this->categorieRepository->findAll();
    }

    public function getProjets()
    {
        return $this->projetRepository->findBy(['online' => true], ['created' => 'DESC']);
    }

    public function getMembres()
    {
        return $this->membreRepository->findBy(['online' => true], ['created' => 'DESC']);
    }
}

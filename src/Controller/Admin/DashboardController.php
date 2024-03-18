<?php

namespace App\Controller\Admin;

use App\Repository\ActualiteRepository;
use App\Repository\ArchitectureRepository;
use App\Repository\CategorieRepository;
use App\Repository\MembreRepository;
use App\Repository\ProjetRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(
        private ActualiteRepository $actualiteRepository,
        private ServiceRepository $serviceRepository,
        private ProjetRepository $projetRepository,
        private MembreRepository $membreRepository,
        private ArchitectureRepository $architectureRepository,
    )
    {
        
    }

    #[Route('/admin/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'services' => count($this->serviceRepository->findAll()),
            'membres' => count($this->membreRepository->findAll()),
            'projets' => count($this->projetRepository->findAll()),
            'actualites' => count($this->actualiteRepository->findAll()),
            'architectures' => count($this->architectureRepository->findAll()),
        ]);
    }
}

<?php

namespace App\Controller\Admin;

use App\Repository\MembreRepository;
use App\Repository\PartenaireRepository;
use App\Repository\ServiceRepository;
use App\Repository\TemoignageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(
        private ServiceRepository $serviceRepository,
        private MembreRepository $membreRepository,
        private TemoignageRepository $temoignageRepository,
        private PartenaireRepository $partenaireRepository,
        private UserRepository $userRepository,
    ) {
    }

    #[Route('/moderation/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'services' => count($this->serviceRepository->findAll()),
            'membres' => count($this->membreRepository->findAll()),
            'temoignages' => count($this->temoignageRepository->findAll()),
            'partenaires' => count($this->partenaireRepository->findAll()),
            'users' => count($this->userRepository->findAll()),
        ]);
    }
}

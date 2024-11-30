<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use App\Repository\PartenaireRepository;
use App\Repository\TemoignageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AproposController extends AbstractController
{
    #[Route('/apropos', name: 'apropos')]
    public function index(
        MembreRepository $membreRepository,
        TemoignageRepository $temoignageRepository,
        PartenaireRepository $partenaireRepository,
    ): Response {

        $membres = $membreRepository->findBy(['online' => true], [], 20);
        $temoignages = $temoignageRepository->findBy(['online' => true], [], 20);
        $partenaires = $partenaireRepository->findBy(['online' => true], [], 20);

        return $this->render('apropos/index.html.twig', [
            'membres' => $membres,
            'temoignages' => $temoignages,
            'partenaires' => $partenaires,
        ]);
    }
}

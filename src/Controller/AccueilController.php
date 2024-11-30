<?php

namespace App\Controller;

use App\Repository\ActualiteRepository;
use App\Repository\MembreRepository;
use App\Repository\PartenaireRepository;
use App\Repository\ServiceRepository;
use App\Repository\TemoignageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil', methods: ['POST', 'GET'])]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
        ]);
    }
}

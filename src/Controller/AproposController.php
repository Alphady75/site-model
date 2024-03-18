<?php

namespace App\Controller;

use App\Repository\AproposRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AproposController extends AbstractController
{
    #[Route('/apropos', name: 'apropos')]
    public function index(AproposRepository $aproposRepository): Response
    {
        return $this->render('apropos/index.html.twig', [
            'apropo' => $aproposRepository->findOneBy(['online' => true]),
        ]);
    }
}

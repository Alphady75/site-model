<?php

namespace App\Controller;

use App\Repository\ArchitectureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/architectures')]
class ArchitectureController extends AbstractController
{
    #[Route('/', name: 'architectures')]
    public function index(ArchitectureRepository $architectureRepository): Response
    {
        return $this->render('architecture/index.html.twig', [
            'architectures' => $architectureRepository->findBy(['online' => true], ['id' => 'DESC']),
        ]);
    }
}

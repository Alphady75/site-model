<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Repository\ActualiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'blog')]
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'actualites' => $actualiteRepository->findBy(['online' => true], ['created' => 'DESC']),
        ]);
    }

    #[Route('/{slug}', name: 'blog_details')]
    public function details(Actualite $actualite): Response
    {
        return $this->render('blog/details.html.twig', [
            'actualite' => $actualite,
        ]);
    }
}

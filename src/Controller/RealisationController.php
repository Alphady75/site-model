<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Projet;
use App\Repository\CategorieRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nos-realisations')]
class RealisationController extends AbstractController
{
    #[Route('/', name: 'realisations')]
    public function index(CategorieRepository $categorieRepository, ProjetRepository $projetRepository): Response
    {
        return $this->render('realisation/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'projets' => $projetRepository->findBy(['online' => true], ['created' => 'DESC']),
        ]);
    }

    #[Route('/categorie/{slug}', name: 'realisations_categorie')]
    public function categorie(
        Categorie $categorie,
        CategorieRepository $categorieRepository,
        ProjetRepository $projetRepository
    ): Response {

        $projets = $projetRepository->findBy(['categorie' => $categorie, 'online' => true], ['created' => 'DESC']);
        $categories = $categorieRepository->findAll();

        return $this->render('realisation/categorie.html.twig', [
            'categorie' => $categorie,
            'categories' => $categories,
            'projets' => $projets,
        ]);
    }

    #[Route('/{slug}', name: 'realisations_details')]
    public function details(Projet $projet, ProjetRepository $projetRepository): Response
    {
        
        $similars = $projetRepository->findBy(['domaine' => $projet->getCategorie(), 'online' => true], ['created' => 'DESC']);

        return $this->render('realisation/details.html.twig', [
            'projet' => $projet,
            'similars' => $similars,
        ]);
    }
}

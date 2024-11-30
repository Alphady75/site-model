<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pages')]
class PagesController extends AbstractController
{
    #[Route('/condition-generale-utilisation', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('pages/cgu.html.twig', [
        ]);
    }

    #[Route('/politiques', name: 'politiques')]
    public function politiques(): Response
    {
        return $this->render('pages/politiques.html.twig', [
        ]);
    }

    #[Route('/mentions-legales', name: 'mentions')]
    public function mentions(): Response
    {
        return $this->render('pages/mentions.html.twig', [
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/services')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'services')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findBy(['online' => true], ['position' => 'ASC']),
        ]);
    }

    #[Route('/{slug}', name: 'services_details')]
    public function details(Service $service): Response
    {
        return $this->render('service/details.html.twig', [
            'service' => $service,
        ]);
    }
}

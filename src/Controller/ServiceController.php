<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/services')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'services')]
    public function index(
        ServiceRepository $serviceRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $services = $paginator->paginate(
            $serviceRepository->findBy(['online' => true], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('service/index.html.twig', [
            'services' => $services,
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

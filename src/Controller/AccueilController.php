<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\AproposRepository;
use App\Repository\ProjetRepository;
use App\Repository\ServiceRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil', methods: ['POST', 'GET'])]
    public function index(
        AproposRepository $aproposRepository,
        Request $request,
        MailerService $mailer,
        ProjetRepository $projetRepository,
        ServiceRepository $serviceRepository
    ): Response 
    {
        $form = $this->createForm(ContactType::class, [], [
            'local' => $request->getLocale()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mailer->sendDevisNotification(
                $form->get('nom')->getData(),
                $form->get('email')->getData(),
                $form->get('sujet')->getData(),
                $form->get('message')->getData(),
            );

            $this->addFlash('success', "Votre message a bien été envoyer, vous aurez un retour dans un délais treès cours");

            return $this->redirectToRoute('accueil');
        }

        $projets = $projetRepository->findBy(['online' => true], ['created' => 'DESC'], 4);

        return $this->render('accueil/index.html.twig', [
            'apropo' => $aproposRepository->findOneBy(['online' => true]),
            'form' => $form->createView(),
            'projets' => $projets,
            'services' => $serviceRepository->findBy(['online' => true], ['position' => 'ASC']),
        ]);
    }
}

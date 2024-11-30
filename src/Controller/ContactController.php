<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\AproposRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(AproposRepository $aproposRepository, Request $request, MailerService $mailer): Response
    {
        $form = $this->createForm(ContactType::class, [], [
            'local' => $request->getLocale()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /*$mailer->sendDevisNotification(
                $form->get('nom')->getData(),
                $form->get('email')->getData(),
                $form->get('sujet')->getData(),
                $form->get('message')->getData(),
            );*/

            $this->addFlash('success', "Votre message a bien été envoyer, vous aurez un retour dans un délais treès cours");
        }

        return $this->render('contact/index.html.twig', [
            'apropo' => $aproposRepository->findOneBy(['online' => true]),
            'form' => $form->createView(),
        ]);
    }
}

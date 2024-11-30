<?php

namespace App\Controller\User;

use App\Form\User\AideType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/besoin-aides')]
class AideController extends AbstractController
{
    #[Route('/', name: 'user_aide', methods: ['GET', 'POST'])]
    public function aides(Request $request, MailerService $mailerService): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AideType::class, null, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            # send mail to admin
            $mailerService->sendAideMessage(
                "Nouveau message reçu via le site",
                $user,
                $form->get('sujet')->getData(),
                $form->get('demarche')->getData(),
                $form->get('message')->getData(),
                'admin'
            );
            # send mail to user
            $mailerService->sendAideMessage(
                "Merci de nous avoir contactés !",
                $user,
                $form->get('sujet')->getData(),
                $form->get('demarche')->getData(),
                $form->get('message')->getData(),
                'user'
            );
            $this->addFlash('success', "Votre message a bien été envoyer");
            return $this->redirectToRoute('user_aide');
        }

        return $this->render('user/aide/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

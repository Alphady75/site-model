<?php

namespace App\Controller\User;

use App\Form\ChangePasswordFormType;
use App\Form\User\CompteType;
use App\Repository\CommandeRepository;
use App\Repository\DemandeRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;

#[Route('/espace-client')]
class EspaceController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private $appName;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CommandeRepository $commandeRepository,
        private DemandeRepository $venteRepository,
        private MailerService $mailer
    ) {
        $this->appName = $_ENV['SITE_NAME'];
    }

    #[Route('/', name: 'espace_client')]
    public function dashboard(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('user/espace/dashboard.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/mon-compte', name: 'compte', methods: ['POST', 'GET'])]
    public function editionCompte(Request $request): Response
    {
        /** @var User */
        $user = $this->getUser();

        $form = $this->createForm(CompteType::class, $user, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
            $this->addFlash('success', "Votre compte a bien été mis à jour");

            return $this->redirectToRoute('compte');
        }

        return $this->render('user/espace/compte.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/mes-acces', name: 'acces')]
    public function acces(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.

            // Encode(hash) the plain password, and set it.
            $encodedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->entityManager->flush();

            // The session is cleaned up after the password has been changed.
            $this->cleanSessionAfterReset();

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('user/espace/acces.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

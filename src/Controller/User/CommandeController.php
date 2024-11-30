<?php

namespace App\Controller\User;

use App\Entity\Demande;
use App\Repository\CommandeRepository;
use App\Repository\DemandeRepository;
use App\Service\SessionService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/commandes')]
class CommandeController extends AbstractController
{
    public function __construct(
        private CommandeRepository $commandeRepository,
        private DemandeRepository $demandeRepository
    ) {}

    #[Route('/', name: 'user_commandes')]
    public function commandes(
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $commandes = $paginator->paginate(
            $this->commandeRepository->findBy(['user' => $this->getUser()], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('user/commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/annuler', name: 'user_commandes_annuler')]
    public function annuler(SessionService $sessionService): Response
    {

        return $this->render('user/commande/annuler.html.twig', [
            'demande' => $sessionService->getDemandeFromDataBase(),
            'etape' => "commande",
        ]);
    }

    #[Route('/success', name: 'user_commandes_success')]
    public function success(Request $request): Response
    {
        $token = $request->get('token');
        $commande = $this->commandeRepository->findOneBy(['token' => $token]);
        if (!$commande)
            return $this->redirectToRoute('user_commandes');

        $demande = $this->demandeRepository->find($commande->getDemarche());

        return $this->render('user/commande/success.html.twig', [
            'demande' => $demande,
            'commande' => $commande,
            'etape' => "commande",
        ]);
    }

    #[Route('/payer/{id}', name: 'user_demande_payer', methods: ['POST'])]
    public function payer(Request $request, Demande $demande, SessionService $sessionService): Response
    {
        if ($this->isCsrfTokenValid('payer' . $demande->getId(), $request->request->get('_token'))) {
            $sessionService->setDemande($demande);
            return $this->redirectToRoute('demande_formules');
        }

        return $this->redirectToRoute('user_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}

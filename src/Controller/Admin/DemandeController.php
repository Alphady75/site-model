<?php

namespace App\Controller\Admin;

use App\Entity\Demande;
use App\Entity\Dto\Demande as DtoDemande;
use App\Form\Demande1Type;
use App\Form\Dto\DemandeType;
use App\Repository\DemandeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/demarches')]
class DemandeController extends AbstractController
{
    public function __construct(private PaginatorInterface $paginator) {}

    #[Route('/', name: 'admin_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository, Request $request): Response
    {
        $search = new DtoDemande();
        $search->page = $request->get('page', 1);
        $form = $this->createForm(DemandeType::class, $search);
        $form->handleRequest($request);
        $demandes = $demandeRepository->adminSearch($search);

        return $this->render('admin/demande/index.html.twig', [
            'demandes' => $demandes,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('admin/demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    #[Route('/{id}', name: 'admin_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token'))) {
            $demandeRepository->remove($demande, true);
        }

        return $this->redirectToRoute('admin_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}

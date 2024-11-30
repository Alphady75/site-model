<?php

namespace App\Controller\Admin;

use App\Entity\Etape;
use App\Form\Admin\EtapeType;
use App\Repository\EtapeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/etapes')]
class EtapeController extends AbstractController
{
    #[Route('/{id}/edit', name: 'admin_etape_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etape $etape, EtapeRepository $etapeRepository): Response
    {
        $demande = $etape->getDossierJuridique()->getDemande();
        $form = $this->createForm(EtapeType::class, $etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etapeName = $form->get('name')->getData();
            if ($etapeRepository->findOneBy([
                'name' => $etapeName,
                'dossierJuridique' => $etape->getDossierJuridique()
            ]) == null) {
                $etapeRepository->save($etape, true);
                $this->addFlash("success", "Le dossier juridique est " . $etapeName);
                return $this->redirectToRoute('demande_dossier_juridique', ['id' => $demande->getId()]);
            } else {
                $this->addFlash("danger", "Le dossier juridique est déjà " . $etapeName);
            }

            return $this->redirectToRoute('demande_dossier_juridique', ['id' => $demande->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/etape/edit.html.twig', [
            'etape' => $etape,
            'demande' => $demande,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_etape_delete', methods: ['POST'])]
    public function delete(Request $request, Etape $etape, EtapeRepository $etapeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $etape->getId(), $request->request->get('_token'))) {
            $etapeRepository->remove($etape, true);
        }

        return $this->redirectToRoute('app_admin_etape_index', [], Response::HTTP_SEE_OTHER);
    }
}

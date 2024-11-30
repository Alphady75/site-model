<?php

namespace App\Controller\User;

use App\Entity\Demande;
use App\Entity\DossierJuridique;
use App\Form\Admin\DossierJuridiqueType;
use App\Repository\DossierJuridiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/dossier-juridique')]
class DossierJuridiqueController extends AbstractController
{
    #[Route('/{id}', name: 'dossier_juridique', methods: ['GET'])]
    public function dossierJuridique(Demande $demande): Response
    {
        return $this->render('user/dossier_juridique/index.html.twig', [
            'demande' => $demande,
            'etape' => 'dossier',
        ]);
    }

    #[Route('/new', name: 'dossier_juridique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DossierJuridiqueRepository $dossierJuridiqueRepository): Response
    {
        $dossierJuridique = new DossierJuridique();
        $form = $this->createForm(DossierJuridiqueType::class, $dossierJuridique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossierJuridiqueRepository->save($dossierJuridique, true);

            return $this->redirectToRoute('dossier_juridique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/dossier_juridique/new.html.twig', [
            'dossier_juridique' => $dossierJuridique,
            'form' => $form,
        ]);
    }

    #[Route('/details/{id}', name: 'dossier_juridique_show', methods: ['GET'])]
    public function show(DossierJuridique $dossierJuridique): Response
    {
        return $this->render('user/dossier_juridique/show.html.twig', [
            'dossier_juridique' => $dossierJuridique,
        ]);
    }

    #[Route('/edite/{id}', name: 'dossier_juridique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DossierJuridique $dossierJuridique, DossierJuridiqueRepository $dossierJuridiqueRepository): Response
    {
        $form = $this->createForm(DossierJuridiqueType::class, $dossierJuridique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dossierJuridiqueRepository->save($dossierJuridique, true);

            return $this->redirectToRoute('dossier_juridique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/dossier_juridique/edit.html.twig', [
            'dossier_juridique' => $dossierJuridique,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'dossier_juridique_delete', methods: ['POST'])]
    public function delete(Request $request, DossierJuridique $dossierJuridique, DossierJuridiqueRepository $dossierJuridiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dossierJuridique->getId(), $request->request->get('_token'))) {
            $dossierJuridiqueRepository->remove($dossierJuridique, true);
        }

        return $this->redirectToRoute('dossier_juridique_index', [], Response::HTTP_SEE_OTHER);
    }
}

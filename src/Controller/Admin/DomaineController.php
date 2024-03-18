<?php

namespace App\Controller\Admin;

use App\Entity\Domaine;
use App\Form\DomaineType;
use App\Repository\DomaineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/domaine')]
class DomaineController extends AbstractController
{
    #[Route('/', name: 'domaine_index', methods: ['GET', 'POST'])]
    public function index(DomaineRepository $domaineRepository, Request $request): Response
    {
        $domaine = new Domaine();
        $form = $this->createForm(DomaineType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domaineRepository->save($domaine, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('domaine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/domaine/index.html.twig', [
            'domaines' => $domaineRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'domaine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DomaineRepository $domaineRepository): Response
    {
        $domaine = new Domaine();
        $form = $this->createForm(DomaineType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domaineRepository->save($domaine, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('domaine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/domaine/new.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'domaine_show', methods: ['GET'])]
    public function show(Domaine $domaine): Response
    {
        return $this->render('admin/domaine/show.html.twig', [
            'domaine' => $domaine,
        ]);
    }

    #[Route('/{id}/edit', name: 'domaine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Domaine $domaine, DomaineRepository $domaineRepository): Response
    {
        $form = $this->createForm(DomaineType::class, $domaine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $domaineRepository->save($domaine, true);
            $this->addFlash('success', 'Le contenu a bien été mis à jour');
            return $this->redirectToRoute('domaine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/domaine/edit.html.twig', [
            'domaine' => $domaine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'domaine_delete', methods: ['POST'])]
    public function delete(Request $request, Domaine $domaine, DomaineRepository $domaineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domaine->getId(), $request->request->get('_token'))) {
            $domaineRepository->remove($domaine, true);
            $this->addFlash('success', 'Le contenu a bien été supprimer');
        }

        return $this->redirectToRoute('domaine_index', [], Response::HTTP_SEE_OTHER);
    }
}

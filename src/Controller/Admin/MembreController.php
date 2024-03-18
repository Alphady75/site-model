<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/membre')]
class MembreController extends AbstractController
{
    #[Route('/', name: 'membre_index', methods: ['GET'])]
    public function index(MembreRepository $membreRepository): Response
    {
        return $this->render('admin/membre/index.html.twig', [
            'membres' => $membreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'membre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MembreRepository $membreRepository): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membreRepository->save($membre, true);

            return $this->redirectToRoute('membre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/membre/new.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'membre_show', methods: ['GET'])]
    public function show(Membre $membre): Response
    {
        return $this->render('admin/membre/show.html.twig', [
            'membre' => $membre,
        ]);
    }

    #[Route('/{id}/edit', name: 'membre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Membre $membre, MembreRepository $membreRepository): Response
    {
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $membreRepository->save($membre, true);

            return $this->redirectToRoute('membre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/membre/edit.html.twig', [
            'membre' => $membre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'membre_delete', methods: ['POST'])]
    public function delete(Request $request, Membre $membre, MembreRepository $membreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getId(), $request->request->get('_token'))) {
            $membreRepository->remove($membre, true);
        }

        return $this->redirectToRoute('membre_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Architecture;
use App\Form\ArchitectureType;
use App\Repository\ArchitectureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/architecture')]
class ArchitectureController extends AbstractController
{
    #[Route('/', name: 'architecture_index', methods: ['GET'])]
    public function index(ArchitectureRepository $architectureRepository): Response
    {
        return $this->render('admin/architecture/index.html.twig', [
            'architectures' => $architectureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'architecture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArchitectureRepository $architectureRepository): Response
    {
        $architecture = new Architecture();
        $form = $this->createForm(ArchitectureType::class, $architecture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $architectureRepository->save($architecture, true);

            return $this->redirectToRoute('architecture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/architecture/new.html.twig', [
            'architecture' => $architecture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'architecture_show', methods: ['GET'])]
    public function show(Architecture $architecture): Response
    {
        return $this->render('admin/architecture/show.html.twig', [
            'architecture' => $architecture,
        ]);
    }

    #[Route('/{id}/edit', name: 'architecture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Architecture $architecture, ArchitectureRepository $architectureRepository): Response
    {
        $form = $this->createForm(ArchitectureType::class, $architecture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $architectureRepository->save($architecture, true);

            return $this->redirectToRoute('architecture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/architecture/edit.html.twig', [
            'architecture' => $architecture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'architecture_delete', methods: ['POST'])]
    public function delete(Request $request, Architecture $architecture, ArchitectureRepository $architectureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$architecture->getId(), $request->request->get('_token'))) {
            $architectureRepository->remove($architecture, true);
        }

        return $this->redirectToRoute('architecture_index', [], Response::HTTP_SEE_OTHER);
    }
}

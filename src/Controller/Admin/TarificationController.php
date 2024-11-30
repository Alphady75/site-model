<?php

namespace App\Controller\Admin;

use App\Entity\Tarification;
use App\Form\Admin\TarificationType;
use App\Repository\TarificationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tarifications')]
class TarificationController extends AbstractController
{
    #[Route('/', name: 'tarification_index', methods: ['GET', 'POST'])]
    public function index(TarificationRepository $tarificationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $tarification = new Tarification();
        $form = $this->createForm(TarificationType::class, $tarification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tarificationRepository->save($tarification, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('tarification_index', [], Response::HTTP_SEE_OTHER);
        }

        $tarifications = $paginator->paginate(
            $tarificationRepository->findBy([], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/tarification/index.html.twig', [
            'tarifications' => $tarifications,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'tarification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TarificationRepository $tarificationRepository): Response
    {
        $tarification = new Tarification();
        $form = $this->createForm(TarificationType::class, $tarification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarificationRepository->save($tarification, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('tarification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tarification/new.html.twig', [
            'tarification' => $tarification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tarification_show', methods: ['GET'])]
    public function show(Tarification $tarification): Response
    {
        return $this->render('admin/tarification/show.html.twig', [
            'tarification' => $tarification,
        ]);
    }

    #[Route('/{id}/edit', name: 'tarification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tarification $tarification, TarificationRepository $tarificationRepository): Response
    {
        $form = $this->createForm(TarificationType::class, $tarification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarificationRepository->save($tarification, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('tarification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/tarification/edit.html.twig', [
            'tarification' => $tarification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'tarification_delete', methods: ['POST'])]
    public function delete(Request $request, Tarification $tarification, TarificationRepository $tarificationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tarification->getId(), $request->request->get('_token'))) {
            $tarificationRepository->remove($tarification, true);
        }

        return $this->redirectToRoute('tarification_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Statut;
use App\Form\Admin\StatutType;
use App\Repository\StatutRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/statut-entreprise')]
class StatutController extends AbstractController
{
    public function __construct(private PaginatorInterface $paginator)
    {
    }

    #[Route('/', name: 'statut_index', methods: ['GET', 'POST'])]
    public function index(StatutRepository $statutRepository, Request $request): Response
    {
        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutRepository->save($statut, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('statut_index', [], Response::HTTP_SEE_OTHER);
        }

        $statuts = $this->paginator->paginate(
            $statutRepository->findBy([], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/statut/index.html.twig', [
            'statuts' => $statuts,
            'statut' => $statut,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'statut_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StatutRepository $statutRepository): Response
    {
        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statutRepository->save($statut, true);

            return $this->redirectToRoute('statut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/statut/new.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'statut_show', methods: ['GET'])]
    public function show(Statut $statut): Response
    {
        return $this->render('admin/statut/show.html.twig', [
            'statut' => $statut,
        ]);
    }

    #[Route('/{id}/edit', name: 'statut_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statut $statut, StatutRepository $statutRepository): Response
    {
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            $statutRepository->save($statut, true);

            return $this->redirectToRoute('statut_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/statut/edit.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'statut_delete', methods: ['POST'])]
    public function delete(Request $request, Statut $statut, StatutRepository $statutRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $statut->getId(), $request->request->get('_token'))) {
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            $statutRepository->remove($statut, true);
        }

        return $this->redirectToRoute('statut_index', [], Response::HTTP_SEE_OTHER);
    }
}

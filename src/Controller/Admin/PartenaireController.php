<?php

namespace App\Controller\Admin;

use App\Entity\Partenaire;
use App\Form\Admin\PartenaireType;
use App\Repository\PartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/moderation/partenaire')]
class PartenaireController extends AbstractController
{
    public function __construct(private SluggerInterface $sluger)
    {
    }

    #[Route('/', name: 'partenaires_index', methods: ['GET', 'POST'])]
    public function index(PartenaireRepository $partenaireRepository, Request $request): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $partenaire->setSlug(strtolower($this->sluger->slug($name)));
            $partenaireRepository->save($partenaire, true);
            $slug = $partenaire->getSlug() . '-' . $partenaire->getId();
            $partenaire->setSlug($slug);
            $partenaireRepository->save($partenaire, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('partenaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/partenaire/index.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
            'partenaires' => $partenaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'partenaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PartenaireRepository $partenaireRepository): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partenaireRepository->save($partenaire, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('partenaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/partenaire/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'partenaires_show', methods: ['GET'])]
    public function show(Partenaire $partenaire): Response
    {
        return $this->render('admin/partenaire/show.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }

    #[Route('/{slug}/edit', name: 'partenaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partenaire $partenaire, PartenaireRepository $partenaireRepository): Response
    {
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $partenaire->setSlug(strtolower($this->sluger->slug($name)));
            $partenaireRepository->save($partenaire, true);
            $slug = $partenaire->getSlug() . '-' . $partenaire->getId();
            $partenaire->setSlug($slug);
            $partenaireRepository->save($partenaire, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('partenaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/partenaire/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'partenaires_delete', methods: ['POST'])]
    public function delete(Request $request, Partenaire $partenaire, PartenaireRepository $partenaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $partenaire->getId(), $request->request->get('_token'))) {
            $partenaireRepository->remove($partenaire, true);
            $this->addFlash('success', 'Le contenu a bien été supprimé');
        }

        return $this->redirectToRoute('partenaires_index', [], Response::HTTP_SEE_OTHER);
    }
}

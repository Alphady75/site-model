<?php

namespace App\Controller\Admin;

use App\Entity\Activite;
use App\Form\Admin\ActiviteType;
use App\Repository\ActiviteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/activites')]
class ActiviteController extends AbstractController
{
    public function __construct(
        private SluggerInterface $sluger,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/', name: 'activite_index', methods: ['GET', 'POST'])]
    public function index(ActiviteRepository $activiteRepository, Request $request): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form->get('name')->getData();
            $activite->setSlug(strtolower($this->sluger->slug($name)));
            $activiteRepository->save($activite, true);
            $slug = $activite->getSlug() . '-' . $activite->getId();
            $activite->setSlug($slug);
            $activiteRepository->save($activite, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('activite_index', [], Response::HTTP_SEE_OTHER);
        }

        $activites = $this->paginator->paginate(
            $activiteRepository->findBy([], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/activite/index.html.twig', [
            'activites' => $activites,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'activite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActiviteRepository $activiteRepository): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activiteRepository->save($activite, true);

            return $this->redirectToRoute('activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'activite_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        return $this->render('admin/activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    #[Route('/{id}/edit', name: 'activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activiteRepository->save($activite, true);

            return $this->redirectToRoute('activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'activite_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, ActiviteRepository $activiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $activite->getId(), $request->request->get('_token'))) {
            $activiteRepository->remove($activite, true);
        }

        return $this->redirectToRoute('activite_index', [], Response::HTTP_SEE_OTHER);
    }
}

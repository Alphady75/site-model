<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/projets')]
class ProjetController extends AbstractController
{
    public function __construct(private SluggerInterface $sluger)
    {
    }

    #[Route('/', name: 'projet_index', methods: ['GET', 'POST'])]
    public function index(ProjetRepository $projetRepository, Request $request): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form->get('name')->getData();
            $projet->setSlug(strtolower($this->sluger->slug($name)));
            $projetRepository->save($projet, true);

            $slug = $projet->getSlug() . '-' . $projet->getId();
            $projet->setSlug($slug);
            $projetRepository->save($projet, true);
            $this->addFlash('success', 'Le contenu a bien été ajouter');
            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('admin/projet/index.html.twig', [
            'projets' => $projetRepository->findBy([], ['created' => 'DESC']),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjetRepository $projetRepository): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $name = $form->get('name')->getData();
            $projet->setSlug(strtolower($this->sluger->slug($name)));
            $projetRepository->save($projet, true);

            $slug = $projet->getSlug() . '-' . $projet->getId();
            $projet->setSlug($slug);
            $projetRepository->save($projet, true);
            $this->addFlash('success', 'Le contenu a bien été ajouter');
            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('admin/projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $name = $form->get('name')->getData();
            $projet->setSlug(strtolower($this->sluger->slug($name)));
            $projetRepository->save($projet, true);

            $slug = $projet->getSlug() . '-' . $projet->getId();
            $projet->setSlug($slug);
            $projetRepository->save($projet, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $projetRepository->remove($projet, true);
            $this->addFlash('success', 'Le contenu a bien été supprimer');
        }

        return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
    }
}

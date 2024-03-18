<?php

namespace App\Controller\Admin;

use App\Entity\Apropos;
use App\Form\AproposType;
use App\Repository\AproposRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/apropos')]
class AproposController extends AbstractController
{
    public function __construct(private SluggerInterface $sluger)
    {
    }

    #[Route('/', name: 'apropos_index', methods: ['GET'])]
    public function index(AproposRepository $aproposRepository): Response
    {
        $apropo = $aproposRepository->findOneBy(['online' => $this->getUser()]);
        if ($apropo) {
            return $this->redirectToRoute('apropos_show', ['id' => $apropo->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('apropos_new', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/new', name: 'apropos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AproposRepository $aproposRepository): Response
    {
        $apropo = new Apropos();
        $form = $this->createForm(AproposType::class, $apropo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apropo->setUser($this->getUser());
            $aproposRepository->save($apropo, true);

            return $this->redirectToRoute('apropos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/apropos/new.html.twig', [
            'apropo' => $apropo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'apropos_show', methods: ['GET'])]
    public function show(Apropos $apropo): Response
    {
        return $this->render('admin/apropos/show.html.twig', [
            'apropo' => $apropo,
        ]);
    }

    #[Route('/{id}/edit', name: 'apropos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Apropos $apropo, AproposRepository $aproposRepository): Response
    {
        $form = $this->createForm(AproposType::class, $apropo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aproposRepository->save($apropo, true);
            $this->addFlash('success', "Le contenu a bien été mis à jour");
            return $this->redirectToRoute('apropos_edit', ['id' => $apropo->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/apropos/edit.html.twig', [
            'apropo' => $apropo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'apropos_delete', methods: ['POST'])]
    public function delete(Request $request, Apropos $apropo, AproposRepository $aproposRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apropo->getId(), $request->request->get('_token'))) {
            $aproposRepository->remove($apropo, true);
        }

        return $this->redirectToRoute('apropos_index', [], Response::HTTP_SEE_OTHER);
    }
}

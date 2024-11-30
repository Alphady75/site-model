<?php

namespace App\Controller\Admin;

use App\Entity\Temoignage;
use App\Form\Admin\TemoignageType;
use App\Repository\TemoignageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/moderation/temoignage')]
class TemoignageController extends AbstractController
{
    public function __construct(private PaginatorInterface $paginator)
    {
    }

    #[Route('/', name: 'temoignages_index', methods: ['GET', 'POST'])]
    public function index(TemoignageRepository $temoignageRepository, Request $request): Response
    {
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $temoignageRepository->save($temoignage, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('temoignages_index', [], Response::HTTP_SEE_OTHER);
        }

        $temoignages = $this->paginator->paginate(
            $temoignageRepository->findBy([], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/temoignage/index.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form->createView(),
            'temoignages' => $temoignages,
        ]);
    }

    #[Route('/new', name: 'temoignages_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TemoignageRepository $temoignageRepository): Response
    {
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $temoignageRepository->save($temoignage, true);

            return $this->redirectToRoute('temoignages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/temoignage/new.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'temoignages_show', methods: ['GET'])]
    public function show(Temoignage $temoignage): Response
    {
        return $this->render('admin/temoignage/show.html.twig', [
            'temoignage' => $temoignage,
        ]);
    }

    #[Route('/{id}/edit', name: 'temoignages_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Temoignage $temoignage, TemoignageRepository $temoignageRepository): Response
    {
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $temoignageRepository->save($temoignage, true);
            $this->addFlash('success', 'Le contenu a bien été mis à jour');
            return $this->redirectToRoute('temoignages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/temoignage/edit.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'temoignages_delete', methods: ['POST'])]
    public function delete(Request $request, Temoignage $temoignage, TemoignageRepository $temoignageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $temoignage->getId(), $request->request->get('_token'))) {
            $temoignageRepository->remove($temoignage, true);
            $this->addFlash('success', 'Le contenu a bien été supprimé');
        }

        return $this->redirectToRoute('temoignages_index', [], Response::HTTP_SEE_OTHER);
    }
}

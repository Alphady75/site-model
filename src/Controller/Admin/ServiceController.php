<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Form\Admin\ServiceType;
use App\Repository\ServiceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/moderation/services')]
class ServiceController extends AbstractController
{
    public function __construct(private SluggerInterface $sluger, private PaginatorInterface $paginator)
    {
    }

    #[Route('/', name: 'service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository, Request $request): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form->get('name')->getData();
            $service->setSlug(strtolower($this->sluger->slug($name)));
            $serviceRepository->save($service, true);
            $slug = $service->getSlug() . '-' . $service->getId();
            $service->setSlug($slug);
            $serviceRepository->save($service, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('service_index', [], Response::HTTP_SEE_OTHER);
        }

        $services = $this->paginator->paginate(
            $serviceRepository->findBy([], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/service/index.html.twig', [
            'services' => $services,
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceRepository $serviceRepository): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form->get('name')->getData();
            $service->setSlug(strtolower($this->sluger->slug($name)));
            $serviceRepository->save($service, true);
            $slug = $service->getSlug() . '-' . $service->getId();
            $service->setSlug($slug);
            $serviceRepository->save($service, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/service/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('admin/service/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{slug}/edit', name: 'service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $name = $form->get('name')->getData();
            $service->setSlug(strtolower($this->sluger->slug($name)));
            $serviceRepository->save($service, true);

            $slug = $service->getSlug() . '-' . $service->getId();
            $service->setSlug($slug);
            $serviceRepository->save($service, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');

            return $this->redirectToRoute('service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $serviceRepository->remove($service, true);
            $this->addFlash('success', 'Le contenu a bien été supprimé');
        }

        return $this->redirectToRoute('service_index', [], Response::HTTP_SEE_OTHER);
    }
}

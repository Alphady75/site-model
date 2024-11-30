<?php

namespace App\Controller\Admin;

use App\Entity\Dto\User as DtoUser;
use App\Entity\User;
use App\Form\Admin\EditUserType;
use App\Form\Admin\UserType;
use App\Form\Dto\UserType as DtoUserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/comptes-utilisateurs')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET', 'POST'])]
    public function index(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, Request $request, PaginatorInterface $paginator): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compte = $form->get('compte')->getData();
            if ($compte == 'admin') {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_CLIENT']);
            }
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userRepository->save($user, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        $search = new DtoUser();
        $search->page = $request->get('page', 1);
        $formFilter = $this->createForm(DtoUserType::class, $search);
        $formFilter->handleRequest($request);
        $users = $userRepository->adminSearch($search);

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
            'formFilter' => $formFilter->createView(),
        ]);
    }

    #[Route('/nouveau-compte', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $compte = $form->get('compte')->getData();
            if ($compte == 'admin') {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_CLIENT']);
            }
            $password = $form->get('plainPassword')->getData();
            if (!empty($password)) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $password
                    )
                );
            }
            $userRepository->save($user, true);
            $this->addFlash('success', 'Le contenu a bien été enregistrer');
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash('success', 'Le contenu a bien été supprimé');
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}

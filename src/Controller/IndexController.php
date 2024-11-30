<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/app-redirection')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_redirection')]
    public function index(): Response
    {
        /** @var User */
        $user = $this->getUser();
        $roote = "admin_demande_index";
        if ($user->getCompte() == 'client') {
            $roote = 'user_demande_index';
        }

        return $this->redirectToRoute($roote);
    }
}

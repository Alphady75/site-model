<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    #[Route('/{locale}', name: 'change_locale', requirements: ['locale' => 'fr|en'])]
    public function translate(string $locale, Request $request): Response
    {
        $request->getSession()->set('_locale', $locale);
        $request->setlocale($locale);

        return $this->redirect($request->headers->get('referer'));
    }
}

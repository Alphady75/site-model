<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\Demande;
use App\Entity\User;
use App\Repository\DemandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SessionService
{
  private $request;

  public function __construct(
    private EntityManagerInterface $manager,
    RequestStack $requestStack,
    private UserRepository $userRepository,
    private DemandeRepository $demandeRepository,
    private UrlGeneratorInterface $urlGenerator
  ) {
    $this->request = $requestStack->getCurrentRequest();
  }

  /**
   * Set Demande in session
   *
   * @param Demande $demande
   * @return void
   */
  public function setDemande(Demande $demande)
  {
    if ($demande) {
      // Enregistrement de la valeur en session
      $this->request->getSession()->set('demande', $demande);
    }
  }

  /**
   * Get Demande in session
   *
   * @return Demande
   */
  public function getDemandeFromDataBase(User $user = null, $request = null)
  {
    /** @var Demande */
    $sessionDemande = $this->request->getSession()->get('demande');

    if ($sessionDemande && $sessionDemande->getId() != null) {
      $demande = $this->demandeRepository->find($sessionDemande->getId());
      if (!$demande)
        // Create new demande
        return $this->newDemande($user, $request);

      $demande = $this->updateDemande($request);
      return $demande;
    }
    // Create new demande
    return $this->newDemande($user, $request);
  }

  public function newDemande(User $user = null, $request = null)
  {
    $this->remove('demande');
    $newdemande = new Demande();
    if ($user) {
      $newdemande->setUser($user);
    }
    if ($request != null) {
      switch ($request) {
        case 1:
          $newdemande->setDemarche("Créer mon entreprise");
          break;
        case 2:
          $newdemande->setDemarche("Modifier mes statuts");
          break;
        case 3:
          $newdemande->setDemarche("Fermer mon entreprise");
          break;
        default:
          $newdemande->setDemarche("Créer mon entreprise");
          break;
      }
    };
    $newdemande->setCompleted(0);
    $newdemande->setRedirect('demande_statut');
    $this->manager->persist($newdemande, true);
    $this->manager->flush();
    $this->setDemande($newdemande);
    return $newdemande;
  }

  public function updateDemande($request = null)
  {
    $demande = $this->request->getSession()->get('demande');
    if ($request) {
      switch ($request) {
        case 1:
          $demande->setDemarche("Créer mon entreprise");
          break;
        case 2:
          $demande->setDemarche("Modifier mes statuts");
          break;
        case 3:
          $demande->setDemarche("Fermer mon entreprise");
          break;

        default:
          # code...
          break;
      }
    }
    $demande->setRedirect('demande_statut');
    $demande->setCompleted(0);
    $this->manager->flush();
    $this->setDemande($demande);
    return $demande;
  }

  /**
   * Set Demande in session
   *
   * @param Commande $commande
   * @return void
   */
  public function setCommande(Commande $commande)
  {
    if ($commande) {
      // Enregistrement de la valeur en session
      $this->request->getSession()->set('commande', $commande);
    }
  }

  /**
   * Get Commande in session
   *
   * @return Commande
   */
  public function getCommandeFromSession()
  {
    /** @var Commande */
    $commande = $this->request->getSession()->get('commande');
    return $commande;
  }

  /**
   * Set root from session
   *
   * @param string $roote
   * @return void
   */
  public function setRoote(string $roote)
  {
    $this->request->getSession()->set('roote', $roote);
  }

  /**
   * Get root from session
   *
   * @return void
   */
  public function getRoote()
  {
    return $this->request->getSession()->get('roote');
  }

  /**
   * Remove element to session
   *
   * @param string $element
   */
  public function remove(string $element)
  {
    $session = $this->request->getSession()->get($element);
    if (!empty($session)) {
      unset($session);
    }
    $this->request->getSession()->set($element, []);
  }
}

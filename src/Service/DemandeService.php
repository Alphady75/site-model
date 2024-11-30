<?php

namespace App\Service;

use App\Entity\Demande;
use App\Repository\ActiviteRepository;
use App\Repository\DemandeRepository;
use App\Repository\PartenaireRepository;
use App\Repository\ServiceRepository;
use App\Repository\StatutRepository;
use App\Repository\TarificationRepository;
use Doctrine\ORM\EntityManagerInterface;

class DemandeService
{
  public function __construct(
    private EntityManagerInterface $manager,
    private DemandeRepository $demandeRepository,
    private EntityManagerInterface $entityManager,
    private ActiviteRepository $activiteRepository,
    private PartenaireRepository $partenaireRepository,
    private ServiceRepository $serviceRepository,
    private StatutRepository $statutRepository,
    private TarificationRepository $tarificationRepository
  ) {}

  /**
   * Check activities
   *
   * @param string|null $reponse
   * @param Demande $demande
   * @return bool
   */
  public function checkActivite(string $reponse = null, Demande $demande)
  {
    $activite = $reponse ? $this->activiteRepository->find($reponse) : null;
    if ($activite) {
      $demande->setActivite($activite);
      $demande->setRedirect('demande_services');
      $this->entityManager->flush();
      return true;
    }
  }

  /**
   * Check activities
   *
   * @param string|null $reponse
   * @param Demande $demande
   * @return bool
   */
  public function checkStatutJuridique(string $reponse = null, Demande $demande)
  {
    $statut = $reponse ? $this->statutRepository->find($reponse) : null;
    if ($statut) {
      $demande->setStatut($statut);
      $demande->setRedirect("demande_declarant");
      $this->entityManager->flush();
      return true;
    }
  }

  /**
   * Check services
   *
   * @param integer|null $serviceId
   * @param Demande $demande
   * @return bool
   */
  public function checkService(int $serviceId = null, Demande $demande)
  {
    $service = $serviceId ? $this->serviceRepository->find($serviceId) : null;
    if ($service) {
      $demande->setService($service);
      $demande->setRedirect("demande_espertcomptable");
      $this->entityManager->flush();
      return true;
    }
    return false;
  }

  /**
   * Check comptable
   *
   * @param string|null $reponse
   * @param Demande $demande
   * @return bool
   */
  public function checkComptable(string $reponse = null, Demande $demande)
  {
    $array = [1, 2];

    if (isset($reponse) && in_array($reponse, $array)) {
      switch ($reponse) {
        case 1:
          $demande->setComptaStart("Oui");
          break;
        case 2:
          $demande->setComptaStart("Non");
          break;
        default:
          # code...
          break;
      }
      $demande->setRedirect("demande_presentation");
      $this->entityManager->flush();
      return true;
    }
  }

  /**
   * Check services
   *
   * @param integer|null $serviceId
   * @param Demande $demande
   * @return bool
   */
  public function checkTarification(int $tarificationId = null, Demande $demande)
  {
    $tarification = $tarificationId ? $this->tarificationRepository->find($tarificationId) : null;
    if ($tarification) {
      $demande->setTarification($tarification);
      $demande->setRedirect("demande_recapitulatif");
      $this->entityManager->flush();
      return true;
    }
    return false;
  }

  /**
   * Update demande
   *
   * @param int $request
   * @param Demande $demande
   * @return void
   */
  public function updateDemarche(int $request = null, Demande $demande)
  {
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
    $demande->setCompleted(0);
    $this->manager->flush();
    return $demande;
  }
}

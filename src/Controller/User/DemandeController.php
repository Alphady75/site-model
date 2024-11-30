<?php

namespace App\Controller\User;

use App\Entity\Demande;
use App\Entity\DossierJuridique;
use App\Entity\Etape;
use App\Form\Admin\DossierJuridiqueType;
use App\Form\Admin\EtapeType;
use App\Form\DemandeType;
use App\Form\Fiche\PrintDeclarationType;
use App\Form\Fiche\PrintProcurationType;
use App\Repository\CommandeRepository;
use App\Repository\DemandeRepository;
use App\Repository\EtapeRepository;
use App\Repository\FicheRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\StatutRepository;
use App\Service\DemandeService;
use App\Service\MailerService;
use App\Service\SessionService;
use App\Service\WordGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/demarches')]
class DemandeController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EtapeRepository $etapeRepository,
        private CommandeRepository $commandeRepository,
        private FicheRepository $ficheRepository,
        private QuestionnaireRepository $questionnaireRepository,
        private WordGenerator $wordGenerator,
        private MailerService $mailerService
    ) {}

    #[Route('/', name: 'user_demande_index', methods: ['GET'])]
    public function demarche(
        DemandeRepository $demandeRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $demandes = $paginator->paginate(
            $demandeRepository->findBy(['user' => $this->getUser()], ['created' => 'DESC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('user/demande/index.html.twig', [
            'demandes' => $demandes,
        ]);
    }

    #[Route('/projet/{id}', name: 'user_demande_projet', methods: ['GET'])]
    public function projet(Demande $demande): Response
    {
        return $this->render('user/demande/projet.html.twig', [
            'demande' => $demande
        ]);
    }

    #[Route('/services/{id}', name: 'user_demande_services', methods: ['GET'])]
    public function services(Demande $demande): Response
    {
        return $this->render('user/demande/services.html.twig', [
            'demande' => $demande
        ]);
    }

    #[Route('/commande/{id}', name: 'user_demande_commande', methods: ['GET'])]
    public function commande(Demande $demande): Response
    {
        return $this->render('user/demande/commande.html.twig', [
            'demande' => $demande
        ]);
    }

    #[Route('/dossier-juridique/{id}', name: 'demande_dossier_juridique', methods: ['GET', 'POST'])]
    public function dossierJuridique(Demande $demande, Request $request): Response
    {
        $dossier = $demande->getDossierJuridique();
        $etapes = $this->etapeRepository->findBy(['dossierJuridique' => $dossier]);
        $lastStatut = $dossier ? $dossier->getStatut() : 'En attente';
        /**
         * Create dossier if don'st exist
         */
        if (!$dossier) {
            $newdossier = new DossierJuridique();
            $newdossier->setDemande($demande);
            $newdossier->setName("Dossier juridique pour " .  $demande->getDemarche());
            $newdossier->setStatut("En attente");
            $newdossier->setLastStatut($lastStatut);
            $newdossier->setStatutBg("warning");
            $this->entityManager->persist($newdossier);
            $this->entityManager->flush();
            $dossier = $newdossier;
        }

        $etape = new Etape();
        $etapeForm = $this->createForm(EtapeType::class, $etape, []);
        $etapeForm->handleRequest($request);

        if ($etapeForm->isSubmitted() && $etapeForm->isValid()) {
            $etapeName = $etapeForm->get('name')->getData();
            $position = $etapes != null ? count($etapes) + 1 : 1;
            if ($this->etapeRepository->findOneBy(['name' => $etapeName, 'dossierJuridique' => $dossier]) == null) {
                $etape->setDossierJuridique($dossier);
                $etape->setPosition($position);
                $this->entityManager->persist($etape);
                $this->entityManager->flush();
                $this->addFlash("success", "Le dossier juridique est " . $etapeName);
                return $this->redirectToRoute('demande_dossier_juridique', ['id' => $demande->getId()]);
            } else {
                $this->addFlash("danger", "Le dossier juridique est déjà " . $etapeName);
            }
        }

        $dossierForm = $this->createForm(DossierJuridiqueType::class, $dossier);
        $dossierForm->handleRequest($request);

        if ($dossierForm->isSubmitted() && $dossierForm->isValid()) {
            $dossier->setLastStatut($lastStatut);
            $formStatut = $dossierForm->get('statut')->getData();
            switch ($formStatut) {
                case 'En attente':
                    $dossier->setStatutBg("warning");
                    $demande->setStatutBg("warning");
                    break;
                case 'En cours':
                    $dossier->setStatutBg("info");
                    $demande->setStatutBg("info");
                    break;
                case 'Valider':
                    $dossier->setStatutBg("success");
                    $demande->setStatutBg("success");
                    break;
                case 'Rejeter':
                    $dossier->setStatutBg("danger");
                    $demande->setStatutBg("danger");
                    break;
                default:
                    # code...
                    break;
            }
            if ($dossierForm->get('statut')->getData() != $lastStatut) {
                # Send email
                //$this->mailerService->sendStatutMessage($dossier);
            }
            $demande->setEtat($formStatut);
            $this->entityManager->flush();
            $dossier->getStatut() == 'Valider' ? $demande->setValidate(true) : '';
            $this->entityManager->flush();
            $this->addFlash('success', "Le statut du dossier juridique à bien été mis à jour ($formStatut), un mail a été envoyer à l'utilisateur");
            return $this->redirectToRoute('demande_dossier_juridique', ['id' => $demande->getId()]);
        }

        return $this->render('user/dossier_juridique/index.html.twig', [
            'demande' => $demande,
            'dossier' => $dossier,
            'form' => $etapeForm->createView(),
            'dossierForm' => $dossierForm->createView(),
            'etapes' => $etapes,
            'etape' => 'dossier',
        ]);
    }

    #[Route('/validation/{id}', name: 'demande_validation', methods: ['GET'])]
    public function validation(Demande $demande): Response
    {
        return $this->render('user/demande/validation.html.twig', [
            'demande' => $demande
        ]);
    }

    #[Route('/details/{id}', name: 'user_demande_show', methods: ['GET', 'POST'])]
    public function show(Demande $demande, Request $request): Response
    {
        $fiche = $this->ficheRepository->findOneBy(['demande' => $demande]);

        $formDeclaration = $this->createForm(PrintDeclarationType::class, [], []);
        $formDeclaration->handleRequest($request);

        if ($formDeclaration->isSubmitted() && $formDeclaration->isValid()) {
            $demande->setRedirect("demande_questionnaire");
            $this->entityManager->flush();

            // Générer le fichier Word à partir du contenu HTML
            $filePath = 'public/word-docs/output.docx';
            $this->wordGenerator->generateDeclaration($filePath, $fiche);

            // Retourner le fichier en tant que téléchargement
            return new StreamedResponse(function () use ($filePath) {
                readfile($filePath);
            }, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment; filename="document.docx"',
            ]);
        }

        $questionnaire = $this->questionnaireRepository->findOneBy(['demande' => $demande]);

        $formProcuration = $this->createForm(PrintProcurationType::class, [], []);
        $formProcuration->handleRequest($request);
        if ($formProcuration->isSubmitted() && $formProcuration->isValid()) {
            $demande->setRedirect("demande_document");

            // Générer le fichier Word à partir du contenu HTML
            $filePath = 'public/word-docs/output.docx';
            $this->wordGenerator->generateProcurationDocument($filePath, $fiche, $questionnaire, $demande->getStatut());

            /* Send file to email
            $this->mailerService->sendFileByEmail("alpha@gmail.com", $filePath, "Procuration");
            if ($suer) {
                $this->mailerService->sendFileByEmail($filePath, $user->getEmail(), "Procuration");
            }*/

            // Retourner le fichier en tant que téléchargement
            return new StreamedResponse(function () use ($filePath) {
                readfile($filePath);
            }, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment; filename="document.docx"',
            ]);
        }

        return $this->render('user/demande/show.html.twig', [
            'demande' => $demande,
            'fiche' => $fiche,
            'questionnaire' => $questionnaire,
            'formDeclaration' => $formDeclaration->createView(),
            'formProcuration' => $formProcuration->createView(),
            'commande' => $this->commandeRepository->findOneBy(['demarche' => $demande->getId()])
        ]);
    }

    #[Route('/modification/{id}/edit', name: 'user_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeRepository->save($demande, true);

            return $this->redirectToRoute('user_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/consulter/{id}', name: 'user_demande_consulter', methods: ['POST'])]
    public function consulter(Request $request, Demande $demande, SessionService $sessionService): Response
    {
        if ($this->isCsrfTokenValid('consulter' . $demande->getId(), $request->request->get('_token'))) {
            $sessionService->setDemande($demande);
            return $this->redirectToRoute($demande->getRedirect());
        }

        return $this->redirectToRoute('user_demande_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/{id}', name: 'user_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, DemandeRepository $demandeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token'))) {
            $demandeRepository->remove($demande, true);
        }

        return $this->redirectToRoute('user_demande_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/modifier-statut-entreprise', name: 'user_demande_statut', methods: ['GET'])]
    public function editStatut(
        Request $request,
        DemandeService $demandeService,
        SessionService $sessionService,
        StatutRepository $statutRepository
    ): Response {
        $reponse = $request->get('reponse');
        $demande = $sessionService->getDemandeFromDataBase();

        $check = $demandeService->checkStatutJuridique($reponse, $demande);
        if ($check) {
            return $this->redirectToRoute('demande_declarant');
        }

        return $this->render('user/demande/edit_statut.html.twig', [
            'demande' => $demande,
            'etape' => "projet",
            'statuts' => $statutRepository->findBy([], ['name' => 'DESC'])
        ]);
    }
}

<?php

namespace App\Controller\Demande;

use App\Entity\Commande;
use App\Entity\Demande;
use App\Entity\Document;
use App\Entity\Fiche;
use App\Entity\Questionnaire;
use App\Entity\Statut;
use App\Form\Demande\CommandeType;
use App\Form\Demande\CreateType;
use App\Form\Demande\SocieteType;
use App\Form\Fiche\DocumentType;
use App\Form\Fiche\EditDocumentType;
use App\Form\Fiche\EditPieceType;
use App\Form\Fiche\FichePersonnelleType;
use App\Form\Fiche\PieceType;
use App\Form\Fiche\PrintDeclarationType;
use App\Form\Fiche\PrintProcurationType;
use App\Form\Questionnaire\EntrepriseIndividuelleType;
use App\Form\Questionnaire\GieType;
use App\Form\Questionnaire\SarlType;
use App\Form\Questionnaire\SasType;
use App\Form\Questionnaire\SasuType;
use App\Form\Questionnaire\SaType;
use App\Form\Questionnaire\SncType;
use App\Repository\CommandeRepository;
use App\Repository\DemandeRepository;
use App\Repository\DocumentRepository;
use App\Repository\FicheRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\TarificationRepository;
use App\Service\DemandeService;
use App\Service\MailerService;
use App\Service\SessionService;
use App\Service\StripeService;
use App\Service\WordGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/creer-mon-entreprise')]
class CreerEntrepriseController extends AbstractController
{
    public function __construct(
        private DemandeRepository $demandeRepository,
        private FicheRepository $ficheRepository,
        private QuestionnaireRepository $questionnaireRepository,
        private TarificationRepository $tarificationRepository,
        private EntityManagerInterface $entityManager,
        private SessionService $sessionService,
        private DemandeService $demandeService,
        private CommandeRepository $commandeRepository,
        private DocumentRepository $documentRepository,
        private StripeService $stripeService,
        private WordGenerator $wordGenerator,
        private MailerService $mailerService
    ) {}

    /**
     * Step 1
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'demande_create')]
    public function create(Request $request): Response
    {
        $requette = $request->get('requete');
        /** @var User $user */
        $user = $this->getUser();

        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase($user ?? null, $requette);
        $demande = $this->getDemandeFromRepo($demande);

        // If demande and is completed
        if ($demande && $demande->isCompleted() == true){
            $this->sessionService->remove('demande');
        }
        $this->sessionService->setDemande($demande);

        return $this->redirectToRoute('demande_statut');
    }

    /**
     * Step 2
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/forme-juridique', name: 'demande_statut')]
    public function statut(Request $request): Response
    {
        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);
        $reponse = $request->get('reponse');

        if (!empty($reponse)) {
            // Check marque
            $check = $this->demandeService->checkStatutJuridique($reponse, $demande);
            if ($check) {
                return $this->redirectToRoute('demande_declarant');
            }
        }

        return $this->render('demande/statut_juridique.html.twig', [
            'demande' => $demande,
            'etape' => 'projet',
        ]);
    }

    /**
     * Step 3
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/informations-declarant', name: 'demande_declarant', methods: ['GET', 'POST'])]
    public function statutJuridique(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);
        if ($demande->getNom() == null && $user) {
            $demande->setNom($user->getNom());
            $demande->setPrenom($user->getPrenom());
            $demande->setTelephone($user->getTelephone());
            $demande->setEmail($user->getEmail());
        }

        $form = $this->createForm(CreateType::class, $demande, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setRedirect("demande_societe");
            $this->entityManager->flush();
            // Save demande in session
            return $this->redirectToRoute('demande_societe');
        }
        return $this->render('demande/create.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
        ]);
    }

    /**
     * Step 4
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/societe-introduction', name: 'demande_societe')]
    public function societe(Request $request): Response
    {
        $demande = new Demande();
        if ($this->sessionService->getDemandeFromDataBase()) {
            // Get Demande from session
            $demande = $this->sessionService->getDemandeFromDataBase();
            $demande = $this->getDemandeFromRepo($demande);
        }
        $form = $this->createForm(SocieteType::class, $demande, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setUser($this->getUser());
            $demande->setRedirect("demande_fiche");
            $this->entityManager->flush();
            return $this->redirectToRoute('demande_fiche');
        }
        return $this->render('demande/societe.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
        ]);
    }

    /**
     * Step 4
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/fiche-personnelle', name: 'demande_fiche', methods: ['POST', 'GET'])]
    public function fiche(Request $request): Response
    {
        $demande = new Demande();
        if ($this->sessionService->getDemandeFromDataBase()) {
            // Get Demande from session
            $demande = $this->sessionService->getDemandeFromDataBase();
            $demande = $this->getDemandeFromRepo($demande);
        }

        /** @var Fiche */
        $fiche = $this->ficheRepository->findOneBy(['demande' => $demande]);

        if (!$fiche) {
            $fiche = new Fiche();
            $fiche->setDemande($this->demandeRepository->find($demande->getId()));
            $this->entityManager->persist($fiche);
            $this->entityManager->flush();
        }

        $form = $this->createForm(FichePersonnelleType::class, $fiche, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setRedirect("demande_declaration");
            $this->entityManager->flush();

            return $this->redirectToRoute('demande_declaration');
        }

        return $this->render('demande/fiche.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
            'fiche' => $fiche,
        ]);
    }

    /**
     * Step 4
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/declaration-sur-honneur', name: 'demande_declaration')]
    public function declaration(Request $request): Response
    {
        $demande = new Demande();
        if ($this->sessionService->getDemandeFromDataBase()) {
            // Get Demande from session
            $demande = $this->sessionService->getDemandeFromDataBase();
            $demande = $this->getDemandeFromRepo($demande);
        }

        $fiche = $this->ficheRepository->findOneBy(['demande' => $demande]);

        $form = $this->createForm(PrintDeclarationType::class, [], []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        return $this->render('demande/declaration.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
            'fiche' => $fiche,
        ]);
    }

    /**
     * Step 4
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/questionnaire', name: 'demande_questionnaire', methods: ['POST', 'GET'])]
    public function questionnaire(Request $request): Response
    {
        $demande = new Demande();
        if ($this->sessionService->getDemandeFromDataBase()) {
            // Get Demande from session
            $demande = $this->sessionService->getDemandeFromDataBase();
            $demande = $this->getDemandeFromRepo($demande);
        }

        /** @var Questionnaire */
        $questionnaire = $this->questionnaireRepository->findOneBy(['demande' => $demande]);

        if (!$questionnaire) {
            $questionnaire = new Questionnaire();
            $questionnaire->setDemande($this->demandeRepository->find($demande->getId()));
            $this->entityManager->persist($questionnaire);
            $this->entityManager->flush();
            $questionnaire = $questionnaire;
        }

        $formType = $this->getQuestionnaire($demande->getStatut());
        $form = $this->createForm($formType, $questionnaire, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setRedirect("demande_procuration");
            $this->entityManager->flush();
            return $this->redirectToRoute('demande_procuration');
        }

        return $this->render('demande/questionnaire.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * Step 4
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/procuration', name: 'demande_procuration')]
    public function procuration(Request $request): Response
    {
        /** @var User $user */
        $suer = $this->getUser();

        $demande = new Demande();
        if ($this->sessionService->getDemandeFromDataBase()) {
            // Get Demande from session
            $demande = $this->sessionService->getDemandeFromDataBase();
            $demande = $this->getDemandeFromRepo($demande);
        }

        $questionnaire = $this->questionnaireRepository->findOneBy(['demande' => $demande]);
        $fiche = $this->ficheRepository->findOneBy(['demande' => $demande]);

        $form = $this->createForm(PrintProcurationType::class, [], []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
        return $this->render('demande/procuration.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * Step 4
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/envoie-des-documents', name: 'demande_document')]
    public function documents(Request $request): Response
    {
        $demande = new Demande();

        if ($this->sessionService->getDemandeFromDataBase()) {
            // Get Demande from session
            $demande = $this->sessionService->getDemandeFromDataBase();
            $demande = $this->getDemandeFromRepo($demande);
        }

        $document = $this->documentRepository->findOneBy(['demande' => $demande]);

        $formType = EditDocumentType::class;
        if (!$document) {
            $document = new Document();
            $document->setDemande($this->demandeRepository->find($demande->getId()));
            $document->setType('PROCURATION');
            $this->entityManager->persist($document);
            $this->entityManager->flush();
        }

        $form = $this->createForm($formType, $document, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setRedirect("demande_piece");
            $this->entityManager->flush();
            return $this->redirectToRoute('demande_piece');
        }

        return $this->render('demande/document.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
            'document' => $document,
        ]);
    }

    /**
     * Step 4
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/piece-identite', name: 'demande_piece', methods: ['POST', 'GET'])]
    public function piece(Request $request): Response
    {
        $demande = new Demande();
        if ($this->sessionService->getDemandeFromDataBase()) {
            // Get Demande from session
            $demande = $this->sessionService->getDemandeFromDataBase();
            $demande = $this->getDemandeFromRepo($demande);
        }
        $fiche = $this->ficheRepository->findOneBy(['demande' => $demande]);
        //$formType = EditPieceType::class;

        $form = $this->createForm(EditPieceType::class, $fiche, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setRedirect("demande_services");
            $this->entityManager->flush();

            return $this->redirectToRoute('demande_services');
        }
        return $this->render('demande/piece.html.twig', [
            'form' => $form->createView(),
            'demande' => $demande,
            'etape' => 'projet',
            'fiche' => $fiche,
        ]);
    }

    /**
     * Step 6
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/services', name: 'demande_services')]
    public function services(Request $request): Response
    {
        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);
        $reponse = $request->get('reponse');

        if (!empty($reponse)) {
            // Check service
            $check = $this->demandeService->checkService($reponse, $demande);
            if ($check) {
                return $this->redirectToRoute('demande_espertcomptable');
            }
        }

        return $this->render('demande/services.html.twig', [
            'demande' => $demande,
            'etape' => 'service',
        ]);
    }

    /**
     * Step 7
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/espert-comptable', name: 'demande_espertcomptable')]
    public function expertComptable(Request $request): Response
    {
        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);
        $reponse = $request->get('reponse');
        if (!empty($reponse)) {
            $check = $this->demandeService->checkComptable($reponse, $demande);
            if ($check) {
                return $this->redirectToRoute('demande_presentation');
            }
        }

        return $this->render('demande/comptable.html.twig', [
            'demande' => $demande,
            'etape' => 'service',
        ]);
    }

    /**
     * Step 8
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/presentation', name: 'demande_presentation')]
    public function presentation(): Response
    {
        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();

        return $this->render('demande/presentation.html.twig', [
            'demande' => $demande,
            'etape' => 'service',
        ]);
    }

    /**
     * Step 9
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/dossier-juridique', name: 'demande_dossier')]
    public function dossier(): Response
    {
        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);

        return $this->render('demande/dossier.html.twig', [
            'etape' => 'dossier',
            'demande' => $demande,
        ]);
    }

    /**
     * Step 10
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/formules', name: 'demande_formules')]
    public function formules(Request $request): Response
    {
        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);
        $reponse = $request->get('reponse');

        if (!empty($reponse)) {
            // Check tarification
            $check = $this->demandeService->checkTarification($reponse, $demande);
            if ($check) {
                return $this->redirectToRoute('demande_recapitulatif');
            }
        }

        $tarifications = $this->tarificationRepository->findBy(['statut' => $demande->getStatut()]);

        return $this->render('demande/formules.html.twig', [
            'demande' => $demande,
            'etape' => 'commande',
            'tarifications' => $tarifications,
        ]);
    }

    /**
     * Step 11
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/recapitulatif', name: 'demande_recapitulatif')]
    public function recapitulatif(): Response
    {
        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);
        $total = $demande->getTarification()->getCout() * $this->getTva();

        return $this->render('demande/recapitulatif.html.twig', [
            'demande' => $demande,
            'tarification' => $demande->getTarification(),
            'total' => $total,
            'tva' => $this->getTva(),
            'etape' => 'commande',
        ]);
    }

    /**
     * Step 12
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/commande', name: 'demande_commande', methods: ['POST', 'GET'])]
    public function commande(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->sessionService->setRoote('demande_commande');
            return $this->redirectToRoute('app_register');
        }

        // Get Demande from session
        $demande = $this->sessionService->getDemandeFromDataBase();
        $demande = $this->getDemandeFromRepo($demande);
        $total = $demande->getTarification()->getCout() * $this->getTva();
        $commande = new Commande();
        $commande->setNom($demande->getNom());
        $commande->setPrenom($demande->getPrenom());
        $commande->setEmail($demande->getEmail());
        $commande->setPays($demande->getPays());
        $commande->setTelephone($demande->getTelephone());
        $commande->setDemarche($demande->getId());
        $commande->setMontant($total);
        $commande->setName($demande->getDemarche() . ' ' . $demande->getStatut()->getName());
        $commande->setUser($user);

        $form = $this->createForm(CommandeType::class, $commande, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($commande);
            $this->entityManager->flush();

            // Initiate paiement
            $response = $this->stripeService->payer(
                $commande,
                $total,
                'creer-mon-entreprise/commande',
                'user/commandes/annuler'
            );

            return $this->redirect($response);
        }

        $token = $request->get('token');

        if ($token) {
            //$commande->getToken() == null ? $commande->setToken($token) : '';
            $commande = $this->commandeRepository->findOneBy(['demarche' => $demande->getId()]);
            $commande->setToken($token);
            $commande->setPayer(1);
            $demande->setPayer(1);
            $demande->setCompleted(1);
            $demande->setPayer(1);
            $demande->setEtat("En cours");
            $demande->setStatutBg("warning");
            $demande->setRedirect("En cours");
            $demande->setUser($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('user_commandes_success', ['token' => $commande->getToken()]);
        }

        if ($demande->isPayer()) {
            return $this->redirectToRoute('demande_dossier_juridique', ['id' => $demande->getId()]);
        }

        return $this->render('demande/commande.html.twig', [
            'demande' => $demande,
            'form' => $form->createView(),
            'tarification' => $demande->getTarification(),
            'total' => $total,
            'tva' => $this->getTva(),
            'etape' => 'commande',
        ]);
    }

    public function getTva()
    {
        $tva = 1;

        return $tva;
    }

    public function getQuestionnaire(Statut $statut)
    {
        $formType = null;

        switch ($statut) {
            case 'SASU':
                $formType = SasuType::class;
                break;
            case 'SAS':
                $formType = SasType::class;
                break;
            case 'SARL 3 ASSOCIES':
                $formType = SarlType::class;
                break;
            case 'GIE':
                $formType = GieType::class;
                break;
            case 'ENTREPRISE INDIVIDUELLE':
                $formType = EntrepriseIndividuelleType::class;
                break;
            case 'SA':
                $formType = SaType::class;
                break;
            case 'SNC':
                $formType = SncType::class;
                break;
            default:
                # code...
                break;
        }

        return $formType;
    }

    public function getDemandeFromRepo(Demande $demande)
    {
        return $this->demandeRepository->find($demande->getId());
    }
}

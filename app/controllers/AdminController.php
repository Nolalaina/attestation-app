<?php
require_once ROOT_PATH . '/app/core/Controller.php';

class AdminController extends Controller
{
    private Demande $demandeModel;
    private TypeAttestation $typeModel;

    public function __construct()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        if (!str_contains($uri, 'ecranGuichet')) {
            Auth::requireAdmin();
        }
        $this->demandeModel = $this->model('Demande');
        $this->typeModel = $this->model('TypeAttestation');
    }

    public function dashboard(): void
    {
        $stats = $this->demandeModel->countByStatut();
        $total = $this->demandeModel->totalCount();
        $recentes = $this->demandeModel->search([], 6, 0);
        $statsHebdo = $this->demandeModel->statsHebdomadaires(6);

        $this->view('admin/dashboard', compact('stats', 'total', 'recentes', 'statsHebdo'));
    }

    /** Registre de suivi des demandes */
    public function registre(): void
    {
        $filters = [
            'statut'     => $_GET['statut'] ?? '',
            'type_id'    => $_GET['type_id'] ?? '',
            'q'          => $_GET['q'] ?? '',
            'date_debut' => $_GET['date_debut'] ?? '',
            'date_fin'   => $_GET['date_fin'] ?? '',
        ];

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $limit = PAGINATION_LIMIT;
        $offset = ($page - 1) * $limit;

        $demandes = $this->demandeModel->search($filters, $limit, $offset);
        $totalResultats = $this->demandeModel->count($filters);
        $totalPages = (int) ceil($totalResultats / $limit);
        $types = $this->typeModel->all(false);

        $this->view('admin/registre', compact('demandes', 'filters', 'page', 'totalPages', 'types', 'totalResultats'));
    }

    public function detail(int $id): void
    {
        $demande = $this->demandeModel->find($id);
        if (!$demande) {
            $this->setFlash('error', 'Demande introuvable.');
            $this->redirect('admin/registre');
        }
        $historique = $this->demandeModel->historique($id);
        $retraitModel = $this->model('Retrait');
        $retrait = $demande['statut'] === 'retiree' ? $retraitModel->findByDemande($id) : null;

        $this->view('admin/demande_detail', compact('demande', 'historique', 'retrait'));
    }

    /** Changement de statut (prendre en charge, traiter, refuser) */
    public function changerStatut(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $statut = $this->post('statut');
            $commentaire = $this->post('commentaire', '');
            $validStatuts = ['en_cours', 'traitee', 'refusee'];

            if (in_array($statut, $validStatuts, true)) {
                $this->demandeModel->updateStatut($id, $statut, Auth::id(), $commentaire ?: null);
                $this->setFlash('success', 'Le statut de la demande a été mis à jour.');
            }
        }
        $this->redirect('admin/detail/' . $id);
    }

    /** Fiche de retrait : enregistrement de la remise du document */
    public function retrait(int $id): void
    {
        $demande = $this->demandeModel->find($id);
        if (!$demande || $demande['statut'] !== 'traitee') {
            $this->setFlash('error', 'Cette demande n\'est pas prête pour un retrait.');
            $this->redirect('admin/detail/' . $id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomReceveur = $this->post('nom_receveur');
            if (!empty($nomReceveur)) {
                $retraitModel = $this->model('Retrait');
                $retraitModel->create($id, $nomReceveur, Auth::id());
                $this->demandeModel->updateStatut($id, 'retiree', Auth::id(), 'Document remis à : ' . $nomReceveur);
                $this->setFlash('success', 'Le retrait a été enregistré.');
                $this->redirect('admin/detail/' . $id);
            }
        }

        $this->view('admin/retrait', compact('demande'));
    }

    /** Statistiques hebdomadaires / mensuelles */
    public function statistiques(): void
    {
        $statsHebdo = $this->demandeModel->statsHebdomadaires(10);
        $statsParType = $this->demandeModel->statsParType();
        $statsStatut = $this->demandeModel->countByStatut();

        $this->view('admin/statistiques', compact('statsHebdo', 'statsParType', 'statsStatut'));
    }

    /** Gestion des types d'attestation */
    public function typesAttestation(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $this->post('nom');
            $description = $this->post('description');
            $delai = (int) $this->post('delai', 3);
            if (!empty($nom)) {
                $this->typeModel->create($nom, $description ?: null, max(1, $delai));
                $this->setFlash('success', 'Le type d\'attestation a été ajouté.');
            }
            $this->redirect('admin/typesAttestation');
        }

        $types = $this->typeModel->all(false);
        $this->view('admin/types_attestation', compact('types'));
    }

    public function toggleType(int $id): void
    {
        $this->typeModel->toggleActif($id);
        $this->redirect('admin/typesAttestation');
    }

    public function ticket(int $id): void
    {
        $demande = $this->demandeModel->find($id);
        if (!$demande) {
            $this->setFlash('error', 'Ticket introuvable.');
            $this->redirect('admin/registre');
        }
        $this->view('etudiant/ticket_print', compact('demande'), false);
    }

    public function ecranGuichet(): void
    {
        $appelees = $this->demandeModel->search(['statut' => 'traitee'], 6, 0);
        $enCours = $this->demandeModel->search(['statut' => 'en_cours'], 6, 0);
        $enAttente = $this->demandeModel->search(['statut' => 'en_attente'], 8, 0);
        $this->view('admin/ecran_guichet', compact('appelees', 'enCours', 'enAttente'), false);
    }
}

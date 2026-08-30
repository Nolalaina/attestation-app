<?php
require_once ROOT_PATH . '/app/core/Controller.php';

class EtudiantController extends Controller
{
    private Demande $demandeModel;
    private TypeAttestation $typeModel;

    public function __construct()
    {
        Auth::requireEtudiant();
        $this->demandeModel = $this->model('Demande');
        $this->typeModel = $this->model('TypeAttestation');
    }

    public function dashboard(): void
    {
        $demandes = $this->demandeModel->findByUser(Auth::id());

        $stats = [
            'total'      => count($demandes),
            'en_cours'   => count(array_filter($demandes, fn($d) => in_array($d['statut'], ['en_attente', 'en_cours']))),
            'traitees'   => count(array_filter($demandes, fn($d) => in_array($d['statut'], ['traitee', 'retiree']))),
            'refusees'   => count(array_filter($demandes, fn($d) => $d['statut'] === 'refusee')),
        ];

        $recentes = array_slice($demandes, 0, 5);

        $this->view('etudiant/dashboard', ['stats' => $stats, 'recentes' => $recentes]);
    }

    public function nouvelleDemande(): void
    {
        $types = $this->typeModel->all();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Auth::verifyCsrf($this->post('csrf_token'))) {
                $errors[] = 'Session expirée, veuillez réessayer.';
            }

            $typeId = (int) $this->post('type_id');
            $objet = $this->post('objet');
            $observations = $this->post('observations', '');

            $type = $typeId ? $this->typeModel->find($typeId) : null;
            if (!$type) {
                $errors[] = 'Veuillez choisir un type d\'attestation valide.';
            }
            if (empty($objet)) {
                $errors[] = 'Veuillez préciser l\'objet de la demande.';
            }

            if (empty($errors)) {
                $demandeId = $this->demandeModel->create(
                    Auth::id(),
                    $typeId,
                    $objet,
                    $observations ?: null,
                    $type['delai_traitement_j'] ?? 3
                );
                $this->setFlash('success', 'Votre demande a été soumise avec succès. Vous pouvez suivre son avancement ci-dessous.');
                $this->redirect('etudiant/detail/' . $demandeId);
            }
        }

        $this->view('etudiant/nouvelle_demande', [
            'types' => $types,
            'errors' => $errors,
            'csrf' => Auth::csrfToken(),
        ]);
    }

    public function mesDemandes(): void
    {
        $demandes = $this->demandeModel->findByUser(Auth::id());
        $this->view('etudiant/mes_demandes', ['demandes' => $demandes]);
    }

    public function detail(int $id): void
    {
        $demande = $this->demandeModel->find($id);

        if (!$demande || (int) $demande['user_id'] !== Auth::id()) {
            $this->setFlash('error', 'Demande introuvable.');
            $this->redirect('etudiant/mesDemandes');
        }

        $historique = $this->demandeModel->historique($id);
        $retraitModel = $this->model('Retrait');
        $retrait = $demande['statut'] === 'retiree' ? $retraitModel->findByDemande($id) : null;

        $this->view('etudiant/detail_demande', compact('demande', 'historique', 'retrait'));
    }

    public function annuler(int $id): void
    {
        $demande = $this->demandeModel->find($id);
        if ($demande && (int) $demande['user_id'] === Auth::id() && $demande['statut'] === 'en_attente') {
            $this->demandeModel->delete($id);
            $this->setFlash('success', 'Votre demande a été annulée.');
        }
        $this->redirect('etudiant/mesDemandes');
    }

    public function profil(): void
    {
        $userModel = $this->model('User');
        $user = $userModel->findById(Auth::id());
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $this->post('action');
            if ($action === 'update_info') {
                $telephone = $this->post('telephone', '');
                $filiere = $this->post('filiere', '');
                $niveau = $this->post('niveau', '');
                $userModel->updateProfile(Auth::id(), $telephone, $filiere, $niveau);
                $this->setFlash('success', 'Vos informations personnelles ont été mises à jour.');
                $this->redirect('etudiant/profil');
            } elseif ($action === 'change_password') {
                $oldPass = $this->post('old_password');
                $newPass = $this->post('new_password');
                $confirmPass = $this->post('confirm_password');

                if (!$userModel->verifyPassword($oldPass, $user['mot_de_passe'])) {
                    $errors[] = 'L\'ancien mot de passe est incorrect.';
                } elseif (strlen($newPass) < 6) {
                    $errors[] = 'Le nouveau mot de passe doit contenir au moins 6 caractères.';
                } elseif ($newPass !== $confirmPass) {
                    $errors[] = 'Les nouveaux mots de passe ne correspondent pas.';
                } else {
                    $userModel->updatePassword(Auth::id(), $newPass);
                    $this->setFlash('success', 'Votre mot de passe a été modifié avec succès.');
                    $this->redirect('etudiant/profil');
                }
            }
        }

        $this->view('etudiant/profil', compact('user', 'errors'));
    }

    public function ticket(int $id): void
    {
        $demande = $this->demandeModel->find($id);
        if (!$demande || (int) $demande['user_id'] !== Auth::id()) {
            $this->setFlash('error', 'Ticket introuvable.');
            $this->redirect('etudiant/mesDemandes');
        }
        $this->view('etudiant/ticket_print', compact('demande'), false);
    }
}

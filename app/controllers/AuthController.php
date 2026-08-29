<?php
require_once ROOT_PATH . '/app/core/Controller.php';

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    /** Page d'accueil / redirection */
    public function index(): void
    {
        if (Auth::check()) {
            $this->redirect(Auth::isAdmin() ? 'admin/dashboard' : 'etudiant/dashboard');
        }
        $this->redirect('auth/login');
    }

    public function login(): void
    {
        if (Auth::check()) {
            $this->redirect(Auth::isAdmin() ? 'admin/dashboard' : 'etudiant/dashboard');
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->post('email');
            $password = $this->post('mot_de_passe');

            if (!$email || !$password) {
                $errors[] = 'Veuillez renseigner votre email et votre mot de passe.';
            } else {
                $user = $this->userModel->findByEmail($email);
                if (!$user || !$this->userModel->verifyPassword($password, $user['mot_de_passe'])) {
                    $errors[] = 'Email ou mot de passe incorrect.';
                } elseif ($user['statut_compte'] === 'suspendu') {
                    $errors[] = 'Ce compte a été suspendu. Contactez l\'administration.';
                } else {
                    Auth::login($user);
                    $this->redirect($user['role'] === 'admin' ? 'admin/dashboard' : 'etudiant/dashboard');
                }
            }
        }

        $this->view('auth/login', ['errors' => $errors], false);
    }

    public function register(): void
    {
        if (Auth::check()) {
            $this->redirect(Auth::isAdmin() ? 'admin/dashboard' : 'etudiant/dashboard');
        }

        $errors = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = [
                'nom'       => $this->post('nom'),
                'prenom'    => $this->post('prenom'),
                'email'     => $this->post('email'),
                'matricule' => $this->post('matricule'),
                'filiere'   => $this->post('filiere'),
                'niveau'    => $this->post('niveau'),
                'telephone' => $this->post('telephone'),
            ];
            $password = $this->post('mot_de_passe');
            $passwordConfirm = $this->post('mot_de_passe_confirm');

            foreach (['nom', 'prenom', 'email', 'matricule', 'filiere', 'niveau'] as $field) {
                if (empty($old[$field])) {
                    $errors[] = "Le champ « $field » est obligatoire.";
                }
            }
            if (!empty($old['email']) && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'L\'adresse email n\'est pas valide.';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
            }
            if ($password !== $passwordConfirm) {
                $errors[] = 'Les mots de passe ne correspondent pas.';
            }
            if (!empty($old['email']) && $this->userModel->emailExists($old['email'])) {
                $errors[] = 'Cet email est déjà utilisé par un autre compte.';
            }
            if (!empty($old['matricule']) && $this->userModel->matriculeExists($old['matricule'])) {
                $errors[] = 'Ce numéro matricule est déjà enregistré.';
            }

            if (empty($errors)) {
                $userId = $this->userModel->create([
                    'role'         => 'etudiant',
                    'nom'          => $old['nom'],
                    'prenom'       => $old['prenom'],
                    'email'        => $old['email'],
                    'mot_de_passe' => $password,
                    'matricule'    => $old['matricule'],
                    'filiere'      => $old['filiere'],
                    'niveau'       => $old['niveau'],
                    'telephone'    => $old['telephone'],
                ]);
                $user = $this->userModel->findById($userId);
                Auth::login($user);
                $this->redirect('etudiant/dashboard');
            }
        }

        $this->view('auth/register', ['errors' => $errors, 'old' => $old], false);
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('auth/login');
    }
}

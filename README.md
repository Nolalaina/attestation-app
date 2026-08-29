# AttestPro — Application de demande d'attestation en ligne

Application web en **PHP natif (architecture MVC)** avec base de données **MySQL**, permettant aux étudiants de soumettre et suivre leurs demandes d'attestations administratives en ligne, et au personnel administratif de les traiter (registre de suivi, changement de statut, fiche de retrait, statistiques).

## 1. Structure du projet (MVC)

```
attestation-app/
├── app/
│   ├── controllers/        AuthController, EtudiantController, AdminController
│   ├── core/                Router, Controller, Model, Database, Auth (base du framework)
│   ├── models/               User, Demande, TypeAttestation, Retrait
│   └── views/
│       ├── layouts/          header.php / footer.php (sidebar + structure commune)
│       ├── auth/              login.php, register.php
│       ├── etudiant/          dashboard, nouvelle_demande, mes_demandes, detail_demande, profil
│       ├── admin/             dashboard, registre, demande_detail, retrait, statistiques, types_attestation
│       └── errors/            404.php
├── config/
│   ├── config.php            Constantes de l'application (URL, base de données...)
│   └── database.php          (chargé via app/core/Database.php)
├── database/
│   └── schema.sql             Script de création de la base + données de démonstration
├── public/                   **Racine web (DocumentRoot / dossier à pointer sur le serveur)**
│   ├── index.php              Front controller (point d'entrée unique)
│   ├── .htaccess               Réécriture d'URL (routes "propres")
│   └── assets/css|js
└── README.md
```

Le routage suit le schéma `controleur/action/param` (ex : `/etudiant/detail/12`), dispatché par `app/core/Router.php` vers `app/controllers/EtudiantController.php::detail(12)`.

## 2. Modèle de données (MySQL)

- **users** — étudiants et agents (`role` = `etudiant` ou `admin`), avec matricule, filière, niveau.
- **types_attestation** — catalogue des attestations proposées (certificat de scolarité, relevé de notes...) avec délai de traitement.
- **demandes** — la fiche de demande (code unique, étudiant, type, objet, statut, dates).
- **historique_demandes** — traçabilité de chaque changement de statut (registre de suivi).
- **retraits** — la fiche de retrait signée à la remise du document.

Statuts d'une demande : `en_attente` → `en_cours` → `traitee` → `retiree` (ou `refusee` à tout moment avant traitement).

## 3. Installation

### Prérequis
- PHP 8.0+ avec l'extension **PDO MySQL**
- MySQL / MariaDB
- Apache avec `mod_rewrite` activé (ou Nginx équivalent) — XAMPP / WAMP / MAMP fonctionnent parfaitement

### Étapes

1. **Copier le projet** dans le dossier de votre serveur, par exemple :
   `C:\xampp\htdocs\attestation-app` (Windows) ou `/var/www/html/attestation-app` (Linux).

2. **Créer la base de données** : importez `database/schema.sql` via phpMyAdmin, ou en ligne de commande :
   ```bash
   mysql -u root -p < database/schema.sql
   ```
   Cela crée la base `gestion_attestations`, ses tables, les types d'attestations courants et un **compte administrateur de démonstration** :
   - Email : `admin@universite.mg`
   - Mot de passe : `Admin@2026`

3. **Configurer la connexion** dans `config/config.php` si besoin (identifiants MySQL, `APP_URL`) :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'gestion_attestations');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('APP_URL', 'http://localhost/attestation-app/public');
   ```

4. **Pointer le serveur web sur le dossier `public/`** (c'est la racine web). Avec le serveur intégré de PHP, depuis la racine du projet :
   ```bash
   php -S localhost:8000 -t public
   ```
   puis mettez à jour `APP_URL` en conséquence (`http://localhost:8000`).

5. Ouvrez `APP_URL` dans votre navigateur : vous arrivez sur la page de connexion.
   - Connectez-vous avec le compte admin ci-dessus pour l'espace administratif,
   - ou cliquez sur **« Créer un compte étudiant »** pour tester le parcours étudiant.

## 4. Parcours fonctionnels

**Étudiant**
- Créer un compte (nom, matricule, filière, niveau...)
- Soumettre une nouvelle demande (fiche de demande officielle : type, objet, observations)
- Suivre l'état d'avancement en temps réel (frise chronologique + numéro de demande)
- Consulter l'historique complet de ses demandes, annuler une demande encore en attente

**Administration**
- Tableau de bord : compteurs par statut, volume hebdomadaire, dernières demandes
- Registre de suivi : recherche, filtres (statut, type, période), pagination
- Traitement d'une demande : prise en charge → traitée / refusée (avec motif)
- Fiche de retrait : enregistrement de la remise du document (nom du receveur, date, agent)
- Statistiques hebdomadaires et par type d'attestation
- Gestion des types d'attestation proposés

## 5. Sécurité

- Mots de passe hashés avec `password_hash` (BCRYPT) / vérifiés avec `password_verify`
- Requêtes SQL préparées (PDO) partout — protection contre les injections SQL
- Jeton CSRF sur le formulaire de nouvelle demande
- Contrôle d'accès par rôle (`Auth::requireAdmin()` / `Auth::requireEtudiant()`) sur chaque contrôleur
- Échappement systématique des sorties (`htmlspecialchars`) dans les vues

## 6. Aller plus loin (pistes d'évolution)

- Notifications par email lors d'un changement de statut
- Export PDF de la fiche de demande / du reçu de retrait
- Upload de pièces justificatives
- Journal d'activité des agents administratifs

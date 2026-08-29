<?php
/**
 * Script de remplissage de la base de données (Seeder)
 */
require_once dirname(__DIR__) . '/config/config.php';
require_once ROOT_PATH . '/app/core/Database.php';

try {
    $db = Database::getConnection();
    echo "Réinitialisation de la base de données...\n";

    // Désactiver les clés étrangères
    $db->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $db->exec("TRUNCATE TABLE retraits;");
    $db->exec("TRUNCATE TABLE historique_demandes;");
    $db->exec("TRUNCATE TABLE demandes;");
    $db->exec("TRUNCATE TABLE types_attestation;");
    $db->exec("TRUNCATE TABLE users;");
    $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

    $passHash = password_hash('Admin@2026', PASSWORD_BCRYPT);
    $etudiantPassHash = password_hash('Etudiant@2026', PASSWORD_BCRYPT);

    // 1. Inserer utilisateurs
    $users = [
        ['admin', 'Andria', 'Fara', 'admin@universite.mg', $passHash, 'ADM-001', 'Administration', 'Agent Principal', '034 00 111 22'],
        ['admin', 'Rabe', 'Jean-Marc', 'agent2@universite.mg', $passHash, 'ADM-002', 'Guichet 2', 'Agent Administratif', '034 00 111 23'],
        ['etudiant', 'Rakoto', 'Haja', 'etudiant@universite.mg', $etudiantPassHash, '2023-INF-0142', 'Informatique de Gestion', 'L3', '034 12 345 67'],
        ['etudiant', 'Rasoa', 'Mira', 'mira.rasoa@universite.mg', $etudiantPassHash, '2022-GES-0891', 'Sciences de Gestion', 'M1', '033 98 765 43'],
        ['etudiant', 'Randria', 'Toky', 'toky.randria@universite.mg', $etudiantPassHash, '2024-DRO-0033', 'Droit des Affaires', 'L2', '032 55 443 21'],
        ['etudiant', 'Haja', 'Soafara', 'soafara.haja@universite.mg', $etudiantPassHash, '2025-ECO-0512', 'Économie & Finance', 'L1', '034 77 889 90'],
        ['etudiant', 'Ravelo', 'Kevin', 'kevin.ravelo@universite.mg', $etudiantPassHash, '2023-INF-0205', 'Informatique de Gestion', 'L3', '033 11 223 34'],
    ];

    $stmtUser = $db->prepare("INSERT INTO users (role, nom, prenom, email, mot_de_passe, matricule, filiere, niveau, telephone, statut_compte) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'actif')");
    foreach ($users as $u) {
        $stmtUser->execute($u);
    }

    echo "Utilisateurs insérés.\n";

    // 2. Types d'attestation
    $types = [
        ['Certificat de scolarité', 'Atteste de l\'inscription en cours pour l\'année académique actuelle', 2],
        ['Attestation d\'inscription', 'Confirme l\'inscription administrative officielle de l\'étudiant', 2],
        ['Relevé de notes', 'Récapitulatif officiel des notes et crédits ECTS par semestre', 4],
        ['Attestation de réussite', 'Confirme la validation d\'un diplôme ou le passage en année supérieure', 5],
        ['Attestation de présence', 'Justifie la présence effective de l\'étudiant sur une période donnée', 2],
        ['Duplicata de Diplôme', 'Copie certifiée conforme du diplôme original délivré', 7],
    ];

    $stmtType = $db->prepare("INSERT INTO types_attestation (nom, description, delai_traitement_j, actif) VALUES (?, ?, ?, 1)");
    foreach ($types as $t) {
        $stmtType->execute($t);
    }

    echo "Types d'attestation insérés.\n";

    // 3. Demandes exemple
    $demandesData = [
        ['ATT-2026-0001', 3, 1, 'Dossier de candidature Master International', 'retiree', '2026-08-15 09:30:00', '2026-08-17', '2026-08-17 11:00:00', 'Priorité avant la fin de semaine', null, 1],
        ['ATT-2026-0002', 3, 3, 'Demande de Stage de Fin d\'Études en Entreprise', 'traitee', '2026-08-20 14:15:00', '2026-08-24', '2026-08-24 10:20:00', 'Besoins urgent RH', null, 1],
        ['ATT-2026-0003', 4, 2, 'Renouvellement passeport & visa étudiant', 'en_cours', '2026-08-27 10:00:00', '2026-08-29', null, 'Merci de préciser la filière', null, 2],
        ['ATT-2026-0004', 5, 1, 'Attestation de présence formation obligatoire', 'en_attente', '2026-08-28 16:45:00', '2026-08-30', null, '', null, null],
        ['ATT-2026-0005', 6, 4, 'Candidature concours d\'entrée fonction publique', 'en_attente', '2026-08-29 08:30:00', '2026-09-03', null, 'Dossier complet fourni', null, null],
        ['ATT-2026-0006', 7, 3, 'Réclamation relevé de notes S5', 'refusee', '2026-08-18 11:20:00', '2026-08-22', null, 'Manque justificatif de rattrapage', 'Paiement frais de scolarité non régularisé pour le semestre 5.', 1],
        ['ATT-2026-0007', 3, 2, 'Ouverture de compte bancaire étudiant', 'retiree', '2026-08-10 15:00:00', '2026-08-12', '2026-08-12 09:40:00', '', null, 2],
        ['ATT-2026-0008', 4, 1, 'Demande de bourse nationale', 'en_cours', '2026-08-28 11:10:00', '2026-08-30', null, 'Urgent pour commission du mois', null, 1],
        ['ATT-2026-0009', 5, 5, 'Demande de Visa Concours', 'traitee', '2026-08-25 09:00:00', '2026-08-27', '2026-08-26 15:30:00', '', null, 2],
    ];

    $stmtDem = $db->prepare("INSERT INTO demandes (code_demande, user_id, type_id, objet, statut, date_demande, date_prevue_retrait, date_traitement, observations, motif_refus, traite_par) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($demandesData as $d) {
        $stmtDem->execute($d);
    }

    echo "Demandes insérées.\n";

    // 4. Historiques des demandes
    $histData = [
        [1, null, 'en_attente', 'Demande soumise en ligne', null, '2026-08-15 09:30:00'],
        [1, 'en_attente', 'en_cours', 'Prise en charge par l\'agent', 1, '2026-08-16 08:45:00'],
        [1, 'en_cours', 'traitee', 'Attestation imprimée et signée', 1, '2026-08-17 11:00:00'],
        [1, 'traitee', 'retiree', 'Document remis à l\'étudiant', 1, '2026-08-17 14:20:00'],

        [2, null, 'en_attente', 'Demande soumise en ligne', null, '2026-08-20 14:15:00'],
        [2, 'en_attente', 'en_cours', 'En cours de vérification des notes', 1, '2026-08-21 10:00:00'],
        [2, 'en_cours', 'traitee', 'Attestation disponible au guichet', 1, '2026-08-24 10:20:00'],

        [3, null, 'en_attente', 'Demande soumise en ligne', null, '2026-08-27 10:00:00'],
        [3, 'en_attente', 'en_cours', 'Vérification auprès de la scolarité', 2, '2026-08-28 09:15:00'],

        [4, null, 'en_attente', 'Demande en attente de traitement', null, '2026-08-28 16:45:00'],
        [5, null, 'en_attente', 'Demande en attente de traitement', null, '2026-08-29 08:30:00'],

        [6, null, 'en_attente', 'Demande soumise', null, '2026-08-18 11:20:00'],
        [6, 'en_attente', 'refusee', 'Frais non régularisés', 1, '2026-08-19 15:10:00'],

        [7, null, 'en_attente', 'Demande soumise', null, '2026-08-10 15:00:00'],
        [7, 'en_attente', 'traitee', 'Certificat prêt', 2, '2026-08-12 09:40:00'],
        [7, 'traitee', 'retiree', 'Document récupéré', 2, '2026-08-12 11:00:00'],
    ];

    $stmtHist = $db->prepare("INSERT INTO historique_demandes (demande_id, ancien_statut, nouveau_statut, commentaire, agent_id, date_changement) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($histData as $h) {
        $stmtHist->execute($h);
    }

    echo "Historique inséré.\n";

    // 5. Retraits
    $retraitsData = [
        [1, '2026-08-17 14:20:00', 'Rakoto Haja', 1],
        [7, '2026-08-12 11:00:00', 'Randria Toky', 2],
    ];

    $stmtRet = $db->prepare("INSERT INTO retraits (demande_id, date_retrait, nom_receveur, agent_id) VALUES (?, ?, ?, ?)");
    foreach ($retraitsData as $r) {
        $stmtRet->execute($r);
    }

    echo "Retraits insérés.\n";
    echo "Base de données initialisée avec succès avec données de démonstration complets !\n";

} catch (Exception $e) {
    echo "Erreur lors du seeding : " . $e->getMessage() . "\n";
}

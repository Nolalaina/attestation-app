<?php
require_once ROOT_PATH . '/app/core/Model.php';

class Demande extends Model
{
    /** Génère un numéro de demande lisible du type ATT-2026-000123 */
    private function generateCode(): string
    {
        $year = date('Y');
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM demandes WHERE YEAR(date_demande) = ?"
        );
        $stmt->execute([$year]);
        $count = (int) $stmt->fetchColumn() + 1;
        return sprintf('ATT-%s-%06d', $year, $count);
    }

    public function create(int $userId, int $typeId, string $objet, ?string $observations, int $delaiJours): int
    {
        $code = $this->generateCode();
        $datePrevue = date('Y-m-d', strtotime('+' . $delaiJours . ' weekdays'));

        $stmt = $this->db->prepare(
            'INSERT INTO demandes (code_demande, user_id, type_id, objet, observations, date_prevue_retrait)
             VALUES (:code, :user_id, :type_id, :objet, :observations, :date_prevue)'
        );
        $stmt->execute([
            'code'         => $code,
            'user_id'      => $userId,
            'type_id'      => $typeId,
            'objet'        => $objet,
            'observations' => $observations,
            'date_prevue'  => $datePrevue,
        ]);
        $demandeId = (int) $this->db->lastInsertId();

        $this->logHistorique($demandeId, null, 'en_attente', 'Demande soumise par l\'étudiant', null);

        return $demandeId;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, t.nom AS type_nom, t.delai_traitement_j,
                    u.nom AS etudiant_nom, u.prenom AS etudiant_prenom, u.matricule, u.filiere, u.niveau, u.email
             FROM demandes d
             JOIN types_attestation t ON t.id = d.type_id
             JOIN users u ON u.id = d.user_id
             WHERE d.id = ?'
        );
        $stmt->execute([$id]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function findByCode(string $code): ?array
    {
        $stmt = $this->db->prepare('SELECT id FROM demandes WHERE code_demande = ?');
        $stmt->execute([$code]);
        $r = $stmt->fetch();
        return $r ? $this->find((int) $r['id']) : null;
    }

    /** Historique/suivi des demandes d'un étudiant */
    public function findByUser(int $userId): array
    {
        $stmt = $this->db->prepare(
            'SELECT d.*, t.nom AS type_nom
             FROM demandes d
             JOIN types_attestation t ON t.id = d.type_id
             WHERE d.user_id = ?
             ORDER BY d.date_demande DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /** Registre de suivi (admin) avec filtres et pagination */
    public function search(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        [$where, $params] = $this->buildWhere($filters);

        $sql = "SELECT d.*, t.nom AS type_nom, u.nom AS etudiant_nom, u.prenom AS etudiant_prenom, u.matricule
                FROM demandes d
                JOIN types_attestation t ON t.id = d.type_id
                JOIN users u ON u.id = d.user_id
                $where
                ORDER BY d.date_demande DESC
                LIMIT $limit OFFSET $offset";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function count(array $filters = []): int
    {
        [$where, $params] = $this->buildWhere($filters);
        $sql = "SELECT COUNT(*) FROM demandes d
                JOIN types_attestation t ON t.id = d.type_id
                JOIN users u ON u.id = d.user_id
                $where";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    private function buildWhere(array $filters): array
    {
        $clauses = [];
        $params = [];

        if (!empty($filters['statut'])) {
            $clauses[] = 'd.statut = :statut';
            $params['statut'] = $filters['statut'];
        }
        if (!empty($filters['type_id'])) {
            $clauses[] = 'd.type_id = :type_id';
            $params['type_id'] = $filters['type_id'];
        }
        if (!empty($filters['q'])) {
            $clauses[] = '(u.nom LIKE :q OR u.prenom LIKE :q OR u.matricule LIKE :q OR d.code_demande LIKE :q)';
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['date_debut'])) {
            $clauses[] = 'DATE(d.date_demande) >= :date_debut';
            $params['date_debut'] = $filters['date_debut'];
        }
        if (!empty($filters['date_fin'])) {
            $clauses[] = 'DATE(d.date_demande) <= :date_fin';
            $params['date_fin'] = $filters['date_fin'];
        }

        $where = $clauses ? 'WHERE ' . implode(' AND ', $clauses) : '';
        return [$where, $params];
    }

    public function updateStatut(int $id, string $nouveauStatut, ?int $agentId, ?string $commentaire = null): void
    {
        $current = $this->find($id);
        if (!$current) {
            return;
        }

        $extra = '';
        $params = [
            'statut'   => $nouveauStatut,
            'agent_id' => $agentId,
            'id'       => $id,
        ];

        if ($nouveauStatut === 'traitee') {
            $extra = ', date_traitement = NOW()';
        }
        if ($nouveauStatut === 'refusee') {
            $extra = ', motif_refus = :motif';
            $params['motif'] = $commentaire ?? 'Non spécifié';
        }

        $stmt = $this->db->prepare(
            "UPDATE demandes SET statut = :statut, traite_par = :agent_id $extra WHERE id = :id"
        );
        $stmt->execute($params);

        $this->logHistorique($id, $current['statut'], $nouveauStatut, $commentaire, $agentId);
    }

    public function historique(int $demandeId): array
    {
        $stmt = $this->db->prepare(
            'SELECT h.*, u.nom AS agent_nom, u.prenom AS agent_prenom
             FROM historique_demandes h
             LEFT JOIN users u ON u.id = h.agent_id
             WHERE h.demande_id = ?
             ORDER BY h.date_changement ASC'
        );
        $stmt->execute([$demandeId]);
        return $stmt->fetchAll();
    }

    private function logHistorique(int $demandeId, ?string $ancien, string $nouveau, ?string $commentaire, ?int $agentId): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO historique_demandes (demande_id, ancien_statut, nouveau_statut, commentaire, agent_id)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$demandeId, $ancien, $nouveau, $commentaire, $agentId]);
    }

    /** Compteurs pour les cartes du tableau de bord */
    public function countByStatut(): array
    {
        $stmt = $this->db->query('SELECT statut, COUNT(*) AS total FROM demandes GROUP BY statut');
        $result = ['en_attente' => 0, 'en_cours' => 0, 'traitee' => 0, 'refusee' => 0, 'retiree' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['statut']] = (int) $row['total'];
        }
        return $result;
    }

    public function totalCount(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM demandes')->fetchColumn();
    }

    /** Statistiques hebdomadaires (semaine ISO) pour les N dernières semaines */
    public function statsHebdomadaires(int $semaines = 6): array
    {
        $stmt = $this->db->prepare(
            "SELECT
                YEARWEEK(date_demande, 3) AS semaine_cle,
                MIN(DATE(date_demande)) AS semaine_debut,
                COUNT(*) AS total,
                SUM(statut = 'traitee' OR statut = 'retiree') AS traitees,
                SUM(statut = 'en_cours' OR statut = 'en_attente') AS en_cours,
                SUM(statut = 'refusee') AS refusees
             FROM demandes
             GROUP BY semaine_cle
             ORDER BY semaine_cle DESC
             LIMIT ?"
        );
        $stmt->bindValue(1, $semaines, PDO::PARAM_INT);
        $stmt->execute();
        return array_reverse($stmt->fetchAll());
    }

    /** Répartition des demandes par type d'attestation */
    public function statsParType(): array
    {
        $stmt = $this->db->query(
            "SELECT t.nom, COUNT(d.id) AS total
             FROM types_attestation t
             LEFT JOIN demandes d ON d.type_id = t.id
             GROUP BY t.id
             ORDER BY total DESC"
        );
        return $stmt->fetchAll();
    }

    public function delete(int $id): void
    {
        $this->db->prepare('DELETE FROM demandes WHERE id = ? AND statut = "en_attente"')->execute([$id]);
    }
}

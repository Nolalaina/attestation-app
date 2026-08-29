<?php
require_once ROOT_PATH . '/app/core/Model.php';

class Retrait extends Model
{
    public function create(int $demandeId, string $nomReceveur, int $agentId): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO retraits (demande_id, nom_receveur, agent_id) VALUES (?, ?, ?)'
        );
        $stmt->execute([$demandeId, $nomReceveur, $agentId]);
        return (int) $this->db->lastInsertId();
    }

    public function findByDemande(int $demandeId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT r.*, u.nom AS agent_nom, u.prenom AS agent_prenom
             FROM retraits r
             LEFT JOIN users u ON u.id = r.agent_id
             WHERE r.demande_id = ?'
        );
        $stmt->execute([$demandeId]);
        $r = $stmt->fetch();
        return $r ?: null;
    }
}

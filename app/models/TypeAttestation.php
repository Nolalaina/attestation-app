<?php
require_once ROOT_PATH . '/app/core/Model.php';

class TypeAttestation extends Model
{
    public function all(bool $actifOnly = true): array
    {
        $sql = 'SELECT * FROM types_attestation';
        if ($actifOnly) {
            $sql .= ' WHERE actif = 1';
        }
        $sql .= ' ORDER BY nom ASC';
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM types_attestation WHERE id = ?');
        $stmt->execute([$id]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function create(string $nom, ?string $description, int $delai): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO types_attestation (nom, description, delai_traitement_j) VALUES (?, ?, ?)'
        );
        $stmt->execute([$nom, $description, $delai]);
        return (int) $this->db->lastInsertId();
    }

    public function toggleActif(int $id): void
    {
        $this->db->prepare('UPDATE types_attestation SET actif = NOT actif WHERE id = ?')->execute([$id]);
    }
}

<?php
require_once ROOT_PATH . '/app/core/Model.php';

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }

    public function matriculeExists(string $matricule): bool
    {
        $stmt = $this->db->prepare('SELECT id FROM users WHERE matricule = ? LIMIT 1');
        $stmt->execute([$matricule]);
        return (bool) $stmt->fetch();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (role, nom, prenom, email, mot_de_passe, matricule, filiere, niveau, telephone)
             VALUES (:role, :nom, :prenom, :email, :mot_de_passe, :matricule, :filiere, :niveau, :telephone)'
        );
        $stmt->execute([
            'role'         => $data['role'] ?? 'etudiant',
            'nom'          => $data['nom'],
            'prenom'       => $data['prenom'],
            'email'        => $data['email'],
            'mot_de_passe' => password_hash($data['mot_de_passe'], PASSWORD_BCRYPT),
            'matricule'    => $data['matricule'] ?? null,
            'filiere'      => $data['filiere'] ?? null,
            'niveau'       => $data['niveau'] ?? null,
            'telephone'    => $data['telephone'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function verifyPassword(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }

    public function countByRole(string $role): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM users WHERE role = ?');
        $stmt->execute([$role]);
        return (int) $stmt->fetchColumn();
    }

    public function updateProfile(int $id, string $telephone, ?string $filiere = null, ?string $niveau = null): void
    {
        $stmt = $this->db->prepare('UPDATE users SET telephone = ?, filiere = COALESCE(?, filiere), niveau = COALESCE(?, niveau) WHERE id = ?');
        $stmt->execute([$telephone, $filiere, $niveau, $id]);
    }

    public function updatePassword(int $id, string $newPassword): void
    {
        $stmt = $this->db->prepare('UPDATE users SET mot_de_passe = ? WHERE id = ?');
        $stmt->execute([password_hash($newPassword, PASSWORD_BCRYPT), $id]);
    }
}

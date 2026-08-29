<?php
/**
 * Model - classe de base pour tous les modèles
 */
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}

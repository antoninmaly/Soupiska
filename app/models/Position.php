<?php

class Position {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Metoda pro získání všech pozic
    public function getAllPositions() {
        $stmt = $this->db->prepare("SELECT * FROM positions ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
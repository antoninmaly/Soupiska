<?php

class Player {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    public function create(
        string $first_name,
        string $last_name,
        int $position_id,
        string $club,
        int $jersey_number,
        string $birth_date,
        float $market_value,
        string $nationality,
        string $description,
        array $images,
        int $userId
    ): bool {
        $sql = "INSERT INTO players (first_name, last_name, position_id, club, jersey_number, birth_date, market_value, nationality, description, images, created_by)
                VALUES (:first_name, :last_name, :position_id, :club, :jersey_number, :birth_date, :market_value, :nationality, :description, :images, :created_by)";
        
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':position_id' => $position_id,
            ':club' => $club,
            ':jersey_number' => $jersey_number,
            ':birth_date' => $birth_year,
            ':market_value' => $market_value,
            ':nationality' => $nationality,
            ':description' => $description,
            ':images' => json_encode($images),
            ':created_by' => $userId
        ]);
    }

    // Získání všech hráčů z databáze (včetně názvu pozice)
    public function getAll() {
        $sql = "SELECT players.*, positions.name AS position_name 
                FROM players 
                LEFT JOIN positions ON players.position_id = positions.id 
                ORDER BY players.id DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získání jednoho konkrétního hráče podle ID
    public function getById($id) {
        $sql = "SELECT * FROM players WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Aktualizace existujícího hráče
    public function update(
        $id, $first_name, $last_name, $position_id, $club, 
        $jersey_number, $birth_date, $market_value, $nationality, $description, $images = []
    ) {
        $sql = "UPDATE players 
                SET first_name = :first_name, 
                    last_name = :last_name, 
                    position_id = :position_id, 
                    club = :club,
                    jersey_number = :jersey_number, 
                    birth_date = :birth_date, 
                    market_value = :market_value, 
                    nationality = :nationality, 
                    description = :description, 
                    images = :images
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':position_id' => $position_id,
            ':club' => $club,
            ':jersey_number' => $jersey_number,
            ':birth_date' => $birth_date,
            ':market_value' => $market_value,
            ':nationality' => $nationality,
            ':description' => $description,
            ':images' => json_encode($images)
        ]);
    }

    // Trvalé smazání hráče z databáze
    public function delete($id) {
        $sql = "DELETE FROM players WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([':id' => $id]);
    }
}
<?php
class Comment {
    private $db;
    private $table_name = "comments";

    public function __construct($db) {
        $this->db = $db;
    }

    // Načtení všech komentářů k jednomu hráči (včetně jména autora)
    public function getByPlayerId($player_id) {
        $query = "SELECT c.*, u.username, u.first_name, u.last_name, u.nickname 
                  FROM " . $this->table_name . " c
                  JOIN users u ON c.user_id = u.id
                  WHERE c.player_id = :player_id
                  ORDER BY c.created_at DESC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':player_id', $player_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Načtení jednoho konkrétního komentáře (např. pro kontrolu práv před úpravou)
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vytvoření komentáře (nyní s volitelným parent_id pro odpovědi)
    public function create($player_id, $user_id, $content, $parent_id = null) {
        $query = "INSERT INTO " . $this->table_name . " (player_id, user_id, content, parent_id) VALUES (:player_id, :user_id, :content, :parent_id)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':player_id', $player_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':content', htmlspecialchars($content));
        $stmt->bindParam(':parent_id', $parent_id);
        
        return $stmt->execute();
    }

    // Úprava komentáře
    public function update($id, $content) {
        $query = "UPDATE " . $this->table_name . " SET content = :content WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':content', htmlspecialchars($content));
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Smazání komentáře
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
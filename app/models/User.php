<?php

class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // 1. Registrace nového uživatele (nyní přijímá i jméno, příjmení a přezdívku)
    public function register(
            string $username, 
            string $email, 
            string $password, 
            ?string $firstName = null, 
            ?string $lastName = null, 
            ?string $nickname = null
        ): bool {
        // Kontrola, zda uživatel s tímto emailem už neexistuje
        if ($this->findByEmail($email)) {
            return false; // Email už je zabraný
        }

        // ZABEZPEČENÍ: Vytvoření bezpečného hashe z hesla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL dotaz rozšířen o nová pole
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, nickname) 
                VALUES (:username, :email, :password, :first_name, :last_name, :nickname)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword, // Do DB ukládáme hash, nikoliv čisté heslo!
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':nickname' => $nickname
        ]);
    }

    // 2. Nalezení uživatele podle emailu (použijeme při přihlašování)
    public function findByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        // Vrátí pole s daty uživatele, nebo false pokud neexistuje
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // 3. Získání uživatele podle ID (hodí se pro zobrazení profilu atd.)
    public function findById(int $id) {
        // Zde jsme také přidali nová pole, aby se nám při načtení profilu vypsalo všechno
        $sql = "SELECT id, username, email, first_name, last_name, nickname, created_at FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Načtení všech uživatelů pro administraci
    public function getAllUsers() {
        $query = "SELECT id, username, email, first_name, last_name, nickname, is_admin FROM users ORDER BY is_admin DESC, username ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Získání dat jednoho uživatele podle ID
    public function getById($id) {
        $query = "SELECT id, username, email, first_name, last_name, nickname, is_admin FROM users WHERE id = :id LIMIT 0,1";
        // Změna: používáme $this->db místo $this->conn
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 6. Aktualizace profilových údajů uživatele
    public function updateProfile($id, $first_name, $last_name, $nickname, $email) {
        $query = "UPDATE users 
                  SET first_name = :first_name, last_name = :last_name, nickname = :nickname, email = :email 
                  WHERE id = :id";
        
        // Změna: používáme $this->db místo $this->conn
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':first_name', htmlspecialchars($first_name));
        $stmt->bindParam(':last_name', htmlspecialchars($last_name));
        $stmt->bindParam(':nickname', htmlspecialchars($nickname));
        $stmt->bindParam(':email', htmlspecialchars($email));
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // 7. Smazání uživatele z databáze
    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        // Změna: používáme $this->db místo $this->conn
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
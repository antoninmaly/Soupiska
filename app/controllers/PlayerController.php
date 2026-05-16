<?php

class PlayerController {

    // 0. Výchozí metoda pro zobrazení úvodní stránky (výpis hráčů)
    public function index() {
        // Načtení potřebných tříd
        require_once '../app/models/Database.php';
        require_once '../app/models/Player.php';

        // Vytvoření připojení k databázi
        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu a získání dat
        $playerModel = new Player($db);
        $players = $playerModel->getAll(); // Proměnná $players nyní obsahuje pole všech hráčů
        
        // Načte se (vloží) připravený soubor s HTML strukturou
        require_once '../app/views/players/players_list.php';
    }


    // 1. Zobrazení formuláře pro přidání nového hráče
    public function create() {
        // Autorizace: Pokud uživatel není přihlášen, nemá tu co dělat
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro přidání hráče se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // Načtení databáze a modelu pro pozice
        require_once '../app/models/Database.php';
        require_once '../app/models/Position.php';

        $database = new Database();
        $db = $database->getConnection();

        // Získání seznamu pozic (bude potřeba pro výběrové menu ve formuláři)
        $positionModel = new Position($db);
        $positions = $positionModel->getAllPositions();
        
        // Zde se pouze načte (vloží) připravený soubor s HTML formulářem
        require_once '../app/views/players/player_create.php';
    }

    // 2. Zpracování dat odeslaných z formuláře
    public function store() {
        // Kontrola, zda byl formulář odeslán metodou POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Kontrola přihlášení
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení hráče musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            
            $userId = $_SESSION['user_id'];

            // 1. Získání a očištění textových dat (ochrana proti XSS)
            $first_name = htmlspecialchars($_POST['first_name'] ?? '');
            $last_name = htmlspecialchars($_POST['last_name'] ?? '');
            $club = htmlspecialchars($_POST['club'] ?? '');
            $nationality = htmlspecialchars($_POST['nationality'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            
            // U číselných hodnot se provádí explicitní přetypování
            $position_id = (int)($_POST['position_id'] ?? 0);
            $jersey_number = (int)($_POST['jersey_number'] ?? 0);
            $birth_date = htmlspecialchars($_POST['birth_date'] ?? '');
            $market_value = (float)($_POST['market_value'] ?? 0);

            // Zavolání metody, která zpracuje soubory v $_FILES
            // Vrátí nám hezké pole s novými názvy (např. ['player_123.jpg', 'player_456.png'])
            $uploadedImages = $this->processImageUploads();

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Database.php';
            require_once '../app/models/Player.php';

            // Vytvoření připojení k DB
            $database = new Database();
            $db = $database->getConnection();

            // Vytvoření objektu hráče a volání metody pro uložení
            $playerModel = new Player($db);
            $isSaved = $playerModel->create(
                $first_name, $last_name, $position_id, $club, $jersey_number, 
                $birth_date, $market_value, $nationality, $description, $uploadedImages, $userId
            );

            // 3. Vyhodnocení výsledku a přesměrování
            if ($isSaved) {
                // Vyvolání zelené notifikace pro úspěšnou akci
                $this->addSuccessMessage('Hráč byl úspěšně přidán na soupisku.');
                
                // Přesměrování zpět na hlavní stránku s využitím dynamické BASE_URL
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Vyvolání červené notifikace pro kritické selhání
                $this->addErrorMessage('Nastala chyba. Nepodařilo se uložit hráče do databáze.');
            }
            
        } else {
            // Pokud je stránka navštívena napřímo bez odeslání dat, zobrazí se žlutá informativní zpráva
            $this->addNoticeMessage('Pro přidání hráče je nutné odeslat formulář.');
        }
    }

    // 3. Smazání existujícího hráče
    public function delete($id = null) {
        // Kontrola autentizace. 
        // Pouze přihlášený uživatel může iniciovat proces mazání.
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání hráče se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        // Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID hráče ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Player.php';

        $database = new Database();
        $db = $database->getConnection();
        $playerModel = new Player($db);

        // Kontrola autorizace (vlastnictví).
        // Nejdříve musíme hráče načíst, abychom zjistili, kdo ho vytvořil.
        $player = $playerModel->getById($id);

        if (!$player) {
            $this->addErrorMessage('Hráč nebyl nalezen, pravděpodobně již byl smazán.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Zjistíme, zda je přihlášený uživatel admin
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

        // Vyhodíme uživatele POKUD NENÍ autor A ZÁROVEŇ NENÍ admin
        if ($player['created_by'] !== $_SESSION['user_id'] && !$isAdmin) {
            $this->addErrorMessage('Nemáte oprávnění mazat tohoto hráče.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Teprve po úspěšném ověření totožnosti provedeme samotné smazání.
        $isDeleted = $playerModel->delete($id);

        // Vyhodnocení výsledku a přesměrování s notifikací
        if ($isDeleted) {
            $this->addSuccessMessage('Hráč byl trvale smazán ze soupisky.');
        } else {
            $this->addErrorMessage('Nastala chyba. Hráče se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 4. Zobrazení formuláře pro úpravu existujícího hráče
    public function edit($id = null) {
        // Kontrola, zda je uživatel přihlášen. 
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu hráče se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        
        // Kontrola, zda bylo v URL vůbec předáno nějaké ID
        if (!$id) {
            // Vyvolání červené notifikace pro kritickou chybu
            $this->addErrorMessage('Nebylo zadáno ID hráče k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Player.php';
        require_once '../app/models/Position.php';

        $database = new Database();
        $db = $database->getConnection();

        // Získání seznamu pozic
        $positionModel = new Position($db);
        $positions = $positionModel->getAllPositions();

        // Získání dat o konkrétním hráči
        $playerModel = new Player($db);
        $player = $playerModel->getById($id); // Proměnná $player nyní obsahuje asociativní pole dat

        // Bezpečnostní kontrola: Zda hráč s daným ID vůbec existuje
        if (!$player) {
            $this->addErrorMessage('Požadovaný hráč nebyl v databázi nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Zjistíme, zda je přihlášený uživatel admin
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

        // Kontrola vlastnictví (Autorizace).
        // Ověříme, zda ID přihlášeného uživatele odpovídá ID autora uloženého u hráče.
        if ($player['created_by'] !== $_SESSION['user_id'] && !$isAdmin) {
            $this->addErrorMessage('Nemáte oprávnění upravovat tohoto hráče.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pokud je vše v pořádku, načte se připravený soubor s HTML formulářem pro úpravy.
        // Šablona bude mít automaticky přístup k proměnné $player.
        require_once '../app/views/players/player_edit.php';
    }

    // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null) {
        // Zabezpečení: Je k dispozici ID a byl odeslán formulář?
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID hráče k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Kontrola, zda je uživatel vůbec přihlášen.
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení změn se musíte nejprve přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }

            // Komunikaci s databází musíme řešit předem.
            // Musíme totiž nejprve zjistit, kdo hráče přidal, než cokoli změníme.
            require_once '../app/models/Database.php';
            require_once '../app/models/Player.php';

            $database = new Database();
            $db = $database->getConnection();
            $playerModel = new Player($db);

            $player = $playerModel->getById($id);

            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

            // Kontrola vlastnictví (Autorizace) - "Skutečná zeď".
            // Pokud hráč neexistuje, nebo ID autora nesouhlasí s přihlášeným uživatelem, je nutné ukládání přerušit.
            if (!$player || ($player['created_by'] !== $_SESSION['user_id'] && !$isAdmin)) {
                $this->addErrorMessage('Nemáte oprávnění ukládat změny u tohoto hráče.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // --- POKUD KONTROLY PROŠLY, POKRAČUJEME VE ZPRACOVÁNÍ DAT ---

            // 1. Získání a očištění textových dat
            $first_name = htmlspecialchars($_POST['first_name'] ?? '');
            $last_name = htmlspecialchars($_POST['last_name'] ?? '');
            $club = htmlspecialchars($_POST['club'] ?? '');
            $nationality = htmlspecialchars($_POST['nationality'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');
            
            // Přetypování číselných hodnot
            $position_id = (int)($_POST['position_id'] ?? 0);
            $jersey_number = (int)($_POST['jersey_number'] ?? 0);
            $birth_date = htmlspecialchars($_POST['birth_date'] ?? '');
            $market_value = (float)($_POST['market_value'] ?? 0);

            // Zavolání metody, která zpracuje soubory v $_FILES
            $uploadedImages = $this->processImageUploads();
            
            // Pokud uživatel při úpravě nenahrál nové obrázky, zachováme mu ty původní
            if (empty($uploadedImages) && !empty($player['images'])) {
                $uploadedImages = json_decode($player['images'], true) ?: [];
            }

            // 3. Volání updatu nad modelem
            $isUpdated = $playerModel->update(
                $id, $first_name, $last_name, $position_id, $club, 
                $jersey_number, $birth_date, $market_value, $nationality, $description, $uploadedImages
            );

            // 4. Vyhodnocení výsledku a přesměrování
            if ($isUpdated) {
                // Vyvolání zelené notifikace o úspěchu
                $this->addSuccessMessage('Změny byly úspěšně uloženy.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Vyvolání červené chybové notifikace
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }
            
        } else {
            // Pokud by někdo zkusil přistoupit na URL napřímo bez odeslání formuláře (žlutá notifikace)
            $this->addNoticeMessage('Pro úpravu hráče je nutné odeslat formulář.');
        }
    }

    // 6. Zobrazení detailu jednoho konkrétního hráče
    public function show($id = null) {
        // Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID hráče pro zobrazení detailu.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Player.php';
        require_once '../app/models/Position.php'; // Přidali jsme načtení modelu pozic

        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu a získání dat o konkrétním hráči podle ID
        $playerModel = new Player($db);
        $player = $playerModel->getById($id); 

        // Bezpečnostní kontrola: Zda hráč s daným ID vůbec existuje
        if (!$player) {
            $this->addErrorMessage('Požadovaný hráč nebyl v databázi nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Vytáhneme si všechny pozice a najdeme tu, která odpovídá position_id hráče
        $positionModel = new Position($db);
        $positions = $positionModel->getAllPositions();
        
        $player['position_name'] = 'Nezařazeno';
        foreach ($positions as $pos) {
            if ($pos['id'] == $player['position_id']) {
                $player['position_name'] = $pos['name'];
                break; // Jakmile najdeme shodu, cyklus ukončíme
            }
        }

        // Načtení připraveného souboru s HTML profilem hráče
        require_once '../app/views/players/player_show.php';
    }

    // --- Pomocné metody pro systém notifikací ---

    protected function addSuccessMessage($message) {
        // Zelená zpráva o úspěchu
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        // Žlutá informativní zpráva
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        // Červená chybová zpráva
        $_SESSION['messages']['error'][] = $message;
    }

    // --- Pomocná metoda pro zpracování nahrávání obrázků ---
    protected function processImageUploads() {
        $uploadedFiles = [];
        
        // Cesta ke složce, kam se budou obrázky fyzicky ukládat (relativně od index.php)
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        // Zkontrolujeme, zda vůbec existuje adresář, pokud ne, vytvoříme ho
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Zkontrolujeme, zda byl odeslán alespoň jeden soubor
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                // Pokud při nahrávání tohoto konkrétního souboru nedošlo k chybě
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    // Zjištění koncovky (např. jpg, png)
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    // Můžeme zde přidat i kontrolu povolených formátů (volitelné)
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        continue; // Přeskočíme nepodporovaný soubor
                    }

                    // 1. Vygenerování unikátního jména pomocí aktuálního času a náhodného řetězce
                    // např: player_64a2b1c_8f2a.jpg
                    $newName = 'player_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    // 2. Fyzický přesun souboru z dočasné paměti do naší složky uploads
                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        // 3. Uložení POUZE NÁZVU do pole, které pak pošleme databázi
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }
}
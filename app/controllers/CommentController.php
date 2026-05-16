<?php
class CommentController {

    // 1. Přidání nového komentáře
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            require_once '../app/models/Database.php';
            require_once '../app/models/Comment.php';

            $db = (new Database())->getConnection();
            $commentModel = new Comment($db);

            $player_id = (int)$_POST['player_id'];
            $content = trim($_POST['content']);
            // Zachytíme ID rodičovského komentáře, pokud jde o odpověď
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

            if (!empty($content)) {
                // Předáváme i parent_id
                $commentModel->create($player_id, $_SESSION['user_id'], $content, $parent_id);
                $_SESSION['messages']['success'][] = "Komentář byl přidán.";
            } else {
                $_SESSION['messages']['error'][] = "Komentář nemůže být prázdný.";
            }
            
            // Přesměrujeme zpět na detail hráče
            header('Location: ' . BASE_URL . '/index.php?url=player/show/' . $player_id);
            exit;
        }
    }

    // 2. Smazání komentáře (s kontrolou práv)
    public function delete($id = null) {
        if (!$id || !isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';

        $db = (new Database())->getConnection();
        $commentModel = new Comment($db);

        $comment = $commentModel->getById($id);
        if (!$comment) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $player_id = $comment['player_id'];
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

        // PRAVIDLO: Smazat může jen autor (user_id se shoduje) NEBO Administrátor
        if ($_SESSION['user_id'] == $comment['user_id'] || $isAdmin) {
            $commentModel->delete($id);
            $_SESSION['messages']['success'][] = "Komentář byl úspěšně smazán.";
        } else {
            $_SESSION['messages']['error'][] = "Nemáte oprávnění smazat cizí komentář.";
        }

        header('Location: ' . BASE_URL . '/index.php?url=player/show/' . $player_id);
        exit;
    }

    // 3. Zobrazení formuláře pro úpravu (Pouze pro autora)
        public function edit($id = null) {
            if (!$id || !isset($_SESSION['user_id'])) {
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            require_once '../app/models/Database.php';
            require_once '../app/models/Comment.php';

            $db = (new Database())->getConnection();
            $commentModel = new Comment($db);

            $comment = $commentModel->getById($id);

            // PRAVIDLO: Úpravu může provést POUZE autor komentáře
            if (!$comment || $_SESSION['user_id'] != $comment['user_id']) {
                $_SESSION['messages']['error'][] = "Můžete upravovat pouze své vlastní komentáře.";
                header('Location: ' . BASE_URL . '/index.php' . ($comment ? '?url=player/show/' . $comment['player_id'] : ''));
                exit;
            }

            require_once '../app/views/comments/edit.php';
        }

    // 4. Zpracování úpravy komentáře
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            require_once '../app/models/Database.php';
            require_once '../app/models/Comment.php';

            $db = (new Database())->getConnection();
            $commentModel = new Comment($db);

            $id = (int)$_POST['id'];
            $player_id = (int)$_POST['player_id'];
            $content = trim($_POST['content']);

            $comment = $commentModel->getById($id);

            // Znovu bezpečnostní kontrola, že to posílá autor
            if ($comment && $_SESSION['user_id'] == $comment['user_id']) {
                if (!empty($content)) {
                    $commentModel->update($id, $content);
                    $_SESSION['messages']['success'][] = "Komentář byl úspěšně upraven.";
                } else {
                    $_SESSION['messages']['error'][] = "Komentář nemůže být prázdný.";
                }
            }
            
            header('Location: ' . BASE_URL . '/index.php?url=player/show/' . $player_id);
            exit;
        }
    }

}
?>
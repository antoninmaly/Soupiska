<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Profil hráče (Plain)</title>
</head>
<body>
    <header>
        <h1>FC Soupiska - Karta hráče</h1>
        <nav>
            <a href="<?= BASE_URL ?>/index.php">Zpět na seznam</a>
        </nav>
    </header>

    <main>
        <h2><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></h2>
        
        <ul>
            <li><strong>Klub:</strong> <?= htmlspecialchars($player['club']) ?></li>
            <li><strong>Pozice:</strong> <?= htmlspecialchars($player['position_name'] ?? 'Nezadáno') ?></li>
            <li><strong>Číslo dresu:</strong> #<?= htmlspecialchars($player['jersey_number']) ?></li>
            <li><strong>Rok narození:</strong> <?= htmlspecialchars($player['birth_year']) ?></li>
            <li><strong>Národnost:</strong> <?= htmlspecialchars($player['nationality']) ?></li>
            <li><strong>Tržní hodnota:</strong> <?= htmlspecialchars($player['market_value']) ?> €</li>
        </ul>

        <h3>Manažerský popis:</h3>
        <p><?= nl2br(htmlspecialchars($player['description'])) ?></p>

        <h3>Fotogalerie:</h3>
        <?php 
        if (!empty($player['images_json'])) {
            $images = json_decode($player['images_json'], true);
            if (is_array($images)) {
                foreach ($images as $img) {
                    echo '<img src="' . BASE_URL . '/uploads/' . htmlspecialchars($img) . '" width="200" style="margin-right:10px;"><br><br>';
                }
            }
        } else {
            echo '<p>Žádné fotografie nebyly nahrány.</p>';
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2026 FC Soupiska - Verze bez stylů</p>
    </footer>
</body>
</html>
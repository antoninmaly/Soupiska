<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit hráče (Plain)</title>
</head>
<body>
    <header>
        <h1>FC Soupiska - Editace</h1>
        <nav>
            <a href="<?= BASE_URL ?>/index.php">Zpět na seznam</a>
        </nav>
    </header>

    <main>
        <h2>Upravit data hráče: <?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></h2>
        
        <form action="<?= BASE_URL ?>/index.php?url=player/update/<?= htmlspecialchars($player['id']) ?>" method="post" enctype="multipart/form-data">
            <div>
                <label for="first_name">Jméno *:</label><br>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($player['first_name']) ?>" required>
            </div>
            <br>
            <div>
                <label for="last_name">Příjmení *:</label><br>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($player['last_name']) ?>" required>
            </div>
            <br>
            <div>
                <label for="club">Klub *:</label><br>
                <input type="text" id="club" name="club" value="<?= htmlspecialchars($player['club']) ?>" required>
            </div>
            <br>
            <div>
                <label for="position_id">Pozice *:</label><br>
                <select id="position_id" name="position_id" required>
                    <?php foreach ($positions as $pos): ?>
                        <?php $selected = ($player['position_id'] == $pos['id']) ? 'selected' : ''; ?>
                        <option value="<?= htmlspecialchars($pos['id']) ?>" <?= $selected ?>>
                            <?= htmlspecialchars($pos['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div>
                <label for="jersey_number">Číslo dresu *:</label><br>
                <input type="number" id="jersey_number" name="jersey_number" value="<?= htmlspecialchars($player['jersey_number']) ?>" required>
            </div>
            <br>
            <div>
                <label for="birth_year">Rok narození *:</label><br>
                <input type="number" id="birth_year" name="birth_year" value="<?= htmlspecialchars($player['birth_year']) ?>" required>
            </div>
            <br>
            <div>
                <label for="market_value">Tržní hodnota (€):</label><br>
                <input type="number" id="market_value" name="market_value" step="0.1" value="<?= htmlspecialchars($player['market_value']) ?>">
            </div>
            <br>
            <div>
                <label for="nationality">Národnost:</label><br>
                <input type="text" id="nationality" name="nationality" value="<?= htmlspecialchars($player['nationality']) ?>">
            </div>
            <br>
            <div>
                <label for="description">Poznámka / Popis:</label><br>
                <textarea id="description" name="description" rows="4" cols="50"><?= htmlspecialchars($player['description']) ?></textarea>
            </div>
            <br>
            <div>
                <label for="images">Změnit fotografie (nechejte prázdné pro zachování stávajících):</label><br>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
            </div>
            <br>
            <div>
                <button type="submit">Uložit změny</button>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2026 FC Soupiska - Verze bez stylů</p>
    </footer>
</body>
</html>
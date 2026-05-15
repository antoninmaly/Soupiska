<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat hráče (Plain)</title>
</head>
<body>
    <header>
        <h1>FC Soupiska - Správa hráčů</h1>
        <nav>
            <a href="<?= BASE_URL ?>/index.php">Zpět na seznam</a>
        </nav>
    </header>

    <main>
        <h2>Přidat nového hráče na soupisku</h2>
        <p>Vyplňte základní údaje o fotbalistovi.</p>

        <form action="<?= BASE_URL ?>/index.php?url=player/store" method="post" enctype="multipart/form-data">
            <div>
                <label for="first_name">Jméno *:</label><br>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <br>
            <div>
                <label for="last_name">Příjmení *:</label><br>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <br>
            <div>
                <label for="club">Klub *:</label><br>
                <input type="text" id="club" name="club" required>
            </div>
            <br>
            <div>
                <label for="position_id">Pozice *:</label><br>
                <select id="position_id" name="position_id" required>
                    <option value="">-- Vyberte pozici --</option>
                    <?php foreach ($positions as $pos): ?>
                        <option value="<?= htmlspecialchars($pos['id']) ?>">
                            <?= htmlspecialchars($pos['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            <div>
                <label for="jersey_number">Číslo dresu *:</label><br>
                <input type="number" id="jersey_number" name="jersey_number" required min="1" max="99">
            </div>
            <br>
            <div>
                <label for="birth_year">Rok narození *:</label><br>
                <input type="number" id="birth_year" name="birth_year" required>
            </div>
            <br>
            <div>
                <label for="market_value">Tržní hodnota (€):</label><br>
                <input type="number" id="market_value" name="market_value" step="0.1">
            </div>
            <br>
            <div>
                <label for="nationality">Národnost:</label><br>
                <input type="text" id="nationality" name="nationality">
            </div>
            <br>
            <div>
                <label for="description">Poznámka / Popis:</label><br>
                <textarea id="description" name="description" rows="4" cols="50"></textarea>
            </div>
            <br>
            <div>
                <label for="images">Fotografie hráče:</label><br>
                <input type="file" id="images" name="images[]" multiple accept="image/*">
            </div>
            <br>
            <div>
                <button type="submit">Uložit hráče</button>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2026 FC Soupiska - Verze bez stylů</p>
    </footer>
</body>
</html>
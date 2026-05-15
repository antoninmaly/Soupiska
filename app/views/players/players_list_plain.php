<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soupiska - Seznam hráčů</title>
</head>
<body>
    <header>
        <h1>Aplikace Soupiska</h1>
        
        <nav>
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php">Aktuální soupiska (Domů)</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?url=player/create">Přidat nového hráče</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="notifications-container">
                
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $color = 'black';
                        if ($type === 'success') $color = 'green';
                        if ($type === 'error') $color = 'red';
                        if ($type === 'notice') $color = 'orange';
                    ?>
                    
                    <?php foreach ($messages as $message): ?>
                        <div style="color: <?= $color ?>; border: 1px solid <?= $color ?>; padding: 10px; margin-bottom: 10px;">
                            <strong><?= htmlspecialchars($message) ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                
            </div>
            
            <?php unset($_SESSION['messages']); ?>
        <?php endif; ?>

        <h2>Dostupní hráči na soupisce</h2>
        
        <?php if (empty($players)): ?>
            <p>V databázi se zatím nenachází žádní hráči.</p>
        <?php else: ?>
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>Číslo dresu</th>
                        <th>Jméno a Příjmení</th>
                        <th>Klub</th>
                        <th>Pozice</th>
                        <th>Ročník narození</th>
                        <th>Akce</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player): ?>
                        <tr>
                            <td><?= htmlspecialchars($player['jersey_number']) ?></td>
                            <td><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></td>
                            <td><?= htmlspecialchars($player['club']) ?></td>
                            <td><?= htmlspecialchars($player['position_name'] ?? 'Nezařazeno') ?></td>
                            <td><?= htmlspecialchars($player['birth_year']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/index.php?url=player/edit/<?= $player['id'] ?>">Upravit</a> | 
                                <a href="<?= BASE_URL ?>/index.php?url=player/delete/<?= $player['id'] ?>" onclick="return confirm('Opravdu chcete tohoto hráče smazat?')">Smazat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; WA 2026 - Soupiska </p>
    </footer>
</body>
</html>
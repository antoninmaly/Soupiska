<?php require_once '../app/views/layout/header.php'; ?>    

    <main class="container mx-auto px-6 py-10">
        
        <div class="flex justify-between items-end mb-6">
            <h2 class="text-3xl font-light tracking-widest text-slate-200 uppercase">Dostupné knihy</h2>
        </div>
        
        <div class="bg-slate-800/50 border border-slate-700 rounded-xl overflow-hidden shadow-2xl backdrop-blur-sm">
            <?php if (empty($books)): ?>
                <div class="p-10 text-center text-slate-500 italic">
                    V databázi se zatím nenachází žádné knihy.
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-700/50 border-b border-slate-600">
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-slate-200 tracking-wider text-center">ID</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-slate-200 tracking-wider">Název knihy</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-slate-200 tracking-wider">Autor</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-slate-200 tracking-wider">Kategorie</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-slate-200 tracking-wider">Rok</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-slate-200 tracking-wider text-right">Cena</th>
                                <th class="px-6 py-4 font-semibold uppercase text-xs text-slate-200 tracking-wider text-center">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            <?php foreach ($books as $book): ?>
                                <tr class="hover:bg-slate-700/30 transition-colors group">
                                    <td class="px-6 py-4 text-center text-slate-500 text-sm italic"><?= htmlspecialchars($book['id']) ?></td>
                                    <td class="px-6 py-4 font-medium text-white group-hover:text-blue-400"><?= htmlspecialchars($book['title']) ?></td>
                                    <td class="px-6 py-4 text-slate-300"><?= htmlspecialchars($book['author']) ?></td>
                                    <td class="px-6 py-4 text-emerald-400 font-medium">
                                        <?= htmlspecialchars($book['category_name'] ?? 'Nezařazeno') ?>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 font-mono"><?= htmlspecialchars($book['year']) ?></td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-200"><?= htmlspecialchars($book['price']) ?> Kč</td>
                                                                        <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-3 text-sm">
                                            
                                            <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-blue-400 hover:text-white transition-colors underline decoration-blue-800 underline-offset-4">Detail</a>
                                            
                                            <?php 
                                            // 💡 ZMĚNA: Kontrola administrátora pro frontend
                                            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                                            
                                            // Tlačítka zobrazíme POKUD je autor NEBO je admin
                                            if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] === $book['created_by'] || $isAdmin)): 
                                            ?>
                                                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-emerald-400 hover:text-white transition-colors underline decoration-emerald-800 underline-offset-4">Upravit</a>
                                                <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')" class="text-rose-400 hover:text-white transition-colors underline decoration-rose-800 underline-offset-4">Smazat</a>
                                            <?php endif; ?>
                                            
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php require_once '../app/views/layout/footer.php'; ?>    
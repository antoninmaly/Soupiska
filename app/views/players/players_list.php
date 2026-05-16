<?php require_once '../app/views/layout/header.php'; ?>    

    <main class="container mx-auto px-6 py-10 flex-grow">
        
        <div class="flex justify-between items-end mb-8 border-b border-gray-200 pb-4">
            <h2 class="text-4xl font-bold tracking-tight text-blue-900 uppercase">
                Aktuální soupiska
            </h2>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-xl">
            <?php if (empty($players)): ?>
                <div class="p-16 text-center text-gray-400 font-medium text-lg">
                    Kabina je prázdná. Přidej prvního hráče na soupisku!
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-50 border-b border-blue-100 text-blue-800">
                                <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider text-center w-16">#</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Hráč</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Klub</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Národnost</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Pozice</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Datum narození</th>
                                <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider text-center">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($players as $player): ?>
                                <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-800 font-bold font-mono text-sm border border-blue-200">
                                            <?= htmlspecialchars($player['jersey_number']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 text-lg group-hover:text-blue-700 transition-colors">
                                            <a href="<?= BASE_URL ?>/index.php?url=player/show/<?= $player['id'] ?>" class="hover:underline">
                                                <?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 font-medium whitespace-nowrap">
                                        <?= htmlspecialchars($player['club']) ?>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-slate-700 whitespace-nowrap">
                                        <?= !empty($player['nationality']) ? htmlspecialchars($player['nationality']) : '---' ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block whitespace-nowrap bg-blue-100/50 text-blue-800 px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider border border-blue-200">
                                            <?= htmlspecialchars($player['position_name'] ?? 'Nezařazeno') ?>
                                        </span>
                                    </td>
                                   <td class="px-6 py-4 text-slate-500 font-mono font-medium">
                                        <?= !empty($player['birth_date']) ? htmlspecialchars(date('j.n.Y', strtotime($player['birth_date']))) : '---' ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center space-x-2 text-xs font-semibold">
                                            <a href="<?= BASE_URL ?>/index.php?url=player/show/<?= $player['id'] ?>" class="text-slate-500 hover:text-blue-700 transition-colors px-1 py-1">Detail</a>
                                            
                                            <?php 
                                            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                                            
                                            // 1. HRÁČ JE MŮJ (Vytvořil jsem ho já) -> Výrazná plně vybarvená tlačítka
                                            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $player['created_by']): 
                                            ?>
                                                <a href="<?= BASE_URL ?>/index.php?url=player/edit/<?= $player['id'] ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded transition-colors shadow-sm">Upravit</a>
                                                <a href="<?= BASE_URL ?>/index.php?url=player/delete/<?= $player['id'] ?>" onclick="return confirm('Opravdu chceš tohoto hráče vyřadit ze soupisky?')" class="bg-rose-500 hover:bg-rose-600 text-white px-2 py-1 rounded transition-colors shadow-sm">Smazat</a>
                                                
                                            <?php 
                                            // 2. HRÁČ NENÍ MŮJ, ALE JSEM ADMIN -> Zobrazí se jako "průhledná" obrysová tlačítka
                                            elseif ($isAdmin): 
                                            ?>
                                                <a href="<?= BASE_URL ?>/index.php?url=player/edit/<?= $player['id'] ?>" class="border border-blue-400 text-blue-500 hover:bg-blue-50 px-2 py-1 rounded transition-colors">Upravit</a>
                                                <a href="<?= BASE_URL ?>/index.php?url=player/delete/<?= $player['id'] ?>" onclick="return confirm('Jako administrátor mažete cizího hráče. Pokračovat?')" class="border border-rose-400 text-rose-500 hover:bg-rose-50 px-2 py-1 rounded transition-colors">Smazat</a>
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
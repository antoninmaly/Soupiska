<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
            <a href="<?= BASE_URL ?>/index.php" class="text-blue-600 hover:text-blue-800 transition-colors text-sm font-bold uppercase tracking-wider">&larr; Zpět na soupisku</a>
            
            <div class="flex space-x-4 text-sm font-bold uppercase tracking-wider">
                <?php 
                $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] === $player['created_by'] || $isAdmin)): 
                ?>
                    <a href="<?= BASE_URL ?>/index.php?url=player/edit/<?= $player['id'] ?>" class="text-blue-600 hover:text-blue-800 transition-colors">Upravit profil</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-12">
            
            <div class="md:col-span-4 bg-slate-100 p-6 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-200">
                <?php 
                // Bezpečné dekódování fotek z DB
                $images = [];
                if (!empty($player['images_json'])) {
                    $images = json_decode($player['images_json'], true);
                }
                ?>

                <?php if (!empty($images) && is_array($images)): ?>
                    <div class="w-full aspect-[3/4] rounded-2xl overflow-hidden shadow-md border border-gray-200 bg-white mb-4">
                        <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($images[0]) ?>" 
                             alt="Profilové foto" class="w-full h-full object-cover">
                    </div>
                    
                    <?php if (count($images) > 1): ?>
                        <div class="grid grid-cols-4 gap-2 w-full">
                            <?php foreach ($images as $img): ?>
                                <div class="aspect-square rounded-md overflow-hidden border border-gray-300 bg-white cursor-pointer hover:border-blue-500 transition-colors">
                                    <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="w-full aspect-[3/4] rounded-2xl bg-slate-200 flex flex-col items-center justify-center border border-gray-300 text-slate-400 p-4 text-center">
                        <span class="text-6xl mb-2">🏃‍♂️</span>
                        <span class="text-xs font-bold uppercase tracking-wide">Bez fotografie</span>
                    </div>
                <?php endif; ?>

                <div class="mt-6 text-center">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest block mb-1">Číslo dresu</span>
                    <span class="inline-block bg-blue-900 text-white font-mono font-black text-4xl px-6 py-2 rounded-2xl shadow-md">
                        #<?= htmlspecialchars($player['jersey_number']) ?>
                    </span>
                </div>
            </div>

            <div class="md:col-span-8 p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <div class="mb-6">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-md text-xs font-black uppercase tracking-widest border border-blue-200">
                            <?= htmlspecialchars($player['position_name'] ?? 'Nezařazeno') ?>
                        </span>
                        <h1 class="text-4xl font-black text-blue-900 uppercase mt-2 tracking-tight">
                            <?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?>
                        </h1>
                        <p class="text-slate-500 font-medium text-lg mt-1">Klub: <strong class="text-slate-800"><?= htmlspecialchars($player['club']) ?></strong></p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 border-t border-b border-gray-100 py-6 my-6">
                        <div>
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Národnost</span>
                            <span class="text-slate-800 font-bold text-lg">
                                <?= !empty($player['nationality']) ? htmlspecialchars($player['nationality']) : '---' ?>
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Rok narození</span>
                            <span class="text-slate-800 font-mono font-bold text-lg"><?= htmlspecialchars($player['birth_year']) ?></span>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Tržní hodnota</span>
                            <span class="text-emerald-600 font-bold text-lg">
                                <?= !empty($player['market_value']) ? '€ ' . htmlspecialchars($player['market_value']) . 'M' : 'Nezadána' ?>
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xs font-black text-blue-900 uppercase tracking-wider mb-2">Profil a manažerské poznámky</h3>
                        <div class="bg-slate-50 border border-gray-100 rounded-2xl p-4 text-slate-700 italic text-sm leading-relaxed">
                            <?php if (!empty($player['description'])): ?>
                                <?= nl2br(htmlspecialchars($player['description'])) ?>
                            <?php else: ?>
                                <span class="text-slate-400">K tomuto hráči zatím nebyly doplněny žádné podrobnější taktické poznámky ani hodnocení.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 mt-6 flex justify-between text-[11px] text-slate-400 font-medium">
                    <span>ID hráče: #<?= htmlspecialchars($player['id']) ?></span>
                    <span>Vytvořil uživatel ID: <?= htmlspecialchars($player['created_by']) ?></span>
                </div>

            </div>
        </div>
        
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
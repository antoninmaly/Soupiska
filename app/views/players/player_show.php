<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
            <a href="<?= BASE_URL ?>/index.php" class="text-blue-600 hover:text-blue-800 transition-colors text-sm font-bold uppercase tracking-wider">&larr; Zpět na soupisku</a>
            
            <div class="flex space-x-4 text-sm font-bold uppercase tracking-wider">
                <?php 
                // Nejdřív ověříme, zda je uživatel vůbec přihlášený
                if (isset($_SESSION['user_id'])): 
                    $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                    
                    // Tlačítko uvidí pouze ten, kdo hráče vytvořil, NEBO administrátor
                    if ($_SESSION['user_id'] == $player['created_by'] || $isAdmin): 
                ?>
                        <a href="<?= BASE_URL ?>/index.php?url=player/edit/<?= $player['id'] ?>" class="text-blue-600 hover:text-blue-800 transition-colors">Upravit profil</a>
                <?php 
                    endif;
                endif; 
                ?>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-12">
            
            <div class="md:col-span-4 bg-slate-100 p-6 pt-10 flex flex-col items-center justify-start border-b md:border-b-0 md:border-r border-gray-200">
                <?php 
                // Bezpečné dekódování fotek z DB z formátu JSON na PHP pole
                $images = [];
                $dbImagesData = $player['images'] ?? $player['images_json'] ?? '';

                if (!empty($dbImagesData)) {
                    $decoded = json_decode($dbImagesData, true);
                    if (is_array($decoded)) {
                        $images = $decoded;
                    }
                }
                ?>

                <?php if (!empty($images)): ?>
                    <div class="w-full aspect-[3/4] rounded-2xl overflow-hidden shadow-md border border-gray-200 bg-white mb-4">
                        <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($images[0]) ?>" 
                             alt="Profilové foto" class="w-full h-full object-cover">
                    </div>
                    
                    <?php if (count($images) > 1): ?>
                        <div class="grid grid-cols-4 gap-2 w-full mt-2">
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
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Datum narození</span>
                            <span class="text-slate-800 font-mono font-bold text-lg">
                                <?= !empty($player['birth_date']) ? htmlspecialchars(date('j.n.Y', strtotime($player['birth_date']))) : '---' ?>
                            </span>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <span class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-0.5">Tržní hodnota</span>
                            <span class="text-emerald-600 font-bold text-lg">
                                <?= !empty($player['market_value']) ? '€ ' . htmlspecialchars($player['market_value']) . 'M' : 'Nezadána' ?>
                            </span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xs font-black text-blue-900 uppercase tracking-wider mb-2">Popis hráče</h3>
                        <div class="bg-slate-50 border border-gray-100 rounded-2xl p-4 text-slate-700 italic text-sm leading-relaxed">
                            <?php if (!empty($player['description'])): ?>
                                <?= nl2br(htmlspecialchars($player['description'])) ?>
                            <?php else: ?>
                                <span class="text-slate-400">K tomuto hráči zatím nebyly doplněny žádné podrobnější taktické poznámky.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between text-[11px] text-slate-400 font-medium">
                    <span>Vytvořil uživatel: 
                        <strong class="text-slate-500">
                            <?php 
                            if (!empty($player['user_nickname'])) {
                                echo htmlspecialchars($player['user_nickname']);
                            } elseif (!empty($player['user_first_name'])) {
                                echo htmlspecialchars($player['user_first_name'] . ' ' . $player['user_last_name']);
                            } else {
                                echo htmlspecialchars($player['username'] ?? 'Neznámý trenér');
                            }
                            ?>
                        </strong>
                    </span>
                    <span>&nbsp;</span>
                </div>

                <div class="border-t border-gray-200 mt-10 pt-8">
                    <h3 class="text-xl font-black text-blue-900 uppercase tracking-tight mb-6">Komentáře</h3>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                        $mainComments = [];
                        $replies = [];
                        if (!empty($comments)) {
                            foreach ($comments as $c) {
                                if (empty($c['parent_id'])) {
                                    $mainComments[$c['id']] = $c;
                                    $mainComments[$c['id']]['replies'] = [];
                                } else {
                                    $replies[] = $c;
                                }
                            }
                            // Přidání odpovědí k jejich rodičům (seřadíme od nejstarších pro lepší čtení vlákna)
                            foreach (array_reverse($replies) as $r) {
                                if (isset($mainComments[$r['parent_id']])) {
                                    $mainComments[$r['parent_id']]['replies'][] = $r;
                                }
                            }
                        }
                        ?>

                        <div class="space-y-6 mb-8">
                            <?php if (!empty($mainComments)): ?>
                                <?php foreach ($mainComments as $c): ?>
                                    
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 relative group">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <span class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($c['nickname'] ?: ($c['first_name'] . ' ' . $c['last_name'])) ?></span>
                                                <span class="text-xs text-slate-400 ml-2"><?= date('j.n.Y H:i', strtotime($c['created_at'])) ?></span>
                                            </div>
                                            
                                            <div class="flex space-x-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button type="button" onclick="toggleReply(<?= $c['id'] ?>)" class="text-emerald-600 hover:text-emerald-800 text-xs font-bold transition-colors">Odpovědět</button>
                                                <?php $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1; ?>
                                                <?php if ($_SESSION['user_id'] == $c['user_id']): ?>
                                                    <button type="button" onclick="toggleEdit(<?= $c['id'] ?>)" class="text-blue-500 hover:text-blue-700 text-xs font-bold transition-colors">Upravit</button>
                                                <?php endif; ?>
                                                <?php if ($_SESSION['user_id'] == $c['user_id'] || $isAdmin): ?>
                                                    <a href="<?= BASE_URL ?>/index.php?url=comment/delete/<?= $c['id'] ?>" onclick="return confirm('Opravdu smazat?')" class="text-rose-500 hover:text-rose-700 text-xs font-bold transition-colors">Smazat</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div id="comment-view-<?= $c['id'] ?>">
                                            <p class="text-slate-600 text-sm leading-relaxed"><?= nl2br(htmlspecialchars($c['content'])) ?></p>
                                        </div>

                                        <div id="comment-edit-<?= $c['id'] ?>" class="hidden mt-2">
                                            <form action="<?= BASE_URL ?>/index.php?url=comment/update" method="POST">
                                                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                                <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                                                <textarea name="content" rows="2" required class="w-full bg-white border border-blue-200 rounded-xl px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-1 focus:ring-blue-500"><?= htmlspecialchars($c['content']) ?></textarea>
                                                <div class="mt-2 flex justify-end space-x-2">
                                                    <button type="button" onclick="toggleEdit(<?= $c['id'] ?>)" class="text-xs font-bold px-3 py-1.5 text-slate-500">Zrušit</button>
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-4 rounded">Uložit změny</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div id="comment-reply-<?= $c['id'] ?>" class="hidden mt-3 pt-3 border-t border-slate-200">
                                            <form action="<?= BASE_URL ?>/index.php?url=comment/store" method="POST" class="flex gap-2">
                                                <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                                                <input type="hidden" name="parent_id" value="<?= $c['id'] ?>">
                                                <input type="text" name="content" required placeholder="Napište odpověď..." class="w-full bg-white border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors shadow-sm">Odeslat</button>
                                            </form>
                                        </div>
                                    </div>

                                    <?php if (!empty($c['replies'])): ?>
                                        <div class="ml-12 pl-4 border-l-2 border-blue-100 space-y-3 mt-[-10px]">
                                            <?php foreach ($c['replies'] as $reply): ?>
                                                <div class="bg-white border border-slate-200 rounded-xl p-3 relative group shadow-sm">
                                                    <div class="flex justify-between items-start mb-1">
                                                        <div>
                                                            <span class="font-bold text-slate-800 text-xs"><?= htmlspecialchars($reply['nickname'] ?: ($reply['first_name'] . ' ' . $reply['last_name'])) ?></span>
                                                            <span class="text-[10px] text-slate-400 ml-2"><?= date('j.n. H:i', strtotime($reply['created_at'])) ?></span>
                                                        </div>
                                                        <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <?php if ($_SESSION['user_id'] == $reply['user_id']): ?>
                                                                <button type="button" onclick="toggleEdit(<?= $reply['id'] ?>)" class="text-blue-500 hover:text-blue-700 text-[10px] font-bold">Upravit</button>
                                                            <?php endif; ?>
                                                            <?php if ($_SESSION['user_id'] == $reply['user_id'] || $isAdmin): ?>
                                                                <a href="<?= BASE_URL ?>/index.php?url=comment/delete/<?= $reply['id'] ?>" onclick="return confirm('Smazat odpověď?')" class="text-rose-500 hover:text-rose-700 text-[10px] font-bold">Smazat</a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <div id="comment-view-<?= $reply['id'] ?>">
                                                        <p class="text-slate-600 text-xs leading-relaxed"><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
                                                    </div>

                                                    <div id="comment-edit-<?= $reply['id'] ?>" class="hidden mt-2">
                                                        <form action="<?= BASE_URL ?>/index.php?url=comment/update" method="POST" class="flex gap-2">
                                                            <input type="hidden" name="id" value="<?= $reply['id'] ?>">
                                                            <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                                                            <input type="text" name="content" required value="<?= htmlspecialchars($reply['content']) ?>" class="w-full bg-slate-50 border border-slate-300 rounded px-2 py-1 text-xs">
                                                            <button type="submit" class="bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded">Uložit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center p-6 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400 text-sm">
                                    Zatím nebyly přidány žádné komentáře.
                                </div>
                            <?php endif; ?>
                        </div>

                        <form action="<?= BASE_URL ?>/index.php?url=comment/store" method="POST" class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                            <input type="hidden" name="player_id" value="<?= $player['id'] ?>">
                            <label for="content" class="block text-xs font-bold text-blue-900 mb-2 uppercase tracking-wider">Přidat nový komentář</label>
                            <textarea id="content" name="content" rows="3" required
                                      class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all resize-none placeholder-slate-300"
                                      placeholder="Napište hodnocení hráče, taktické tipy..."></textarea>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-6 rounded-xl text-sm transition-all shadow-md uppercase tracking-wider">
                                    Odeslat komentář
                                </button>
                            </div>
                        </form>

                    <?php else: ?>
                        <div class="bg-slate-100 border border-slate-200 rounded-2xl p-6 text-center text-slate-500 text-sm">
                            🔒 Obsah komentářů jsou přístupné pouze přihlášeným členům realizačního týmu. 
                            <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-blue-600 hover:text-blue-800 font-bold underline ml-1 transition-colors">Přihlaste se zde</a>.
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>

<script>
function toggleEdit(id) {
    const viewDiv = document.getElementById('comment-view-' + id);
    const editDiv = document.getElementById('comment-edit-' + id);
    
    // Přepínání viditelnosti
    if (viewDiv.classList.contains('hidden')) {
        viewDiv.classList.remove('hidden');
        editDiv.classList.add('hidden');
    } else {
        viewDiv.classList.add('hidden');
        editDiv.classList.remove('hidden');
    }
}
function toggleReply(id) {
    const replyDiv = document.getElementById('comment-reply-' + id);
    if (replyDiv.classList.contains('hidden')) {
        replyDiv.classList.remove('hidden');
    } else {
        replyDiv.classList.add('hidden');
    }
}
</script>
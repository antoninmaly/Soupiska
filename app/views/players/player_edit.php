<?php require_once '../app/views/layout/header.php'; ?>    

    <main class="container mx-auto px-6 py-10 flex-grow">
        
        <div class="max-w-3xl mx-auto">
            <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 uppercase">
                        Upravit hráče <span class="text-blue-500"></span>
                    </h2>
                    <p class="text-slate-500 italic mt-1 text-sm">Provádíte změny u hráče: <strong class="text-blue-900"><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></strong></p>
                </div>
                <a href="<?= BASE_URL ?>/index.php" class="text-blue-600 hover:text-blue-800 transition-colors text-sm font-bold uppercase tracking-wider">&larr; Zpět</a>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-6 md:p-8">
                <form action="<?= BASE_URL ?>/index.php?url=player/update/<?= htmlspecialchars($player['id']) ?>" method="post" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="first_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Jméno <span class="text-rose-500">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($player['first_name']) ?>" required 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="last_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Příjmení <span class="text-rose-500">*</span></label>
                            <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($player['last_name']) ?>" required 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="club" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Klub <span class="text-rose-500">*</span></label>
                            <input type="text" id="club" name="club" value="<?= htmlspecialchars($player['club']) ?>" required 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>

                        <div>
                            <label for="position_id" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">
                                Pozice <span class="text-rose-500">*</span>
                            </label>
                            <select id="position_id" name="position_id" required 
                                    class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all appearance-none">
                                <?php foreach ($positions as $pos): ?>
                                    <?php $selected = ($player['position_id'] == $pos['id']) ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($pos['id']) ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($pos['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label for="nationality" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Národnost<span class="text-rose-500">*</span></label>
                            <input type="text" id="nationality" name="nationality" value="<?= htmlspecialchars($player['nationality']) ?>" required
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>

                       <div>
                            <label for="birth_date" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Datum narození <span class="text-rose-500">*</span></label>
                            <input type="date" id="birth_date" name="birth_date" value="<?= htmlspecialchars($player['birth_date']) ?>" required 
                                class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="market_value" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Tržní hodnota (€)</label>
                            <input type="number" id="market_value" name="market_value" step="0.1" value="<?= htmlspecialchars($player['market_value']) ?>" 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="jersey_number" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Číslo dresu </label>
                            <input type="number" id="jersey_number" name="jersey_number" value="<?= htmlspecialchars($player['jersey_number']) ?>"  
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Popis hráče</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"><?= htmlspecialchars($player['description']) ?></textarea>
                        </div>

                        <?php 
                        $currentImages = [];
                        if (!empty($player['images'])) {
                            $decoded = json_decode($player['images'], true);
                            if (is_array($decoded)) {
                                $currentImages = $decoded;
                            }
                        }
                        ?>
                        <?php if (!empty($currentImages)): ?>
                            <div class="md:col-span-2 bg-blue-50/50 border border-blue-100 rounded-xl p-4 mb-2">
                                <label class="block text-xs font-bold text-blue-900 mb-3 uppercase tracking-wider">Aktuální fotografie hráče</label>
                                <div class="flex flex-wrap gap-4">
                                    <?php foreach ($currentImages as $img): ?>
                                        <div class="w-24 h-24 rounded-lg overflow-hidden border border-gray-300 shadow-sm bg-white">
                                            <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($img) ?>" alt="Náhled fotky" class="w-full h-full object-cover">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <p class="text-xs text-slate-500 mt-3 italic">Pokud níže nenahrajete žádné nové soubory, tyto fotografie zůstanou bezpečně zachovány.</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-blue-900 mb-2 uppercase tracking-wider">Změnit fotografii (ponechte prázdné, pokud nechcete měnit)</label>
                            <div class="w-full">
                                <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                        <span id="file-title" class="text-sm text-blue-800 font-bold">Vyberte nové soubory</span>
                                        <span id="file-info" class="text-xs text-slate-400 mt-1">Původní fotografie budou při nahrání nových přepsány</span>
                                    </div>
                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2 mt-4">
                            <button type="submit" 
                                    class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-4 px-4 rounded-xl shadow-lg transition-all uppercase tracking-widest text-sm">
                                Uložit změny v databázi
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <script>
            const fileInput = document.getElementById('images');
            const fileTitle = document.getElementById('file-title');
            const fileInfo = document.getElementById('file-info');

            fileInput.addEventListener('change', function(event) {
                const files = event.target.files;
                if (files.length > 0) {
                    fileTitle.textContent = files.length + ' souborů vybráno';
                    fileInfo.textContent = 'Nové soubory nahradí ty stávající';
                }
            });
        </script>
    </main>

<?php require_once '../app/views/layout/footer.php'; ?>
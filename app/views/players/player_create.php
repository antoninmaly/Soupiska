<?php require_once '../app/views/layout/header.php'; ?>

    <main class="container mx-auto px-6 py-10 flex-grow">
        
        <div class="max-w-3xl mx-auto">
            <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 uppercase">Přidat hráče</h2>
                    <p class="text-slate-500 italic mt-1 text-sm">Vyplňte údaje o novém fotbalistovi pro zařazení na soupisku.</p>
                </div>
                <a href="<?= BASE_URL ?>/index.php" class="text-blue-600 hover:text-blue-800 transition-colors text-sm font-bold uppercase tracking-wider">&larr; Zpět</a>
            </div>
            
            <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-6 md:p-8">
                <form action="<?= BASE_URL ?>/index.php?url=player/store" method="post" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="first_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Jméno <span class="text-rose-500">*</span></label>
                            <input type="text" id="first_name" name="first_name" required 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="last_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Příjmení <span class="text-rose-500">*</span></label>
                            <input type="text" id="last_name" name="last_name" required 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="club" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Klub <span class="text-rose-500">*</span></label>
                            <input type="text" id="club" name="club" required 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>

                        <div>
                            <label for="position_id" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">
                                Pozice <span class="text-rose-500">*</span>
                            </label>
                            <select id="position_id" name="position_id" required 
                                    class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all appearance-none">
                                <option value="" class="text-slate-400">-- Vyberte pozici --</option>
                                <?php foreach ($positions as $pos): ?>
                                    <option value="<?= htmlspecialchars($pos['id']) ?>">
                                        <?= htmlspecialchars($pos['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label for="jersey_number" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Číslo dresu <span class="text-rose-500">*</span></label>
                            <input type="number" id="jersey_number" name="jersey_number" required min="1" max="99"
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>

                        <div>
                            <label for="birth_year" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Rok narození <span class="text-rose-500">*</span></label>
                            <input type="number" id="birth_year" name="birth_year" required 
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="market_value" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Tržní hodnota (€)</label>
                            <input type="number" id="market_value" name="market_value" step="0.1" placeholder="Např. 12.5"
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div>
                            <label for="nationality" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Národnost</label>
                            <input type="text" id="nationality" name="nationality" placeholder="CZE"
                                   class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Popis hráče</label>
                            <textarea id="description" name="description" rows="4" 
                                      class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"></textarea>
                        </div>    
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-blue-900 mb-2 uppercase tracking-wider">Fotografie hráče</label>
                            <div class="w-full">
                                <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50 hover:border-blue-300 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                        <span id="file-title" class="text-sm text-blue-800 font-bold">Vyberte soubory (JPG, PNG)</span>
                                        <span id="file-info" class="text-xs text-slate-400 mt-1">Můžete nahrát více obrázků najednou</span>
                                    </div>
                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>
                                                
                        <div class="md:col-span-2 mt-4">
                            <button type="submit" 
                                    class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-4 px-4 rounded-xl shadow-lg transition-all uppercase tracking-widest text-sm">
                                Uložit hráče na soupisku
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
                if (files.length === 0) {
                    fileTitle.textContent = 'Vyberte soubory (JPG, PNG)';
                    fileInfo.textContent = 'Můžete nahrát více obrázků najednou';
                } else if (files.length === 1) {
                    fileTitle.textContent = '1 soubor vybrán';
                    fileInfo.textContent = files[0].name;
                } else {
                    fileTitle.textContent = files.length + ' souborů vybráno';
                    fileInfo.textContent = 'Soubory jsou připraveny k nahrání';
                }
            });
        </script>    
    </main>

<?php require_once '../app/views/layout/footer.php'; ?>
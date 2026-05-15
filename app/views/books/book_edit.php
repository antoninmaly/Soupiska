<?php require_once '../app/views/layout/header.php'; ?>    

    <main class="container mx-auto px-6 py-10 flex-grow">
        
        <div class="max-w-3xl mx-auto">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-light tracking-widest text-slate-200 uppercase">
                        Upravit knihu <span class="text-emerald-400 font-medium ml-2">#<?= htmlspecialchars($book['id']) ?></span>
                    </h2>
                    <p class="text-slate-200 italic mt-1 text-sm">Upravujete data pro knihu: <strong class="text-slate-300"><?= htmlspecialchars($book['title']) ?></strong></p>
                </div>
                <a href="<?= BASE_URL ?>/index.php" class="text-slate-100 hover:text-white transition-colors text-sm uppercase tracking-wider">&larr; Zpět</a>
            </div>
            
            <div class="bg-slate-800/50 border border-slate-400 rounded-xl shadow-2xl backdrop-blur-sm p-6 md:p-8">
                <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>" method="post" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="id_display" class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">ID v databázi</label>
                            <input type="text" id="id_display" value="<?= htmlspecialchars($book['id']) ?>" readonly 
                                   class="w-full bg-slate-900/80 border border-slate-700 rounded-md px-4 py-2 text-slate-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label for="title" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Název knihy <span class="text-rose-500">*</span></label>
                            <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-emerald-100 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="author" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Autor <span class="text-rose-500">*</span></label>
                            <input type="text" id="author" name="author" value="<?= htmlspecialchars($book['author']) ?>" required 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="isbn" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">ISBN <span class="text-rose-500">*</span></label>
                            <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>

                        <div>
                            <label for="year" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Rok vydání <span class="text-rose-500">*</span></label>
                            <input type="number" id="year" name="year" value="<?= htmlspecialchars($book['year']) ?>" required 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="category" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">
                                Kategorie <span class="text-rose-500">*</span>
                            </label>
                            <select id="category" name="category" required 
                                    class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors appearance-none">
                                <option value="" class="bg-slate-900">-- Vyberte kategorii --</option>
                                
                                <?php foreach ($categories as $cat): ?>
                                    <?php 
                                        // Porovnáme ID z databáze s ID v cyklu
                                        $isSelected = (isset($book['category']) && $book['category'] == $cat['id']) ? 'selected' : ''; 
                                    ?>
                                    <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $isSelected ?> class="bg-slate-900">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label for="subcategory" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Podkategorie</label>
                            <input type="text" id="subcategory" name="subcategory" value="<?= htmlspecialchars($book['subcategory']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="price" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Cena knihy (Kč)</label>
                            <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($book['price']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="link" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Odkaz</label>
                            <input type="text" id="link" name="link" value="<?= htmlspecialchars($book['link']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Popis knihy</label>
                            <textarea id="description" name="description" rows="5" 
                                      class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"><?= htmlspecialchars($book['description']) ?></textarea>
                        </div>    
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-100 mb-2 uppercase tracking-wider">Obrázky knihy</label>
                            <div class="w-full">
                                <label for="images" class="flex flex-col items-center justify-center w-full h-24 border-2 border-slate-400 border-dashed rounded-lg cursor-pointer bg-slate-800/30 hover:bg-slate-700/50 hover:border-blue-400 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <span id="file-title" class="text-sm text-slate-100 font-semibold">Klikni pro výběr souborů</span>
                                        <span id="file-info" class="text-xs text-slate-500 mt-1 text-center px-4">Žádné soubory nebyly vybrány</span>
                                    </div>
                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2 mt-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-bold py-3 px-4 rounded-md shadow-lg border border-emerald-500 transition-all uppercase tracking-widest text-sm">
                                Uložit změny do DB
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <script>
            // Najdeme naše HTML prvky podle ID
            const fileInput = document.getElementById('images');
            const fileTitle = document.getElementById('file-title');
            const fileInfo = document.getElementById('file-info');

            // Posloucháme událost 'change' (změna hodnoty v inputu)
            fileInput.addEventListener('change', function(event) {
                const files = event.target.files;
                
                if (files.length === 0) {
                    // Uživatel výběr zrušil
                    fileTitle.textContent = 'Klikněte pro výběr souborů';
                    fileTitle.className = 'text-sm text-slate-100 font-semibold';
                    fileInfo.textContent = 'Žádné soubory nebyly vybrány';
                } else if (files.length === 1) {
                    // Vybrán 1 soubor - ukážeme jeho název
                    fileTitle.textContent = 'Soubor připraven';
                    fileTitle.className = 'text-sm text-emerald-400 font-bold';
                    fileInfo.textContent = files[0].name;
                } else {
                    // Vybráno více souborů - ukážeme počet
                    fileTitle.textContent = 'Soubory připraveny';
                    fileTitle.className = 'text-sm text-emerald-400 font-bold';
                    fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
                }
            });
        </script>
    </main>

<?php require_once '../app/views/layout/footer.php'; ?>    
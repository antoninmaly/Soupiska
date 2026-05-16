<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="max-w-2xl mx-auto">
        
        <div class="mb-6 flex items-center justify-between border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-blue-900 uppercase">Profil Trenéra</h2>
                <p class="text-slate-500 italic mt-1 text-sm">Zde můžete spravovat své osobní údaje zobrazené v systému.</p>
            </div>
            <a href="<?= BASE_URL ?>/index.php" class="text-blue-600 hover:text-blue-800 transition-colors text-sm font-bold uppercase tracking-wider">&larr; Zpět na soupisku</a>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-6 md:p-8">
            <form action="<?= BASE_URL ?>/index.php?url=auth/updateProfile" method="post">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Přihlašovací jméno (nelze změnit)</label>
                        <input type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled 
                               class="w-full bg-slate-100 border border-gray-200 rounded-xl px-4 py-3 text-slate-400 cursor-not-allowed">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">E-mail <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="first_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Křestní jméno</label>
                        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="last_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="nickname" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Zobrazovaná přezdívka (Trenér)</label>
                        <input type="text" id="nickname" name="nickname" value="<?= htmlspecialchars($user['nickname'] ?? '') ?>" 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="md:col-span-2 border-t border-gray-100 pt-4 flex items-center justify-between text-xs text-slate-400">
                        <span>Systémová Role: 
                            <strong class="uppercase tracking-wider <?= ($user['is_admin'] == 1) ? 'text-amber-600' : 'text-blue-600' ?>">
                                <?= ($user['is_admin'] == 1) ? '⚙️ Administrátor' : '📋 Trenér' ?>
                            </strong>
                        </span>
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <button type="submit" 
                                class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-4 px-4 rounded-xl shadow-lg transition-all uppercase tracking-widest text-sm">
                            Uložit změny v profilu
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
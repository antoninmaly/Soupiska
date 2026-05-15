<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-12 flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl">
        <div class="mb-8 text-center">
            <h2 class="text-4xl font-bold tracking-tight text-blue-900 uppercase">Nová registrace</h2>
            <p class="text-slate-500 italic mt-2 text-sm">Staňte se koučem a začněte tvořit svou soupisku.</p>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-2xl shadow-2xl p-8">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <h3 class="text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] border-b border-gray-100 pb-2 mb-2">Přihlašovací údaje</h3>
                    </div>

                    <div>
                        <label for="username" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Uživatelské jméno <span class="text-rose-500">*</span></label>
                        <input type="text" id="username" name="username" required 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">E-mail <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" required 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Heslo <span class="text-rose-500">*</span></label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Potvrzení hesla <span class="text-rose-500">*</span></label>
                        <input type="password" id="password_confirm" name="password_confirm" required 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <h3 class="text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] border-b border-gray-100 pb-2 mb-2">Profilové informace</h3>
                    </div>

                    <div>
                        <label for="first_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Křestní jméno</label>
                        <input type="text" id="first_name" name="first_name" 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="last_name" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Příjmení</label>
                        <input type="text" id="last_name" name="last_name" 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="nickname" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Trenérská přezdívka</label>
                        <input type="text" id="nickname" name="nickname" placeholder="Jaké jméno uvidíme v hlavičce?"
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="md:col-span-2 mt-6">
                        <button type="submit" 
                                class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-4 px-4 rounded-xl shadow-lg transition-all uppercase tracking-widest text-sm">
                            Zaregistrovat se
                        </button>
                        <p class="text-center text-slate-400 text-sm mt-6">
                            Už jste v týmu? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-blue-600 font-bold hover:text-blue-800 transition-colors">Přihlaste se zde</a>.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>
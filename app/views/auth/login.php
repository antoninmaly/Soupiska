<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-12 flex-grow flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <h2 class="text-4xl font-bold tracking-tight text-blue-900 uppercase">Přihlášení</h2>
            <p class="text-slate-500 italic mt-2 text-sm">Vítejte na Soupisce. Prosím, vstupte.</p>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-2xl shadow-2xl p-8">
            <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post">
                
                <div class="space-y-6">
                    <div>
                        <label for="email" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">E-mail</label>
                        <input type="email" id="email" name="email" required autofocus
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-blue-900 mb-1.5 uppercase tracking-wider">Heslo</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-slate-50 border border-gray-300 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-blue-800 hover:bg-blue-900 text-white font-bold py-4 px-4 rounded-xl shadow-lg transition-all uppercase tracking-widest text-sm">
                            Vstoupit do kabiny
                        </button>
                    </div>
                    
                    <p class="text-center text-slate-400 text-sm border-t border-gray-100 pt-6">
                        Ještě nejste v týmu? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-blue-600 font-bold hover:text-blue-800 transition-colors">Zaregistrujte se</a>.
                    </p>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>